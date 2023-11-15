<?php

use App\Enums\Auth\BanDurationEnum;

dataset('ban_durations', function () {
    return BanDurationEnum::toArray();
});
