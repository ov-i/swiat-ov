<?php

namespace App\Observers;

use App\Enums\Auth\RoleNamesEnum;
use App\Models\User;
use App\Services\Auth\AuthService;

class UserObserver
{
    public function __construct(
        private readonly AuthService $authService
    ) {
    }

    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        if (!app()->runningInConsole()) {
            $this->authService->assignRolesFor($user, RoleNamesEnum::user());
        }

        $user->settings()->create();
    }
}
