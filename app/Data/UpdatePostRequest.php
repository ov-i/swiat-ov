<?php

declare(strict_types=1);

namespace App\Data;

use App\Enums\Post\PostTypeEnum;
use DateTime;
use Spatie\LaravelData\Data;

class UpdatePostRequest extends Data
{
    public function __construct(
        public readonly ?string $title,
        public readonly ?string $description,
        public readonly ?DateTime $shouldBePublishedAt,
        public readonly ?PostTypeEnum $type
    ) {
    }
}
