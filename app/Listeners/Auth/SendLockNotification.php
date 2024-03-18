<?php

declare(strict_types=1);

namespace App\Listeners\Auth;

use App\Events\Auth\UserLocked;
use App\Notifications\NotifyAboutLock;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;

class SendLockNotification implements ShouldDispatchAfterCommit
{
    public function __construct(
    ) {
    }

    /**
     * Handle the event.
     */
    public function handle(UserLocked $event): void
    {
        if (!$event->isLocked()) {
            return;
        }

        $user = $event->user;

        $user->notify(new NotifyAboutLock($user));
    }
}
