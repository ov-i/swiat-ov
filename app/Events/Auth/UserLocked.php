<?php

namespace App\Events\Auth;

use App\Lib\Auth\LockOption;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserLocked
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public readonly User $user,
        public LockOption $lockOption,
    ) {
    }

    public function isLocked(): bool
    {
        return $this->user->isBlocked();
    }
}
