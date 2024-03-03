<?php

namespace App\Enums\Post;

use Spatie\Enum\Enum;

/**
 * @method static self published()
 * @method static self archived()
 * @method static self unpublished()
 * @method static self delayed()
 * @method static self closed()
 * @method static self draft()
 */
final class PostStatusEnum extends Enum
{
}
