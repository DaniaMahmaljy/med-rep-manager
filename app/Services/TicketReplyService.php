<?php

namespace App\Services;

use App\Models\Representative;
use App\Models\TicketReply;
use App\Notifications\NewTicketReplyNotification;
use DB;

class TicketReplyService extends Service
{

    public function store($data)
    {
        return DB::transaction(function () use ($data) {
            $reply = TicketReply::create($data);

            $representative = $reply->ticket->user->userable;

            if ($representative instanceof Representative) {

            $supervisor = $representative->supervisor;
            $supervisorUser = $supervisor?->user;

            if ($supervisorUser && $supervisorUser->id !== $reply->user_id) {
                $supervisorUser->notify(new NewTicketReplyNotification($reply));
            }

            if ($reply->user_id !== $reply->ticket->user_id) {
                $reply->ticket->user->notify(new NewTicketReplyNotification($reply));
            }
        }

            return $reply;
        });
    }

}
