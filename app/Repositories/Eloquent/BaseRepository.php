<?php

namespace App\Repositories\Eloquent;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\Data;

class BaseRepository extends EloquentRepository
{
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
     * @param Data|array<array-key, mixed> $data
     */
    protected function create(Data|array $data): ?Model
    {
        if (is_array($data)) {
            return $this->getModel()->query()->create($data);
        }

        return $this->getModel()->query()->create($data->toArray());
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
     * @param string $param
     * @param string|int|array $condition
     * @param string $operator
     */
    public function findAllBy(string $param, string|int|array $condition, string $operator = '='): ?Collection
    {
        return $this->getModel()->query()
            ->where($param, $operator, $condition)
            ->get();
    }
}
