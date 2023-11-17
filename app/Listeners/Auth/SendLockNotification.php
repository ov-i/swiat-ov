<?php

declare(strict_types=1);

namespace App\Listeners\Auth;

use App\Events\Auth\UserLocked;
use App\Notifications\NotifyAboutLock;
use App\Repositories\Eloquent\Auth\AuthRepository;
use App\Repositories\Eloquent\UserBlockHistory\UserBlockHistoryRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendLockNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct(
        private readonly AuthRepository $authRepository,
        private readonly UserBlockHistoryRepository $blockRepository
    ) {
    }

    /**
     * Handle the event.
     */
    public function handle(UserLocked $event): void
    {
        if (false === $event->isLocked()) {
            return;
        }

        $user = $event->user;

        $user->notify(new NotifyAboutLock($user));
    }
}
