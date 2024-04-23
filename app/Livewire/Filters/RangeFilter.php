<?php

declare(strict_types=1);

namespace App\Livewire\Filters;

use App\Livewire\Contracts\Filterable;
use App\Livewire\Enums\Range;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Builder as ScoutBuilder;
use Livewire\Attributes\Url;
use Livewire\Form;

class RangeFilter extends Form implements Filterable
{
    #[Url]
    public Range $range = Range::All_Time;

    /**
     * @inheritDoc
     */
    public function apply(Builder|ScoutBuilder &$builder): Builder|ScoutBuilder
    {
        $builder = $this->applyRange($builder);

        return $builder;
    }

    public function applyRange(Builder|ScoutBuilder &$builder): Builder|ScoutBuilder
    {
        if ($this->range === Range::All_Time) {
            return $builder;
        }

        return $builder->whereBetween('created_at', $this->range->dates());
    }
}
