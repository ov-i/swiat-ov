<?php

namespace App\Contracts;

use Illuminate\Contracts\Database\Query\Expression;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\Data;

interface EloquentRepository
{
    /**
     * Gets all models from database
     */
    public function all(
        bool $paginate = true,
        int|null $perPage = null,
        string $orderBy = 'asc',
        string $orderByColumn = 'id'
    ): LengthAwarePaginator|Collection|null;

    /**
     * Finds the result based on id
     */
    public function find(string|int $id): Model|null;

    /**
     * Finds single record from database that matches condition
     *
     * @param string|int|non-empty-list<array-key, mixed> $condition
     */
    public function findBy(
        string $column,
        array|int|string $condition,
        string $operator = '='
    ): Model|null;

    /**
     * @param non-empty-list<array-key, mixed>|\Closure|string|Expression $param
     */
    public function findWhere(
        array|\Closure|string|Expression $params,
        mixed $operator = null,
        mixed $value = null,
        string $boolean = 'and',
    ): Builder;

    /**
     * Finds all records matching condition
     *
     * @param non-empty-list<array-key, non-empty-list<array-key, string>>|string $param
     * @param string|int|non-empty-list<array-key, mixed> $condition
     *
     * @return Collection<int, Model>|LengthAwarePaginator<Model>
     */
    public function findAllBy(
        array|string $param,
        string|int|array $condition = null,
        string|null $operator = '=',
        bool $paginate = false
    ): Collection|LengthAwarePaginator;

    /**
     * Creates new record with passed data
     *
     * @param non-empty-list<array-key, scalar>|Data $data
     */
    public function create(Data|array $data): Model|null;
}
