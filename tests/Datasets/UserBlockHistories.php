<?php

use App\Enums\Auth\BanDurationEnum;
use App\Enums\Auth\UserBlockHistoryActionEnum;
use App\Models\User;

dataset('user_block_histories', function () {
    return [
        [
            fn () => User::factory()->create(),
            UserBlockHistoryActionEnum::locked(),
            BanDurationEnum::oneDay(),
        ],
        [
            fn () => User::factory()->create(),
            UserBlockHistoryActionEnum::locked(),
            BanDurationEnum::oneWeek(),
        ],
        [
            fn () => User::factory()->create(),
            UserBlockHistoryActionEnum::locked(),
            BanDurationEnum::oneMonth(),
        ],
        [
            fn () => User::factory()->create(),
            UserBlockHistoryActionEnum::locked(),
            BanDurationEnum::oneYear(),
        ],
        [
            fn () => User::factory()->create(),
            UserBlockHistoryActionEnum::locked(),
            BanDurationEnum::forever(),
        ],
        [
            fn () => User::factory()->create(),
            UserBlockHistoryActionEnum::unlocked()
        ],
    ];
});
