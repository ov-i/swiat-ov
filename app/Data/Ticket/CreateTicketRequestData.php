<?php

declare(strict_types=1);

namespace App\Data\Ticket;

use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[
    MapName(SnakeCaseMapper::class),
    Schema(
        title: 'Create new ticket',
        description: 'Creates new Ticket associated with an user',
        required: ['title'],
        properties: [
            new Property(
                property: 'title',
                description: 'Ticket unique title',
                type: 'string',
                maxLength: 255
            ),
            new Property(
                property: 'message',
                description: 'Optional message passed by a user',
                type: 'string',
                maxLength: 255
            ),
        ]
    )
]
class CreateTicketRequestData extends Data
{
    public function __construct(
        #[Max(255)]
        public readonly string $title,
        #[Min(30), Nullable()]
        public readonly string $message,
    ) {
    }
}
