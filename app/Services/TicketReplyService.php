<?php

namespace App\Services;

use App\Events\TicketReplyCreated;
use App\Models\Representative;
use App\Models\TicketReply;
use App\Notifications\NewTicketReplyNotification;
use DB;
use Illuminate\Support\Facades\Cache;

class TicketReplyService extends Service
{

    public function store($data)
    {
        return DB::transaction(function () use ($data) {
            $reply = TicketReply::create($data);

            $representative = $reply->ticket->user->userable;
            $shouldNotify = !Cache::get("user_viewing_ticket_{$reply->ticket->id}_{$reply->ticket->user->id}");

            if ($representative instanceof Representative) {

            $supervisor = $representative->supervisor;
            $supervisorUser = $supervisor?->user;
            $shouldNotifySupervisor = !Cache::get("user_viewing_ticket_{$reply->ticket->id}_{$supervisorUser->id}");

            if ($shouldNotifySupervisor && $supervisorUser && $supervisorUser->id !== $reply->user_id) {
                $supervisorUser->notify(new NewTicketReplyNotification($reply));

            }

            if ($shouldNotify && $reply->user_id !== $reply->ticket->user_id) {
                $reply->ticket->user->notify(new NewTicketReplyNotification($reply));
            }
        }

            event(new TicketReplyCreated($reply));
            return $reply;
        });
    }

}
