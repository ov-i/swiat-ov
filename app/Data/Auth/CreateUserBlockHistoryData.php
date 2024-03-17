<?php

declare(strict_types=1);

namespace App\Data\Auth;

use App\Enums\Auth\UserBlockHistoryActionEnum;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\AcceptedIf;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Attributes\Validation\RequiredIf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[
    MapName(SnakeCaseMapper::class),
    Schema(
        title: 'Create user block record',
        description: 'Creates new user block history record',
        required: ['userId', 'action'],
        properties: [
            new Property(
                property: 'userId',
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
final class CreateUserBlockHistoryData extends Data
{
    public function __construct(
        public readonly int $userId,
        public readonly UserBlockHistoryActionEnum $action,
        public readonly ?string $banDuration = '',
        public readonly ?int $operatorId 
    ) {
    }

    /**
     * @return array<string, array<array-key, mixed>|mixed>
     */
    public static function rules($context)
    {
        return [
            'userId' => [
                new Exists(table: 'users', column: 'id'),
                'required'
            ],
            'operatorId' => [
                new Exists(table: 'users', column: 'id'),
            ],
            'action' => [
                new In(UserBlockHistoryActionEnum::toValues()),
                'required',
            ],
            'banDuration' => [
                'nullable',
                new RequiredIf('action', UserBlockHistoryActionEnum::locked()->value),
            ],
        ];
    }
}
