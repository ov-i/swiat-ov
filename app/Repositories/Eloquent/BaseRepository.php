<?php

namespace App\Repositories\Eloquent;

use App\Contracts\EloquentRepository;
use App\Enums\ItemsPerPageEnum;
use App\Exceptions\NotSearchableModelException;
use App\Exceptions\NotSoftDeleteableModelException;
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
    public function all(
        bool $paginate = true,
        ?int $perPage = null,
        string $orderBy = 'asc',
        string $orderByColumn = 'id',
        bool $withTrashed = false,
    ): LengthAwarePaginator|Collection|null {
        $model = $this->getModel()
            ->query();

        if ($withTrashed) {
            $model = $this->withTrashed();
        }

        $model->orderBy($orderByColumn, $orderBy);

        return $paginate ? $this->toPaginated($model) : $model->get();
    }

    /**
     * Searches through laravel scout for a given phrase.
     *
     * @throws NotSearchableModelException If model is not searchable.
     */
    public function searchBy(
        string $query,
        Closure|null $callback = null,
    ): ScoutBuilder {
        $classModel = $this->getModel()::class;
        if (!in_array(Searchable::class, class_uses_recursive($classModel))) {
            throw new NotSearchableModelException("The $classModel model is not searchable.");
        }

        /** @var \Laravel\Scout\Builder $searched */
        $searched = $this->getModel()->search($query, $callback);

        return $searched;
    }

    /**
     * @inheritDoc
     */
    public function find(string|int $id, bool $withTrashed = false): ?Model
    {
        $model = $this->getModel();

        if($withTrashed) {
            $model = $this->withTrashed();
        }

        return $model->find($id);
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
        string $operator = '=',
        bool $withTrashed = false,
    ): ?Model {
        if ($withTrashed) {
            return $this->withTrashed()->firstWhere($column, $operator, $condition);
        }

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
        bool $paginate = false,
        bool $withTrashed = false,
    ): Collection|LengthAwarePaginator {
        $records = $this->getModel()->query()->where($param, $operator, $condition);

        if ($withTrashed) {
            $records = $this->withTrashed();
        }

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
        string $boolean = 'and',
        bool $withTrashed = false,
    ): Builder {
        if ($withTrashed) {
            return $this
                ->withTrashed()
                ->where($params, $operator, $value, $boolean);
        }

        return $this
                ->getModel()
                ->query()
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

    public function withTrashed(): Builder
    {
        $model = $this->getModel();
        if (!$this->isSoftDeleteable($model)) {
            throw new NotSoftDeleteableModelException();
        }

        return $model->withTrashed();
    }

    /**
     * Updates only dirty attributes.
     *
     * @return bool Returns true if model is clean.
     */
    protected function updateDirty(Model &$model): bool
    {
        foreach($model->getDirty() as $key => $dirty) {
            $model->{$key} = $dirty;

            $model->update();
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
