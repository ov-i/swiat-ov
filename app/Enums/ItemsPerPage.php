<?php

declare(strict_types=1);

namespace App\Enums;

enum ItemsPerPage: int
{
    case Default = 10;

    case Twenty = 20;

    case Thirty = 30;

    public function label(): string
    {
        return match($this) {
            self::Default => 'per 10',
            self::Twenty => 'per 20',
            self::Thirty => 'per 30',
            default => 'Invalid item slice'
        };
    }
}
