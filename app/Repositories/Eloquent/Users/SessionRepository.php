<?php

namespace App\Repositories\Eloquent\Users;

use App\Models\Session;
use App\Repositories\Eloquent\BaseRepository;

class SessionRepository extends BaseRepository
{
    public function __construct(
        private readonly Session $session
    ) {
        parent::__construct($session);
    }
}
