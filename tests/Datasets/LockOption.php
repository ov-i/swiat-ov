<?php

use App\Enums\Auth\BanDurationEnum;
use App\Enums\Auth\LockReasonEnum;
use App\Lib\Auth\LockOption;

dataset('lock-option', function () {
    return [
        new LockOption(BanDurationEnum::oneDay(), LockReasonEnum::hackingAttempt())
    ];
});
