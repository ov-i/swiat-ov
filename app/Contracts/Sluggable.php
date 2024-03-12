<?php

declare(strict_types=1);

namespace App\Contracts;

use Stringable;

interface Sluggable
{
    public function toSlug(): string;
}