<?php

namespace App\Repositories\Eloquent;

use App\Enums\ItemsPerPageEnum;
use App\Exceptions\NotSearchableModelException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Expression;
use Laravel\Scout\Searchable;
use Spatie\LaravelData\Data;

class BaseRepository extends EloquentRepository
{
    /**
     * @param bool $paginate
     * @param int|null $perPage If null it gets 10 as default
     * @param string $orderBy
     * @param string $orderByColumn
     *
     * @return \Illuminate\Database\Eloquent\Collection<Model>|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function all($paginate = true, $perPage = null, $orderBy = 'asc', $orderByColumn = 'id')
    {
        $models = $this->getModel()
            ->query()
            ->orderBy($orderByColumn, $orderBy);

        return $paginate ? $this->toPaginated($models) : $models->get();
    }

    /**
     * Searches through laravel scout for a given phrase.
     *
     * @param string $query Searched phrase from model's property
     * @param bool $paginate
     * @param \Closure $callback
     *
     * @return \Illuminate\Database\Eloquent\Collection<Model>|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @throws NotSearchableModelException If model is not searchable.
     */
    public function searchBy($query, $paginate = true, $callback = null)
    {
        $classModel = $this->getModel()::class;
        if (false === in_array(Searchable::class, class_uses_recursive($classModel))) {
            throw new NotSearchableModelException("The $classModel model is not searchable.");
        }

        /** @var \Laravel\Scout\Builder $searched */
        $searched = $this->getModel()->search($query, $callback);

        return $paginate ? $this->toPaginated($searched) : $searched->get();
    }

    /**
     * @inheritDoc
     */
    public function find($id)
    {
        return $this->getModel()->query()->find($id);
    }

    /**
     * Finds single record from database that matches condition
     *
     * @param string $column
     * @param string|int|array<array-key, mixed> $condition
     * @param string $operator Default '='
     *
     * @return Model|null
     */
    public function findBy($column, $condition, $operator = '=')
    {
        return $this->getModel()
            ->firstWhere($column, $operator, $condition);
    }

    /**
     * Finds all records matching condition
     *
     * @param array<array-key, array<array-key, string>>|string $param
     * @param string|int|array<array-key, mixed> $condition
     * @param string|null $operator
     * @param bool $paginate
     *
     * @return \Illuminate\Database\Eloquent\Collection<Model>|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function findAllBy($param, $condition = null, $operator = '=', $paginate = false)
    {
        $records = $this->getModel()->query()->where($param, $operator, $condition);

        if ($paginate) {
            return $this->toPaginated($records);
        }

        return $records->get();
    }

    /**
     * @param array<array-key, mixed>|\Closure|string|Expression $param
     * @param mixed $operator
     * @param mixed $value
     * @param string $boolean
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function findWhere($params, $operator = null, $value = null, $boolean = 'and')
    {
        return $this->getModel()->query()
            ->where($params, $operator, $value, $boolean);
    }

    /**
     * @param Data|array<array-key, scalar> $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function create($data)
    {
        if (is_array($data)) {
            return $this->getModel()->query()->create($data);
        }

        return $this->getModel()->query()->create($data->toArray());
    }

    /**
     * @param Data|array<array-key, scalar> $data
     *
     * @return bool
     */
    protected function update(Model &$model, Data|array $data)
    {
        return $model->update($data);
    }


    /**
     * Force delete works only for soft deleteable models.
     *
     * @param Model $model
     * @param bool $forceDelete = false
     *
     * @return bool
     */
    protected function delete(&$model, $forceDelete = false)
    {
        if (true === $this->isSoftDeleteable($model) && $forceDelete) {
            return $model->forceDelete();
        }

        return $model->delete();
    }

    /**
     * Paginates collection. If perPage is null, it sets perPage value to 10.
     *
     * @param \Laravel\Scout\Builder|\Illuminate\Database\Eloquent\Builder $builder
     * @param int|null $perPage
     *
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    protected function toPaginated($builder, $perPage = null)
    {
        $perPage = blank($perPage) ? ItemsPerPageEnum::DEFAULT : $perPage;

        return $builder->paginate($perPage);
    }
}
