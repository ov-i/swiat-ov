<?php

declare(strict_types=1);

namespace App\Livewire\Traits;

trait Selectable
{
    /** @var array<array-key, int> $selectedItemsIds */
    public array $selectedItemIds = [];

    /** @var array<array-key, int> $itemIdsOnPage */
    public array $itemIdsOnPage = [];

    public function resetSelected(): void
    {
        $this->selectedItemIds = [];
        $this->itemIdsOnPage = [];
    }
}
