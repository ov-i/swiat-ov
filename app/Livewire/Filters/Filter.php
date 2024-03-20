<?php

declare(strict_types=1);

namespace App\Livewire\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class Filter
{
    /**
     * Apply the selected filter to the given query.
     */
    abstract protected static function apply(Request $request, Builder $query, mixed $value): Builder;
}
