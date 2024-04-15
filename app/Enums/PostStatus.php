<?php

namespace App\Enums;

enum PostStatus: string
{
    case Published = 'published';

    case Archived = 'archived';

    case Unpublished = 'unpublished';

    case Delayed = 'delayed';

    case InTrash = 'intrash';

    case Closed = 'closed';

    case Draft = 'draft';

    public function icon(): string
    {
        return match($this) {
            PostStatus::Published => 'icon.eye',
            PostStatus::Archived => 'icon.archive-box',
            PostStatus::Unpublished => 'icon.eye-slash',
            PostStatus::Delayed => 'icon.clock',
            PostStatus::InTrash => 'icon.trash',
            PostStatus::Closed => 'icon.lock-closed',
            PostStatus::Draft => 'icon.exclamation-triangle'
        };
    }

    public function label(): string
    {
        $label = match ($this) {
            PostStatus::InTrash => 'In Trash',
            default => $this->value,
        };

        return str($label)->ucfirst();
    }

    public function color(): string
    {
        return match ($this) {
            PostStatus::Published => 'green-600',
            PostStatus::Archived => 'zinc-500',
            PostStatus::Unpublished => 'stone-400',
            PostStatus::Delayed => 'amber-400',
            PostStatus::InTrash => 'red-400',
            PostStatus::Closed => 'blue-400',
            PostStatus::Draft => 'indigo-500'
        };
    }
}
