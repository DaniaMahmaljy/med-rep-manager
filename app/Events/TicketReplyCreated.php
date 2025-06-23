<?php

namespace App\Events;

use App\Models\TicketReply;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketReplyCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */

    protected $reply;

    public function __construct($reply)
    {
        $this->reply = $reply;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('ticketreplies.' . $this->reply->ticket_id),
        ];
    }

    public function broadcastAs()
    {
        return 'ticket.reply.created';
    }


    public function broadcastWith()
    {
        return [
            'id' => $this->reply->id,
            'user' => $this->reply->user->full_name,
            'reply' => $this->reply->reply,
            'created_at' => $this->reply->created_at->format('M d, Y H:i'),
        ];
    }
}
