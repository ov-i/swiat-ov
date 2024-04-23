<?php

namespace App\Livewire\Admin\Posts\Index;

use App\Livewire\Filters\RangeFilter;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Builder as ScoutBuilder;
use Livewire\Form;

class Filters extends Form
{
    public RangeFilter $rangeFilter;

    public function __construct(\Livewire\Component $component, $propertyName)
    {
        parent::__construct($component, $propertyName);

        $this->rangeFilter = new RangeFilter($component, $propertyName);
    }

    public function apply(Builder|ScoutBuilder &$builder): Builder|ScoutBuilder
    {
        $builder = $this->rangeFilter->apply($builder);

        return $builder;
    }
}
