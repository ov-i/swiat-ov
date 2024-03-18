<?php

namespace App\Observers;

use App\Enums\Auth\RoleNamesEnum;
use App\Models\User;
use App\Services\Auth\AuthService;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user, AuthService $authService): void
    {
        $authService->assignRolesFor($user, RoleNamesEnum::user());
    }
}
