<?php

namespace App\Data;

use App\Enums\Post\CommentStatus;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class CommentData extends Data
{
    public function __construct(
        #[Required, Max(120)]
        public readonly string $content,
        public ?CommentStatus $status = CommentStatus::InReview,
    ) {
    }

    public static function messages(...$args)
    {
        return [
            'content.required' => __('Zawartość jest wymagana'),
            'content.max' => __('Zawartość nie może być dłuższa niż 120 znaków')
        ];
    }
}
