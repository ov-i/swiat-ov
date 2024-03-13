<?php

namespace App\Repositories\Eloquent\Auth;

use App\Data\Auth\RegisterRequestData;
use App\Models\User;
use App\Repositories\Eloquent\BaseRepository;
use Spatie\LaravelData\Data;

class AuthRepository extends BaseRepository
{
    /**
     * @param non-empty-list<string, mixed>|RegisterRequestData $requestData
     * @return User|null
     */
    public function createUser(Data|array $requestData)
    {
        /** @phpstan-ignore-next-line */
        return $this->create($requestData);
    }

    /**
     * @inheritDoc
     */
    protected static function getModelFqcn()
    {
        return User::class;
    }
}
