<?php

namespace App\Exceptions;

use App\Models\User;
use Exception;
use Illuminate\Http\Response;

class AdminIsNotBlockableException extends Exception
{
    public function __construct(
        private readonly User $user
    ) {
        abort_if(false === $user->isAdmin(), Response::HTTP_FORBIDDEN);
        parent::__construct("A user {$user->name} is Administrator. He cannot be blocked.");
    }
}
