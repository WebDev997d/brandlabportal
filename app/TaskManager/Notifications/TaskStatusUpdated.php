<?php

namespace App\TaskManager\Notifications;

use Illuminate\Bus\Queueable;
use App\TaskManager\Models\Task;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;

class TaskStatusUpdated extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;

    /**
     * @var string
     */
    public $groupType;

    /**
     * @var int
     */
    public $groupId;

    /**
     * @var Task
     */
    private $task;

    /**
     * @var User
     */
    private $creator;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Task $task, User $user)
    {
        $this->task = $task;
        $this->creator = $user;
        $this->groupType = $task->taskable_type;
        $this->groupId = $task->taskable_id;
        
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return config('notification.channels');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'subject'     => $this->creator->only(['id', 'name', 'username', 'avatar']),
            'action'      => 'Updated Task ',
            'object_type' => 'task',
            'object_name' => $this->task->name,
            'object_id'   => $this->task->id,
            'url'         => url($this->groupType . 's/' . $this->groupId . '?tool=tasks&id=' . $this->task->id),
            'task_status' => ' to ' . $this->task->status->name,
        ];
    }

    // public function toBroadcast($notifiable)
    // {
    //     return new BroadcastMessage([
    //         'data' => [
    //             'subject'     => $this->creator->only(['id', 'name', 'username', 'avatar']),
    //             'action'      => 'Updated Task',
    //             'object_type' => 'task',
    //             'object_name' => $this->task->name,
    //             'object_id'   => $this->task->id,
    //         ],
    //         'date' => 'Just Now',
    //     ]);    
    // }
}
