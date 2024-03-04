<?php

namespace App\Repositories\Eloquent;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;
use Spatie\LaravelData\Data;

abstract class EloquentRepository
{
    protected function __construct(
        private readonly Model $model,
    ) {
    }

    /**
     * Gets all models from database
     *
     * @return LengthAwarePaginator<Model>|Collection<Model>|null;
     */
    abstract protected function all(): null|LengthAwarePaginator|Collection;

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

    protected function isSoftDeleteable(Model $model): bool
    {
        return
            in_array(SoftDeletes::class, class_uses_recursive($model)) &&
            $this->hasColumn('deleted_at');
    }

    protected function hasColumn(string $column): bool
    {
        return Schema::hasColumn($this->getModel()->getTable(), $column);
    }
}
