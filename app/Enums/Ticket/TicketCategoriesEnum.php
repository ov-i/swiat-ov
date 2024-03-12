<?php

namespace App\Enums\Ticket;

use Spatie\Enum\Enum;

/**
 * @method static self apiToken()
 * @method static self payment()
 * @method static self account()
 * @method static self bug()
 */
class TicketCategoriesEnum extends Enum
{
    public function getCount(): int
    {
        return count(self::toValues());
    }
}
