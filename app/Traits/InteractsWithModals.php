<?php

declare(strict_types=1);

namespace App\Traits;

use Livewire\Attributes\Modelable;

trait InteractsWithModals
{
    #[Modelable]
    public bool $modalOpen = false;

    public function closeModal(): void
    {
        $this->modalOpen ? $this->modalOpen = false : null;
    }

    public function openModal(): void
    {
        !$this->modalOpen ? $this->modalOpen = true : null;
    }
}
