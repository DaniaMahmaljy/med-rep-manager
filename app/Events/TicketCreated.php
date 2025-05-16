<?php

namespace App\Events;

use App\Models\Ticket;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $ticket;

    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        $representative = $this->ticket->user->userable;
        $supervisorId = $representative->supervisor_id;


        return [
            new PrivateChannel("tickets.supervisor.{$supervisorId}"),
            new PrivateChannel("tickets.{$this->ticket->user_id}")
        ];
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->ticket->id,
            'title' => $this->ticket->title,
            'user_id' => $this->ticket->user_id,
        ];
    }

    public function broadcastAs()
    {
        return 'ticket.created';
    }
}
