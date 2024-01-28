<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

interface Followable
{
    public function followers(): MorphToMany;
}
