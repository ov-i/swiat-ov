<?php

namespace App\Repositories\Eloquent;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Expression;
use Spatie\LaravelData\Data;

class BaseRepository extends EloquentRepository
{
    /**
     * @return null|Collection<Model>
     */
    public function get(): ?Collection
    {
        return $this->getModel()->query()->get();
    }

    /**
     * @inheritDoc
     */
    protected function all(): ?LengthAwarePaginator
    {
        $models = $this->getModel()
            ->query()
            ->orderBy("id", "desc")
            ->paginate(10);

        if (false === $models->isNotEmpty()) {
            return null;
        }

        return $models;
    }

    protected function find(string|int $id): ?Model
    {
        return $this->getModel()->query()->find($id);
    }

    /**
     * @param Data|array<array-key, scalar> $data
     */
    protected function create(Data|array $data): ?Model
    {
        if (is_array($data)) {
            return $this->getModel()->query()->create($data);
        }

        return $this->getModel()->query()->create($data->toArray());
    }

    /**
     * @param Data|array<array-key, scalar> $data
     */
    protected function update(Data|array $data): bool
    {
        return $this->getModel()->query()->update($data);
    }

    /**
     * Force delete works only for soft deleteable models.
     */
    protected function delete(Model &$model, bool $forceDelete = false): bool
    {
        if (true === $this->isSoftDeleteable($model) && $forceDelete) {
            $forceDelete = true;

            return $model->forceDelete();
        }

        return $model->delete();
    }

    /**
     * Finds single record from database that matches condition
     *
     * @param string $param
     * @param string|int|array $condition
     * @param string $operator Default '='
     */
    public function findBy(string $param, string|int|array $condition, string $operator = '='): ?Model
    {
        return $this->getModel()->query()
            ->where($param, $operator, $condition)
            ->first();
    }

    /**
     * Finds all records matching condition
     *
     * @param array<array-key, array<array-key, string>>|string $param
     * @param string|int|array $condition
     * @param string $operator
     */
    public function findAllBy(string|array $param, null|string|int|array $condition = null, ?string $operator = '='): ?Collection
    {
        return $this->getModel()->query()
            ->where($param, $operator, $condition)
            ->get();
    }

    public function findWhere(
        array|\Closure|string|Expression $params,
        mixed $operator = null,
        mixed $value = null,
        string $boolean = 'and',
    ): Builder {
        return $this->getModel()->query()
            ->where($params, $operator, $value, $boolean);
    }
}
