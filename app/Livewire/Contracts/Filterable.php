<?php

declare(strict_types=1);

namespace App\Livewire\Contracts;

interface Filterable
{
    /**
     * @return array<array-key, \App\Livewire\Filters\Filter>
     */
    public function filters(): array;
}