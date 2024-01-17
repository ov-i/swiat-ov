<?php

declare(strict_types=1);

namespace App\Enums\Auth;

use Spatie\Enum\Enum;

/**
 * @method static self monthlyLocking()
 * @method static self verbalAbuse()
 * @method static self hackingAttempt()
 * @method static self highFraudScore()
 * @method static self multiAccountDetected()
 */
final class LockReasonEnum extends Enum
{
}
