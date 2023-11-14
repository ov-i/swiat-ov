<?php

declare(strict_types=1);

namespace App\Enums\Auth;

use Spatie\Enum\Enum;

/**
 * @method static self fiveMinutes()
 * @method static self oneHour()
 * @method static self oneDay()
 * @method static self oneWeek()
 * @method static self oneMonth()
 * @method static self oneYear()
 * @method static self forever()
 */
final class BanDurationEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'fiveMinutes' => 'PT5M',
            'halfAnHour' => 'PT30M',
            'oneHour' => 'PT1H',
            'oneDay' => 'P1D',
            'oneWeek' => 'P1W',
            'oneMonth' => 'P1M',
            'oneYear' => 'P1Y',
            'forever' => 'forever',
        ];
    }
}
