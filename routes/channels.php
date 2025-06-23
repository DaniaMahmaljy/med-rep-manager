<?php

use App\Models\Supervisor;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('tickets.{userId}', function ($user, $userId) {
    if ($user->id === (int) $userId) {
        return true;
    }

    if ($user->userable instanceof Supervisor) {
        return $user->userable->representatives()
            ->whereHas('user', function ($query) use ($userId) {
                $query->where('id', $userId);
            })->exists();
    }

    return false;
});

Broadcast::channel('ticketreplies.{ticketId}', function ($user, $ticketId) {
    $ticket = Ticket::find($ticketId);

    if (! $ticket) {
        return false;
    }

    if ($ticket->user_id === $user->id) {
        return true;
    }

    if ($user->userable instanceof Supervisor) {
        return $user->userable->representatives()
            ->whereHas('user', function ($query) use ($ticket) {
                $query->where('id', $ticket->user_id);
            })
            ->exists();
    }

    return false;
});
