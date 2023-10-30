<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Services\RegisterService;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    public function __construct(
        private readonly RegisterService $registerService,
    ) {
    }

    /**
     * Validate and create a newly registered user.
     *
     * @param array $input
     * @return User
     * @throws ValidationException
     */
    public function create(array $input): User
    {
        return $this->registerService->create($input);
    }
}
