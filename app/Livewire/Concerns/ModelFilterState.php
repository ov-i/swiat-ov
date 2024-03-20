<?php

namespace App\Livewire\Concerns;

use Livewire\Wireable;

class ModelFilterState implements Wireable
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * @return non-empty-list<string, mixed>
     */
    public function toLivewire(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public static function fromLivewire($value): static
    {
        return new static();
    }
}
