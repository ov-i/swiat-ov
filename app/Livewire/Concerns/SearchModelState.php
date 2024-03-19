<?php

namespace App\Livewire\Concerns;

use Livewire\Wireable;

class SearchModelState implements Wireable
{
    /**
     */
    public function __construct(
        public bool $paginate = true,
        public ?int $perPage = null,
        public string $search = '',
    ) {
    }

    /**
     * @return non-empty-list<string, mixed>
     */
    public function toLivewire(): array
    {
        return [
            'paginate' => $this->paginate,
            'perPage' => $this->perPage,
            'search' => $this->search
        ];
    }

    /**
     * @inheritDoc
     */
    public static function fromLivewire($value): static
    {
        $paginate = $value['paginate'];
        $search = $value['search'];
        $perPage = $value['perPage'];

        return new static($paginate, $perPage, $search);
    }
}