<?php

declare(strict_types=1);

namespace App\Listeners\Auth;

use App\Events\Auth\UserUnlocked;
use App\Notifications\NotifyAboutUnlock;
use App\Repositories\Eloquent\UserBlockHistory\UserBlockHistoryRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendUnlockNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct(
        private readonly UserBlockHistoryRepository $blockRepository
    ) {
    }

    /**
     * Handle the event.
     */
    public function handle(UserUnlocked $event): void
    {
        if(!$event->isUnlocked()) {
            return;
        }

        $user = $event->user;
        $user->notify(new NotifyAboutUnlock($user));
    }
}
