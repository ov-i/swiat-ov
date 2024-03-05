<?php

declare(strict_types=1);

namespace App\Enums;

use Spatie\Enum\Enum;

final class ItemsPerPageEnum extends Enum
{
    public const DEFAULT = 10;

    public const TWENTY = 20;

    public const THIRTY = 30;

    public static function values(): array
    {
        return [
            self::DEFAULT,
            self::TWENTY,
            self::THIRTY
        ];
    }
}
