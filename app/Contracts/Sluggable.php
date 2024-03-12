<?php

declare(strict_types=1);

namespace App\Contracts;

interface Sluggable
{
    public function toSlug(): string;
}
