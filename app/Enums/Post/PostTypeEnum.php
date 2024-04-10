<?php

namespace App\Enums\Post;

use phpDocumentor\Reflection\DocBlock\Tags\Deprecated;
use Spatie\Enum\Enum;

/**
 * @method static self post()
 * @method static self event()
 * @method static self vip()
 */
#[Deprecated(description: 'Please use App\\Enum\\PostTypeEnum instead.')]
final class PostTypeEnum extends Enum
{
}
