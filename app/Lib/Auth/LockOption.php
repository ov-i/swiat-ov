<?php

namespace App\Lib\Auth;

use App\Enums\Auth\BanDurationEnum;

final class LockOption
{
    public function __construct(
        private readonly BanDurationEnum $lockDuration,
        private readonly string $reason
    ) {
    }

    public function getDuration(): BanDurationEnum
    {
        return $this->lockDuration;
    }

    public function getReason(): string
    {
        return $this->reason;
    }
}
