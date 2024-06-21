<?php

namespace App\Enums\Post;

enum CommentStatus: string
{
    case Accepted = 'accepted';

    case InReview = 'in_review';

    case Archived = 'archived';

    case InTrash = 'in_trash';

    public function label(): string
    {
        return match($this) {
            self::InTrash => 'In Trash',
            default => str($this->value)->ucfirst()
        };
    }

    /**
     * @return array<array-key string>
     */
    public static function toArray(): array
    {
        return [
            self::Accepted->value,
            self::InReview->value,
            self::Archived->value,
            self::InTrash->value
        ];
    }
}
