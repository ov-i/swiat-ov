<?php

namespace App\Repositories\Eloquent\Users;

use App\Models\User;
use App\Repositories\Eloquent\BaseRepository;

class UserRepository extends BaseRepository
{
    public function __construct(
        User $user
    ) {
        parent::__construct($user);
    }

}
