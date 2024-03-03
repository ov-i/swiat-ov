<?php

namespace App\Enums\Post;

use Spatie\Enum\Enum;

/**
 * @method static self png()
 * @method static self jpg()
 * @method static self tiff()
 * @method static self bmp()
 * @method static self svg()
 * @method static self gif()
 */
class ThumbnailAllowedMimeTypesEnum extends Enum
{
    /**
     * @return array<string, string>
     */
    protected static function values(): array
    {
        return [
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'tiff' => 'image/tiff',
            'bmp' => 'image/bmp',
            'svg' => 'image/svg',
            'gif' => 'image/gif'
        ];
    }
}
