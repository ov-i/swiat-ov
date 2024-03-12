<?php

namespace App\Repositories\Eloquent;

use App\Enums\ItemsPerPageEnum;
use App\Exceptions\NotSearchableModelException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Expression;
use Laravel\Scout\Builder as ScoutBuilder;
use Laravel\Scout\Searchable;
use Spatie\LaravelData\Data;

class BaseRepository extends EloquentRepository
{
    /**
     * @inheritDoc
     */
    public function all(
        bool $paginate = true,
        ?int $perPage = null,
        string $orderBy = 'asc',
        string $orderByColumn = 'id'
    ): null|LengthAwarePaginator|Collection {
        $models = $this->getModel()
            ->query()
            ->orderBy($orderByColumn, $orderBy);

        return $paginate ? $this->toPaginated($models) : $models->get();
    }

    public function searchBy(
        string $query, 
        bool $paginate = true, 
        callable $callback = null
    ): Collection|LengthAwarePaginator {
        $classModel = $this->getModel()::class;
        if (false === in_array(Searchable::class, class_uses_recursive($classModel))) {
            throw new NotSearchableModelException("The $classModel model is not searchable");
        }

        $searched = $this->getModel()->search($query, $callback);

        return $paginate ? $this->toPaginated($searched) : $searched->get();
    }

    public function find(string|int $id): ?Model
    {
        return $this->getModel()->query()->find($id);
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
    protected function update(Model &$model, Data|array $data): bool
    {
        return $model->update($data);
    }
    

    /**
     * Force delete works only for soft deleteable models.
     */
    protected function delete(Model &$model, bool $forceDelete = false): bool
    {
        if (true === $this->isSoftDeleteable($model) && $forceDelete) {
            $forceDelete = true;

            foreach ($model->getRelations() as $relation) {
                // TODO: sprawzić na podstawie model:show czy model ma jakieś relacje
            }

            return $model->forceDelete();
        }

        return $model->delete();
    }

    /**
     * Paginates collection. If perPage is null, it sets perPage value to 10.
     * 
     * @param Builder $builder
     * @param ?int $perPage Default: 10
     */
    protected function toPaginated(Builder|ScoutBuilder &$builder, ?int $perPage = null)
    {
        $perPage = blank($perPage) ? ItemsPerPageEnum::DEFAULT : $perPage;

        return $builder->paginate($perPage);
    }
}
