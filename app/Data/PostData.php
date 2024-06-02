<?php

namespace App\Data;

use App\Enums\PostType;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * @property-read list<array-key, int>|null $tags
 * @property-read list<array-key, int>|null $attachments
 */
#[MapName(SnakeCaseMapper::class)]
class PostData extends Data
{
    public function __construct(
        public readonly int $category_id,
        public readonly string $title,
        public readonly PostType $type,
        public readonly string $content,
        public readonly ?array $tags = null,
        public readonly ?array $attachments = null,
        public readonly ?string $thumbnail_path = null,
        public readonly ?string $excerpt = null,
        public readonly ?string $scheduled_publish_date = null,
    ) {
    }
}
