<?php

namespace App\Providers;

use App\Events\Auth\UpdateLastLoginAt;
use App\Events\Auth\UserDeleted;
use App\Events\Auth\UserLocked;
use App\Events\Auth\UserUnlocked;
use App\Events\User\UserProfileImageDeleted;
use App\Listeners\Auth\SaveLockToHistory;
use App\Listeners\Auth\SaveUnlockToHistory;
use App\Listeners\Auth\SendAccountDeletionNotification;
use App\Listeners\Auth\SendLockNotification;
use App\Listeners\Auth\SendUnlockNotification;
use App\Listeners\Auth\SaveUserAccountDeletionToHistory;
use App\Listeners\User\SendDeletedImageNotification;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        Login::class => [
            UpdateLastLoginAt::class,
        ],
        UserLocked::class => [
            SendLockNotification::class,
            SaveLockToHistory::class
        ],
        UserUnlocked::class => [
            SendUnlockNotification::class,
            SaveUnlockToHistory::class
        ],
        UserDeleted::class => [
            SendAccountDeletionNotification::class,
            SaveUserAccountDeletionToHistory::class
        ],
        UserProfileImageDeleted::class => [
            SendDeletedImageNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
