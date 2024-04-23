<?php

declare(strict_types=1);

namespace App\Enums;

use phpDocumentor\Reflection\DocBlock\Tags\Deprecated;
use Spatie\Enum\Enum;

#[Deprecated(description: 'Please use ItemsPerPage instead')]
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
