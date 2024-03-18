<?php

use App\Enums\Auth\BanDurationEnum;
use App\Models\User;

dataset('permament-locked-user', function () {
    return [fn () => User::factory()->locked(banDuration: BanDurationEnum::forever())->create()];
});
