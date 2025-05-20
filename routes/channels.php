<?php

use App\Models\Supervisor;
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
