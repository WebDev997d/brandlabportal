<?php

namespace App\Chat\Events;

use App\Chat\Models\DirectMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DirectMessageCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(DirectMessage $message)
    {
        $this->message = $message;
        $this->user = auth()->user()->only(['id','avatar','username']);
        $this->dontBroadcastToCurrentUser();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('User.' . $this->message->receiver_id);
    }

    public function broadcastAs()
    {
        return 'directMessageCreated';
    }
}
