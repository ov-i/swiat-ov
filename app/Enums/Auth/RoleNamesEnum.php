<?php

namespace App\Enums\Auth;

use Spatie\Enum\Enum;

/**
 * @method static self user()
 * @method static self admin()
 * @method static self moderator()
 * @method static self subAuthor()
 * @method static self vipMember()
 */
class RoleNamesEnum extends Enum
{
    public static function count(): int
    {
        return count(self::cases());
    }
}
