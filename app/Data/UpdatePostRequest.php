<?php

declare(strict_types=1);

namespace App\Data;

use App\Enums\Post\AttachmentAllowedMimeTypesEnum;
use App\Enums\Post\PostTypeEnum;
use App\Enums\Post\ThumbnailAllowedMimeTypesEnum;
use App\Rules\DoesntStartWithANumber;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class UpdatePostRequest extends Data
{
    public function __construct(
        public ?string $title = null,
        public string $type,
        public ?string $excerpt,
        public string $content,
        public int $category_id,
        public ?array $tags = null,
        public ?array $attachments = null,
        public ?string $thumbnailPath = null
    ) {
    }

    public static function rules(): array
    {
        return [
            'type' => [
                Rule::in(PostTypeEnum::toValues()),
                'required',
            ],
            'category_id' => [
                'required',
                Rule::exists('categories', 'id'),
                'numeric'
            ],
            'tags.*' => [
                'nullable',
                Rule::exists('tags', 'id'),
                'numeric'
            ],
            'attachments.*' => [
                'nullable',
                Rule::file()
                    ->extensions([...AttachmentAllowedMimeTypesEnum::toLabels()])
                    ->max(config('swiatov.max_file_size')),
            ],
            'thumbnailPath' => [
                'nullable',
                Rule::imageFile()
                    ->extensions([...ThumbnailAllowedMimeTypesEnum::toLabels()])
                    ->max(config('swiatov.max_file_size')),
            ],
            'content' => [
                'max:10000',
                'required',
                new DoesntStartWithANumber(),
                'min:10',
            ]
        ];
    }
}
