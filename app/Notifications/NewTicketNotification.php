<?php

namespace App\Notifications;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;


class NewTicketNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $ticket;

    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }
    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }


    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'ticket_id' => $this->ticket->id,
            'title' => $this->ticket->title,
            'user_id' => $this->ticket->user_id,
             'type' => 'Ticket created',
             'url' => url('/tickets/' . $this->ticket->id),

        ];
    }

  public function toBroadcast($notifiable)
{
    return new BroadcastMessage([
        'ticket_id' => $this->ticket->id,
        'title' => $this->ticket->title,
        'user_id' => $this->ticket->user_id,
        'url' => route('tickets.show', $this->ticket),
        'icon' => 'bi-ticket-detailed',
        'time' => now()->diffForHumans(),
        'type' => 'ticket.created',
        'url' => url('/tickets/' . $this->ticket->id),

    ]);
}

        public function broadcastType()
        {
            return 'ticket.created';
        }



    public function broadcastOn()
    {
        return [
            new PrivateChannel("tickets.supervisor.{$this->ticket->user->userable->supervisor_id}"),
            new PrivateChannel("App.Models.User.{$this->ticket->user_id}")
        ];
    }

    public function broadcastAs()
    {
        return 'ticket.created';
    }

}
