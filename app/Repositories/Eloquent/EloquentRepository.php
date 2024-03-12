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
    abstract protected function all();

    /**
     * Finds the result based on id
     *
     * @param string|int $id Unique identifier
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    abstract protected function find($id);

    /**
     * Creates new record with passed data
     *
     * @param Data|array<array-key, scalar> $data
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    abstract protected function create($data);

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Determinates if passed model instance is soft deleteable.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return bool
     */
    protected function isSoftDeleteable(&$model)
    {
        return
            in_array(SoftDeletes::class, class_uses_recursive($model)) &&
            $this->hasColumn('deleted_at');
    }

    /**
     * @param string $column
     *
     * @return bool
     */
    protected function hasColumn($column): bool
    {
        return Schema::hasColumn($this->getModel()->getTable(), $column);
    }
}
