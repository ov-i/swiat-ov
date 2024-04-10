<?php

namespace App\Enums;

enum PostTypeEnum: string
{
    case POST = 'post';
    case EVENT = 'event';
    case VIP = 'vip';

    public function label(): string
    {
        return str($this->value)->ucfirst();
    }
}
