<?php

namespace App\Listeners\User;

use App\Events\User\UserProfileImageDeleted;
use App\Notifications\User\NotifyUserAboutProfileImageDeletion;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendDeletedImageNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(UserProfileImageDeleted $event): void
    {
        $user = $event->user;

        $user->notify(new NotifyUserAboutProfileImageDeletion($user));
    }
}
