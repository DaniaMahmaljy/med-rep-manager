<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Broadcasting\PrivateChannel;




class NewTicketReplyNotification extends Notification  implements ShouldBroadcast
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
     protected $reply;

    public function __construct($reply)
    {
        $this->reply = $reply;
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
        'ticket_id' => $this->reply->ticket->id,
        'reply_id' => $this->reply->id,
        'title' => $this->reply->ticket->title,
        'user_id' => $this->reply->ticket->user_id,
        'message' => $this->reply->reply,
        'type' => 'Ticket reply',
        'url' => url('/tickets/' . $this->reply->ticket->id),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
        'ticket_id' => $this->reply->ticket->id,
        'reply_id' => $this->reply->id,
        'title' => $this->reply->ticket->title,
        'user_id' => $this->reply->ticket->user_id,
        'message' => $this->reply->reply,
        'view_type' => 'Ticket reply',
        'url' => url('/tickets/' . $this->reply->ticket->id),
        ]);
    }

     public function broadcastType()
    {
        return 'ticket.reply';
    }

     public function broadcastOn()
    {

        $representative = $this->reply->ticket->user->userable;
        $supervisor = $representative->supervisor;
        $supervisorUser = $supervisor->user;

        if ($supervisorUser && $supervisorUser->id !== $this->reply->user_id) {
             $userId =  $supervisorUser->id;
        }

         if ($this->reply->user_id !== $this->reply->ticket->user_id) {
            $userId =  $this->reply->ticket->user->id;
        }

        return new PrivateChannel("tickets.{$userId}");
    }


    public function broadcastAs()
    {
        return 'ticket.reply';
    }



}
