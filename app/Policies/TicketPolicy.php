<?php

namespace App\Policies;

use App\Enums\TicketStatusEnum;
use App\Models\Admin;
use App\Models\Representative;
use App\Models\Supervisor;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TicketPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Ticket $ticket): bool
    {
        if ($user->userable instanceof Representative) {
            return $ticket->user_id === $user->id;
        }

        if ($user->userable instanceof Supervisor) {
        $repIds = $user->userable->representatives()->pluck('id');

        return $ticket->user->userable_type === Representative::class
            && $repIds->contains($ticket->user->userable_id);
    }

        return true;
    }


    public function addReply(User $user, Ticket $ticket): bool
    {
            $allowedStatuses = [
            TicketStatusEnum::OPEN,
            TicketStatusEnum::IN_PROGRESS,
        ];

        if ($user->userable instanceof Admin) {
            return false;
        }

        if (!$this->view($user, $ticket)) {
            return false;
        }

        $statusEnum = $ticket->status;

        if (!$statusEnum || !in_array($statusEnum, $allowedStatuses)) {
            return false;
        }

         return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Ticket $ticket): bool
    {
        if (!$user->userable instanceof Supervisor) {
            return false;
        }

        $repIds = $user->userable->representatives()->pluck('id')->toArray();

        $isRepTicket = $ticket->user->userable instanceof Representative
            && in_array($ticket->user->userable->id, $repIds);

        return $isRepTicket;
    }
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Ticket $ticket): bool
    {
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Ticket $ticket): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Ticket $ticket): bool
    {
        return true;
    }
}
