<?php

namespace App\Services\UserActivity;

use App\Enums\User\UserActivityEnum;
use App\Models\User;

class UserActivityService
{
    public function __construct(
        private readonly SessionService $sessionService
    ) {
    }

    public function getStatus(User $user): string
    {
        $session = $this->sessionService->getSessionFromUser($user);

        if (null === $session || null === $session->user_id) {
            return UserActivityEnum::offline()->value;
        }

        return UserActivityEnum::active()->value;
    }
}
