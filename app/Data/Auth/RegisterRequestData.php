<?php

declare(strict_types=1);

namespace App\Data\Auth;

use App\Rules\ReCaptcha;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\IPv4;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Password;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[
    MapName(SnakeCaseMapper::class),
    Schema(
        title: 'Register Request Data',
        description: 'Needed data for user registration',
        required: ['name', 'email', 'password'],
        properties: [
            new Property(
                property: 'name',
                description: 'The user\'s name',
                type: 'string',
                maxLength: 255
            ),
            new Property(
                property: 'email',
                description: 'The user\'s validated email address',
                type: 'string',
                format: 'email',
                maxLength: 255
            ),
            new Property(
                property: 'password',
                description: 'The user\'s secure password',
                type: 'string',
                format: 'password',
                maxLength: 255
            ),
            new Property(
                property: 'ip',
                description: 'User IP v4 address',
                type: 'string',
            ),
            new Property(
                property: 'remember',
                description: 'Whether the user should kept in memory or not',
                type: 'boolean'
            ),
        ]
    )
]
final class RegisterRequestData extends Data
{
    public function __construct(
        #[Max(255)]
        public readonly string $name,
        #[Email, Max(255)]
        public readonly string $email,
        #[Password(min: 10), Max(255)]
        public readonly string $password,
        #[IPv4]
        public readonly string $ip,
        #[MapName('g-recaptcha-response'), Rule(new ReCaptcha())]
        public readonly string $gRecaptchaResponse,
        public readonly bool $remember = false,
    ) {
    }
}
