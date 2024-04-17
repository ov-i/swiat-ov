<?php

declare(strict_types=1);

namespace App\Livewire\Traits;

use Livewire\WithPagination;

trait Searchable
{
    public string $search = '';

    public function updatedSearchable(string $property): void
    {
        if ($property === 'search' && in_array(WithPagination::class, class_uses_recursive($this))) {
            $this->resetPage();
        }
    }
}
