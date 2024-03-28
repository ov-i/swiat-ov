<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Livewire\Concerns\SearchModelState;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

abstract class SearchableResource extends Resource
{
    public SearchModelState $state;

    /**
     * Determinate if records should be paginated
     *
     * @var bool $paginate
     */
    protected $paginateSearch = false;

    public function __construct()
    {
        parent::__construct();

        $this->state = new SearchModelState(paginate: $this->paginateSearch);
    }

    protected function search(): Collection|LengthAwarePaginator
    {
        return $this->repository->searchBy(
            query: Str::lower($this->state->search),
            paginate: $this->state->paginate,
            perPage: $this->state->perPage
        );
    }

    /**
     * @inheritDoc
     */
    protected function getViewAttributes(): array
    {
        if (filled($this->state->search)) {
            return ['resource' => $this->search()];
        }

        return parent::getViewAttributes();
    }
}
