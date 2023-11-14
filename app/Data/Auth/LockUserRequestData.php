<?php

namespace App\Data\Auth;

use App\Enums\Auth\BanDurationEnum;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\Enum;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
final class LockUserRequestData extends Data
{
    public function __construct(
        #[Required, Enum(enum: BanDurationEnum::class)]
        public readonly string $banDuration
    ) {
    }
}
