<?php

namespace App\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\Data;

class BaseRepository extends EloquentRepository
{
    protected function find(string|int $id): ?Model
    {
        return $this->getModel()->query()->find($id);
    }

    protected function create(Data|array $data): ?Model
    {
        if (is_array($data)) {
            return $this->getModel()->query()->create($data);
        }

        return $this->getModel()->query()->create($data->toArray());
    }
}
