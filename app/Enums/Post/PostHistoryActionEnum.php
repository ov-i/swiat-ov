<?php

declare(strict_types=1);

namespace App\Enums\Post;

use Spatie\Enum\Enum;

/**
 * @method static self created()
 * @method static self delayed()
 * @method static self updated()
 * @method static self savedAsDraft()
 * @method static self archived()
 * @method static self deleted()
 * @method static self unpublished()
 * @method static self published()
 * @method static self closed()
 */
final class PostHistoryActionEnum extends Enum
{
}
