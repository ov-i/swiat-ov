<?php

namespace App\Services\UserActivity;

use App\Enums\User\UserActivityEnum;
use App\Models\Session;
use App\Models\User;

class UserActivityService
{
    public function __construct(
        private readonly SessionService $sessionService
    ) {
    }

    /**
     * Gets current session status. Checks if user is perfoms some actions
     * or is logged in. However activity is more important.
     *
     * @return string Returns Offline or Active.
     */
    public function getStatus(User &$user)
    {
        $session = $this->sessionService->getSessionFromUser($user);

        if ($this->isInactive($session) || blank($session->user_id)) {
            return UserActivityEnum::offline()->value;
        }

        return UserActivityEnum::active()->value;
    }

    /**
     * Checks if user performed any action in past 10 seconds from current time.
     *
     * @return bool
     */
    private function isInactive(?Session $session)
    {
        if (blank($session)) {
            return true;
        }

        return now()->unix() - $session->last_activity >= 10;
    }
}
