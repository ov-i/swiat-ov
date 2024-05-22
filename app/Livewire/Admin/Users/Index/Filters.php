<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Users\Index;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Form;

class Filters extends Form
{
    public function apply(Builder &$builder): Builder
    {
        return $builder;
    }
}
