<?php

namespace App\Listeners\Auth;

use App\Events\Auth\UserDeleted;
use App\Notifications\NotifyAboutUserAccountDeletion;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendAccountDeletionNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(UserDeleted $event): void
    {
        $user = $event->user;
        $user->notify(new NotifyAboutUserAccountDeletion($user));
    }
}
