<?php

namespace App\Events\Auth;

use App\Enums\Auth\BanDurationEnum;
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
        public BanDurationEnum $duration,
    ) {
    }

    public function isLocked(): bool
    {
        return $this->user->isBlocked();
    }
}
