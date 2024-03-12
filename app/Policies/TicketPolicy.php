<?php

namespace App\Policies;

use App\Enums\Auth\PermissionsEnum;
use App\Enums\Auth\RoleNamesEnum;
use App\Models\Tickets\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class TicketPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can((string) PermissionsEnum::ticketIndex()->value);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Ticket $ticket): bool
    {
        return Gate::allows('read-ticket', [$user, $ticket]);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole(RoleNamesEnum::vipMember()->value);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return $user->can((string) PermissionsEnum::ticketUpdate()->value);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Ticket $ticket): bool
    {
        return $user->can((string) PermissionsEnum::ticketDelete()->value) ||
            $ticket->assigned_to === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): bool
    {
        return $user->hasRole(RoleNamesEnum::admin()->value);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user): bool
    {
        return $user->hasRole(RoleNamesEnum::admin()->value);
    }
}
