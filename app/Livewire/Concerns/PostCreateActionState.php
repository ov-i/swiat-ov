<?php

namespace App\Livewire\Concerns;

use Livewire\Wireable;

class PostCreateActionState implements Wireable
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public string $saveButtonContent = 'publish',
        // ...
    ) {
    }

    /**
     * @return non-empty-list<string, mixed>
     */
    public function toLivewire(): array
    {
        return [
            'saveButtonContent' => $this->saveButtonContent
        ];
    }

    public static function fromLivewire($value): static
    {
        return new static($value['saveButtonContent']);
    }
}
