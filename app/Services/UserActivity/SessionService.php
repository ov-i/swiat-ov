<?php

declare(strict_types=1);

namespace App\Services\UserActivity;

use App\Models\Session;
use App\Models\User;

class SessionService
{
    /**
     * Gets the session information from user primary key value.
     *
     * @param User $user Referenced user.
     *
     * @return Session|null Returns null, if session record was not found.
     */
    public function getSessionFromUser(User &$user): ?Session
    {
        $session = $user->sessions()
            ->where('user_id', $user->getKey())
            ->first();

        return $session;
    }
}
