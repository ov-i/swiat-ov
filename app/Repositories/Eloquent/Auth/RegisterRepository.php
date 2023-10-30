<?php

namespace App\Repositories\Eloquent\Auth;

use App\Data\Auth\RegisterRequestData;
use App\Enums\Auth\RoleNamesEnum;
use App\Models\User;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Database\Eloquent\Model;

class RegisterRepository extends BaseRepository
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    /**
     * @param array<string, string>|RegisterRequestData $requestData
     * @return User|null
     */
    public function createUser(array|RegisterRequestData $requestData): ?Model
    {
        /** @var User $user */
        $user = $this->create($requestData);

        $user->assignRole(RoleNamesEnum::user()->value);
        $user->notify(new VerifyEmail());

        return $user;
    }
}
