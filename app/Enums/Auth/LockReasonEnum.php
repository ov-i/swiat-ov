<?php

declare(strict_types=1);

namespace App\Enums\Auth;

use Spatie\Enum\Enum;

/**
 * @method static self monthlyLocking()
 * @method static self verbalAbuse()
 * @method static self hackingAttemp()
 * @method static self highFraudScore()
 */
final class LockReasonEnum extends Enum
{
}
