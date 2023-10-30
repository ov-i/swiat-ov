<?php

namespace App\QueryBuilders;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UsersQueryBuilder extends Builder
{
    protected $model = User::class;

    /**
     * @return array<array-key, User>|null
     */
    public function getAll(): ?array
    {
        return $this->with(['blockUsers'])->get();
    }
}
