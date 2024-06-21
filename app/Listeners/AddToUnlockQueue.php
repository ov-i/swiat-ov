<?php

namespace App\Listeners;

use App\Events\Auth\UserLocked;
use App\Jobs\UnlockUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddToUnlockQueue implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(UserLocked $event): void
    {
        $duration = $event->lockOption->getDuration();

        $user = $event->user;

        dispatch(new UnlockUser($user))->delay(new \DateInterval($duration->value));
    }
}
