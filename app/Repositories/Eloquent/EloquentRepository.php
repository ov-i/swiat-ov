<?php

namespace App\Repositories\Eloquent;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\Data;

abstract class EloquentRepository
{
    protected function __construct(
        protected readonly Model $model,
    ) {
    }

    /**
     * Gets all models from database
     *
     * @return LengthAwarePaginator<Model>|null;
     */
    abstract protected function all(): ?LengthAwarePaginator;

    /**
     * Finds the result based on id
     *
     * @param string|int $id Unique identifier
     * @return Model|null
     */
    abstract protected function find(string|int $id): ?Model;

    /**
     * Creates new record with passed data
     *
     * @param Data $data
     * @return Model|null
     */
    abstract protected function create(Data $data): ?Model;

    public function getModel(): Model
    {
        return $this->model;
    }
}
