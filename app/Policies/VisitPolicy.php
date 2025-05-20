<?php

namespace App\Policies;

use App\Enums\VisitStatusEnum;
use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Representative;
use App\Models\Supervisor;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Auth\Access\Response;

class VisitPolicy
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
    public function view(User $user, Visit $visit): bool
    {
        if ($user->userable instanceof Admin) {
            return true;
        }

        if ($user->userable instanceof Supervisor) {
            return $user->userable->representatives()
                ->where('id', $visit->representative_id)
                ->exists();
        }

        if ($user->userable instanceof Representative) {
            return $user->userable->id === $visit->representative_id;
        }

        return false;

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Representative $representative, Doctor $doctor): bool
    {
        if ($user->hasRole('admin') || $user->hasRole('superadmin')) {
            return true;
        }

        if ($user->hasRole('supervisor')) {
            return $representative->supervisor_id === $user->userable_id  &&
            $doctor->supervisors()->where('supervisor_id', $user->userable_id);
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Visit $visit): bool
    {

        if ($user->userable instanceof Supervisor) {
            return $user->userable->representatives()
                ->where('id', $visit->representative_id)
                ->exists();
        }

        if ($user->userable instanceof Representative) {
            return $user->userable->id === $visit->representative_id;
        }

        return false;

    }

    public function addNote(User $user, Visit $visit): bool
    {
        if (!$this->view($user, $visit)) {
            return false;
        }
        else return true;

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Visit $visit): bool
    {
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Visit $visit): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Visit $visit): bool
    {
        return true;
    }
}
