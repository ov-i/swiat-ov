<?php

declare(strict_types=1);

namespace App\Data\Auth;

use App\Enums\Auth\UserBlockHistoryActionEnum;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\Enum;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[
    MapName(SnakeCaseMapper::class),
    Schema(
        title: 'Create user block record',
        description: 'Creates new user block history record',
        required: ['user_id', 'action'],
        properties: [
            new Property(
                property: 'user_id',
                description: 'related user_id that exists',
                type: 'integer',
            ),
            new Property(
                property: 'action',
                description: 'Action that has been made',
                enum: ['blocked','unlocked'],
                type: 'string'
            ),
            new Property(
                property: 'ban_duration',
                description: 'How long was the ban duration',
                type: 'string'
            )
        ]
    )
]
class CreateUserBlockHistoryRequestData extends Data
{
    public function __construct(
        #[Exists(table: 'users', column: 'id'), Required()]
        public readonly string $user_id,
        #[Enum(enum: UserBlockHistoryActionEnum::class), Required()]
        public readonly string $action,
        #[Nullable(), Required]
        public readonly ?string $banDuration = ''
    ) {
    }
}
