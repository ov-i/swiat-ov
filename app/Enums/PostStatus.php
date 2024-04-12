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
            PostStatus::Published => 'green',
            PostStatus::Archived => 'gray',
            PostStatus::Unpublished => 'orange',
            PostStatus::Delayed => 'yellow',
            PostStatus::InTrash => 'red',
            PostStatus::Closed => 'blue',
            PostStatus::Draft => 'indigo'
        };
    }
}
