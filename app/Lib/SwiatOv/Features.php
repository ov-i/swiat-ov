<?php

namespace App\Lib\SwiatOv;

abstract class Features
{
    private static bool $analytics = true;

    public static function hasAnalytics(): bool
    {
        return self::$analytics;
    }

    public static function enableAnalytics(): void
    {
        self::$analytics = true;
    }
}
