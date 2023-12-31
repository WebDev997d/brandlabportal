<?php

namespace App\Chat\Controllers;

use Exception;
use App\Base\Http\Controllers\Controller;
use App\Chat\Models\Message;
use App\Base\Utilities\GroupTrait;
use App\Chat\Events\MessageCreated;
use App\Base\Events\NotificationEvent;
use App\Chat\Events\MessageUpdated;
use App\Base\Repositories\MentionRepository;
use App\Chat\Repositories\MessageRepository;
use App\Chat\Requests\StoreMessageRequest;
use App\TaskManager\Models\Task;
use Illuminate\Support\Facades\Auth;
use App\TaskManager\Notifications\TaskCreated;
use App\TaskManager\Notifications\TaskStatusUpdated;

class MessageController extends Controller
{
    use GroupTrait;

    public function index(MessageRepository $repository)
    {
        try {
            $group = $this->getGroupModel();
            if ($group->notOpenForPublic()) {
                abort(401);
            } elseif (auth()->user()) {
                $this->authorize('view', $group);
            }
            $messages = $repository->getAllMessages(request('group_type'), request('group_id'));

            return response()->json([
                'status'   => 'success',
                'total'    => count($messages),
                'messages' => $messages,
            ]);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function store(StoreMessageRequest $request, MessageRepository $repository, MentionRepository $mentionRepository)
    {
        try {
            // $this->authorize('create', Message::class);
            $message = $repository->saveMessage([
                'body'             => $request->get('message'),
                'user_id'          => auth()->user()->id,
                'messageable_type' => $request->get('group_type'),
                'messageable_id'   => $request->get('group_id'),
            ]);
            if (request('mentions')) {
                $mentionRepository->create('message', $message);
            }
            event(new MessageCreated($message));
            $message->load('user');

            return response()->json([
                'status'  => 'success',
                'message' => $message,
            ]);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function update(Message $message, MentionRepository $mentionRepository)
    {
        try {
            $message->update(['body' => request('message')]);

            if (request('mentions')) {
                $mentionRepository->create('message', $message);
            }

            event(new MessageUpdated($message));

            $message->load('user');

            return response()->json([
                'status'  => 'success',
                'message' => $message,
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'status'  => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
    }

    public function delete(Message $message)
    {
        $message->delete();

        return response()->json([
            'status'  => 'success',
            'message' => localize('misc.Message has been deleted'),
        ]);
    }

    public function test()
    {
        dd('tasdfsdf');
        // event(new NotificationEvent('NEW MESSAGESDFADSFASDFSADFDFDF '));

        // Notification::send($this->getRecipients($task->taskable(), $task->created_by), new TaskCreated($task, $task->creator));

        // return "sdafdsfsdfdf";
    }
}
