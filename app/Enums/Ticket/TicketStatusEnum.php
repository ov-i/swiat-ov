<?php

namespace App\Enums\Ticket;

use Spatie\Enum\Enum;

/**
 * @method static self open()
 * @method static self inReview()
 * @method static self declined()
 * @method static self resolved()
 */
final class TicketStatusEnum extends Enum
{
}
