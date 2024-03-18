<?php

use App\Enums\Auth\BanDurationEnum;
use App\Enums\Auth\UserBlockHistoryActionEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;

uses(WithFaker::class);

dataset('user_block_histories', function () {
    return [
        [
            fn () => User::factory()->dummy()->create(),
            UserBlockHistoryActionEnum::locked(),
            BanDurationEnum::oneDay(),
        ],
        [
            fn () => User::factory()->dummy()->create(),
            UserBlockHistoryActionEnum::locked(),
            BanDurationEnum::oneWeek(),
        ],
        [
            fn () => User::factory()->dummy()->create(),
            UserBlockHistoryActionEnum::locked(),
            BanDurationEnum::oneMonth(),
        ],
        [
            fn () => User::factory()->dummy()->create(),
            UserBlockHistoryActionEnum::locked(),
            BanDurationEnum::oneYear(),
        ],
        [
            fn () => User::factory()->dummy()->create(),
            UserBlockHistoryActionEnum::locked(),
            BanDurationEnum::forever(),
        ],
        [
            fn () => User::factory()->dummy()->create(),
            UserBlockHistoryActionEnum::unlocked()
        ],
    ];
});
