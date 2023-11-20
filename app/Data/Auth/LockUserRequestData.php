<?php

namespace App\Data\Auth;

use App\Enums\Auth\BanDurationEnum;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\Enum;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[
    MapName(SnakeCaseMapper::class),
    Schema(
        title: 'Lock User Request',
        description: 'Locks user for by specific time and reason',
        required: ['user_id', 'banDuration', 'reason'],
        properties: [
            new Property(
                property: 'userId',
                description: 'Existing user id',
                type: 'int',
            ),
            new Property(
                property: 'banDuraton',
                description: 'For how long user should be locked',
                type: 'string',
                enum: [...BanDurationEnum::toArray()]
            ),
            new Property(
                property: 'reason',
                description: 'Reason, why user has been locked',
                type: 'string'
            )
        ]
    )
]
final class LockUserRequestData extends Data
{
    public function __construct(
        #[Required, Exists('users', 'id')]
        public readonly int $userId,
        #[Required, Enum(enum: BanDurationEnum::class)]
        public readonly string $banDuration,
        #[Required, Min(10)]
        public readonly string $reason
    ) {
    }
}
