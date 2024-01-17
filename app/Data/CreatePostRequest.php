<?php

namespace App\Data;

use App\Enums\Post\PostTypeEnum;
use DateTime;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\Enum;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Numeric;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Attributes\Validation\Url;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class CreatePostRequest extends Data
{
    /**
     * @param null|array<array-key, int> $tags,
     * @param null|array<array-key, CreateAttachmentRequest> $attachments,
     */
    public function __construct(
        #[Exists(table: 'posts', column: 'id'), Required, Numeric, Min(1)]
        public readonly int $userId,
        #[Exists(table: 'categories', column: 'id'), Required, Numeric, Min(1)]
        public readonly int $categoryId,
        #[Unique(table: 'posts', column: 'title'), Required]
        public readonly string $title,
        #[Enum(PostTypeEnum::class), Required]
        public readonly string $type,
        #[Required, Max(10000)]
        public readonly string $content,
        #[Numeric]
        public readonly ?array $tags = null,
        #[ArrayType]
        public readonly ?array $attachments = null,
        #[StringType, Url]
        public readonly ?string $thumbnailPath = null,
        #[StringType, Min(100)]
        public readonly ?string $description = null,
        public readonly ?DateTime $publishableDateTime = null
    ) {
    }
}
