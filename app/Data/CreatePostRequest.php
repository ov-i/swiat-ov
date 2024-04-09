<?php

namespace App\Data;

use App\Enums\Post\PostTypeEnum;
use App\Enums\Post\ThumbnailAllowedMimeTypesEnum;
use App\Rules\AllowOnlySpecificSpecialChars;
use App\Rules\DateTimeGreaterThanNow;
use App\Rules\DoesntStartWithANumber;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class CreatePostRequest extends Data
{
    /**
     * @param null|array<array-key, int> $tags,
     */
    public function __construct(
        public readonly int $categoryId,
        public readonly string $title,
        public readonly string $type,
        public readonly string $content,
        public readonly ?array $tags = null,
        public readonly ?array $attachments = null,
        public readonly ?string $thumbnailPath = null,
        public readonly ?string $excerpt = null,
        public readonly ?string $publishableDateTime = null,
    ) {
    }

    /**
     * @return array<array-key, array<array-key, mixed>|mixed>
     */
    public static function rules()
    {
        return [
            'title' => [
                'min:3',
                'max:120',
                'doesnt_start_with:<',
                new DoesntStartWithANumber(),
                new AllowOnlySpecificSpecialChars(),
                Rule::unique('posts', 'title'),
                'required',
            ],
            'type' => [
                Rule::in(PostTypeEnum::toValues()),
                'required'
            ],
            'categoryId' => [
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
                'numeric',
                Rule::exists('attachments', 'id'),
            ],
            'thumbnailPath' => [
                'nullable',
                Rule::imageFile()
                    ->extensions([...ThumbnailAllowedMimeTypesEnum::toLabels()])
                    ->max(config('swiatov.max_file_size')),
            ],
            'publishableDateTime' => [
                'nullable',
                'date',
                'after_or_equal:today',
                new DateTimeGreaterThanNow()
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
