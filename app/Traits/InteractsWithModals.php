<?php

declare(strict_types=1);

namespace App\Traits;

trait InteractsWithModals
{
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
