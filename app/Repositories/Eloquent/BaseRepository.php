<?php

namespace App\Repositories\Eloquent;

use App\Contracts\EloquentRepository;
use App\Enums\ItemsPerPageEnum;
use App\Exceptions\NotSearchableModelException;
use Closure;
use Illuminate\Contracts\Database\Query\Expression as QueryExpression;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;
use Laravel\Scout\Builder as ScoutBuilder;
use Laravel\Scout\Searchable;
use Spatie\LaravelData\Data;

abstract class BaseRepository implements EloquentRepository
{
    /**
     * @return class-string<\Illuminate\Database\Eloquent\Model>
     */
    abstract protected static function getModelFqcn();

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    final public function getModel()
    {
        $modelFqcn = static::getModelFqcn();

        $modelable = new $modelFqcn();

        if (!$modelable instanceof Model) {
            throw new \LogicException(__('Only classes that extends Illuminate\\Database\\Eloquent\\Model can be used.'));
        }

        return $modelable;
    }

    /**
     * @inheritDoc
     */
    public function all(bool $paginate = true, ?int $perPage = null, string $orderBy = 'asc', string $orderByColumn = 'id'): LengthAwarePaginator|Collection|null
    {
        $models = $this->getModel()
            ->query()
            ->orderBy($orderByColumn, $orderBy);

        return $paginate ? $this->toPaginated($models) : $models->get();
    }

    /**
     * Searches through laravel scout for a given phrase.
     *
     * @throws NotSearchableModelException If model is not searchable.
     * @return Collection<int, Model>|LengthAwarePaginator
     */
    public function searchBy(
        string $query,
        bool $paginate = true,
        Closure|null $callback = null,
        ?int $perPage = null,
    ): Collection|LengthAwarePaginator {
        $classModel = $this->getModel()::class;
        if (!in_array(Searchable::class, class_uses_recursive($classModel))) {
            throw new NotSearchableModelException("The $classModel model is not searchable.");
        }

        /** @var \Laravel\Scout\Builder $searched */
        $searched = $this->getModel()->search($query, $callback);

        return $paginate ? $this->toPaginated($searched, $perPage) : $searched->get();
    }

    /**
     * @inheritDoc
     */
    public function find(string|int $id): ?Model
    {
        return $this->getModel()->query()->find($id);
    }

    /**
     * @inheritDoc
     */
    public function create(Data|array $data): ?Model
    {
        if (is_array($data)) {
            return $this->getModel()->query()->create($data);
        }

        return $this->getModel()->query()->create($data->toArray());
    }

    /**
     * @inheritDoc
     */
    public function findBy(
        string $column,
        array|int|string $condition,
        string $operator = '='
    ): ?Model {
        return $this->getModel()
            ->firstWhere($column, $operator, $condition);
    }

    /**
     * @inheritDoc
     */
    public function findAllBy(
        array|string $param,
        null|string|int|array $condition = null,
        ?string $operator = '=',
        bool $paginate = false
    ): Collection|LengthAwarePaginator {
        $records = $this->getModel()->query()->where($param, $operator, $condition);

        if ($paginate) {
            return $this->toPaginated($records);
        }

        return $records->get();
    }

    /**
     * @inheritDoc
     */
    public function findWhere(
        array|Closure|string|QueryExpression $params,
        mixed $operator = null,
        mixed $value = null,
        string $boolean = 'and'
    ): Builder {
        return $this->getModel()->query()
            ->where($params, $operator, $value, $boolean);
    }

    protected function update(
        Model &$model,
        array|Data $data
    ): bool {
        if ($data instanceof Data) {
            return $model->update($data->toArray());
        }

        return $model->update($data);
    }

    /**
     * @param non-empty-list<array-key, string> @relations
     */
    public function with(array $relations, callable|string|null $callback = null): Builder
    {
        return $this->getModel()
            ->with($relations, $callback);
    }

    /**
     * Updates only dirty attributes.
     *
     * @return bool Returns true if model is clean.
     */
    protected function updateDirty(Model &$model): bool
    {
        foreach($model->getDirty() as $dirty) {
            $model->update($dirty);
        }

        return $model->isClean();
    }

    /**
     * Force delete works only for soft deleteable models.
     *
     * @return bool
     */
    protected function delete(Model &$model, bool $forceDelete = false)
    {
        if (true === $this->isSoftDeleteable($model) && $forceDelete) {
            return $model->forceDelete();
        }

        return $model->delete();
    }

    /**
     * Paginates collection. If perPage is null, it sets perPage value to 10.
     *
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    protected function toPaginated(Builder|ScoutBuilder $builder, int|null $perPage = null)
    {
        $perPage = blank($perPage) ? ItemsPerPageEnum::DEFAULT : $perPage;

        return $builder->paginate($perPage);
    }

    /**
     * Determinates if passed model instance is soft deleteable.
     *
     * @return bool
     */
    protected function isSoftDeleteable(Model &$model)
    {
        return
            in_array(SoftDeletes::class, class_uses_recursive($model)) &&
            $this->hasColumn('deleted_at');
    }

    /**
     * @return bool
     */
    protected function hasColumn(string $column): bool
    {
        return Schema::hasColumn($this->getModel()->getTable(), $column);
    }
}
