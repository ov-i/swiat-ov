<?php

namespace App\Repositories\Eloquent\Users;

use App\Models\Session;
use App\Repositories\Eloquent\BaseRepository;

class SessionRepository extends BaseRepository
{
    /**
     * @inheritDoc
     */
    protected static function getModelFqcn()
    {
        return Session::class;
    }
}
