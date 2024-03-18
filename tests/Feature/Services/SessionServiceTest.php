<?php

use App\Models\Session;
use App\Models\User;
use App\Services\UserActivity\SessionService;

describe('Session Service Test', function () {
    beforeEach(function () {
        $this->sessionService = app(SessionService::class);
    });

    it('should be able to get session data from user', function () {
        $user = User::factory()
            ->has(Session::factory())
            ->create();

        $session = $this->sessionService->getSessionFromUser($user);

        expect($session)->toBeInstanceOf(Session::class);
    });
});
