<?php

declare(strict_types=1);

namespace App\Services\UserActivity;

use App\Models\Session;
use App\Models\User;
use App\Repositories\Eloquent\Users\SessionRepository;

class SessionService
{
    public function __construct(
        private readonly SessionRepository $sessionRepository
    ) {
    }

    /**
     * Gets the session information from user primary key value.
     *
     * @return Session|null Returns null, if session record was not found.
     */
    public function getSessionFromUser(User &$user)
    {
        $session = $this->sessionRepository->findBy('user_id', $user->getKey());

        return $session;
    }
}
