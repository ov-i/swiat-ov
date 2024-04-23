<?php

declare(strict_types=1);

namespace App\Livewire\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Builder as ScoutBuilder;

interface Filterable
{
    /**
     * Applies the given filter
     */
    public function apply(Builder &$builder): Builder|ScoutBuilder;
}
