<?php

declare(strict_types=1);

namespace App\Enums\Post;

use Spatie\Enum\Enum;

/**
 * @method static self png()
 * @method static self jpg()
 * @method static self pdf()
 * @method static self svg()
 * @method static self mp3()
 * @method static self txt()
 */
final class AttachmentAllowedMimeTypesEnum extends Enum
{
    /**
     * @return array<string, string>
     */
    protected static function values(): array
    {
        return [
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'pdf' => 'application/pdf',
            'svg' => 'image/svg+xml',
            'mp3' => 'audio/mpeg',
            'txt' => 'text/plain',
        ];
    }
}
