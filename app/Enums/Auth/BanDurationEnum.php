<?php

declare(strict_types=1);

namespace App\Enums\Auth;

use Spatie\Enum\Enum;

/**
 * @method static self oneDay()
 * @method static self oneWeek()
 * @method static self oneMonth()
 * @method static self oneYear()
 * @method static self forever()
 */
final class BanDurationEnum extends Enum
{
    /**
     * @return array<string, string>
     */
    protected static function values(): array
    {
        return [
            'oneDay' => 'P1D',
            'oneWeek' => 'P1W',
            'oneMonth' => 'P1M',
            'oneYear' => 'P1Y',
            'forever' => 'forever',
        ];
    }
}
