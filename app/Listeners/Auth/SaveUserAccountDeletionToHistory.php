<?php

namespace App\Listeners\Auth;

use App\Enums\User\UserAccountHistoryEnum;
use App\Events\Auth\UserDeleted;
use App\Repositories\Eloquent\UserAccountHistory\UserAccountHistoryRepository;

class SaveUserAccountDeletionToHistory
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private readonly UserAccountHistoryRepository $userAcccountHistoryRepository
    ) {
    }

    /**
     * Handle the event.
     */
    public function handle(UserDeleted $event): void
    {
        $user = $event->user;

        $this->userAcccountHistoryRepository->saveHistory($user, UserAccountHistoryEnum::deleted());
    }
}
