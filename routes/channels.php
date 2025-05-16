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

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('tickets.supervisor.{supervisorId}', function ($user, $supervisorId) {
    return $user->userable_type === Supervisor::class
        && $user->userable_id == $supervisorId;
});

Broadcast::channel('tickets.{userId}', function ($user, $userId) {
    if ((int) $user->id === (int) $userId) return true;

    if ($user->userable_type === Supervisor::class) {
        return $user->userable->representatives()
            ->whereHas('user', function ($query) use ($userId) {
                $query->where('id', $userId);
            })->exists();
    }

    return false;
});


