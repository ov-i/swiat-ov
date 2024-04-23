<?php

namespace App\Enums;

enum PostType: string
{
    case Post = 'post';

    case Event = 'event';

    case Vip = 'vip';

    public function icon(): string
    {
        return match ($this) {
            PostType::Post => 'icon.pencil-square',
            PostType::Event => 'icon.calendar-days',
            PostType::Vip => 'icon.lock-closed'
        };
    }

    public function label(): string
    {
        return str($this->value)->ucfirst();
    }
}
