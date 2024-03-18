<?php

namespace App\Listeners\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateLastLoginAt implements ShouldBeEncrypted
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function handle(Login $event)
    {
        /** @var User $user */
        $user = $event->user;

        if ($user->isBlocked()) {
            return;
        }

        $user->last_login_at = now()->toDateTime();
        $user->update();
    }
}
