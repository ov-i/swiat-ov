<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Livewire\Concerns\SearchModelState;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Livewire\Component;

abstract class SearchableComponent extends Component
{
    public SearchModelState $state;

    /**
     * @param class-string<\App\Repositories\Eloquent\BaseRepository>
     */
    protected $repository;

    /**
     * Determinate if records should be paginated
     *
     * @var bool $paginate
     */
    protected $paginate = true;

    public function __construct(
    ) {
        $modelable = new $this->repository();

        $this->repository = app($modelable::class);
    }

    public function mount()
    {
        $this->state = new SearchModelState(paginate: $this->paginate);
    }

    protected function search(): Collection|LengthAwarePaginator
    {
        return $this->repository->searchBy(
            query: Str::lower($this->state->search),
            paginate: $this->state->paginate,
            perPage: $this->state->perPage
        );
    }
}
