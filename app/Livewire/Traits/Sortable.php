<?php

declare(strict_types=1);

namespace App\Livewire\Traits;

use Livewire\Attributes\Url;

trait Sortable
{
    #[Url]
    public string $sortCol = '';

    #[Url]
    public bool $sortAsc = false;

    public function sortBy(string $column): void
    {
        if ($this->sortCol === $column) {
            $this->sortAsc = !$this->sortAsc;
            return;
        }

        $this->sortCol = $column;
        $this->sortAsc = false;
    }
}