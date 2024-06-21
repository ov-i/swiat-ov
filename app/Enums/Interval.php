<?php

namespace App\Enums;

enum Interval: int
{
    case OneHour = 3600;
    case OneDay = self::OneHour->value * 24;
    case OneMonth = self::OneDay->value * 30;
}
