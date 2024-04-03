<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Support\Number;
use Illuminate\Support\Str;

trait FormatsString
{
    public function fileSize(int $size): string
    {
        return Number::fileSize($size);
    }

    public function substringIf(
        string $string,
        int $stringLength = 10,
        int $offset = 0,
        ?int $length = null
    ): string {
        if($length === null) {
            $length = $stringLength;
        }

        if (Str::length($string) > $stringLength) {
            return Str::substr($string, $offset, $length) . '...';
        }

        return $string;
    }
}
