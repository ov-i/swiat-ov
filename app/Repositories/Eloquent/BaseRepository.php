<?php

namespace App\Repositories\Eloquent;

use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\Data;

class BaseRepository extends EloquentRepository
{
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
     * Checks if pagination cursor from passed dataset is empty.
     *
     * @param CursorPaginator<Model> $cursor
     *
     * @return bool
     */
    protected function isPaginationCursorEmpty(CursorPaginator $cursor): bool
    {
        return 0 === count($cursor->items());
    }
}
