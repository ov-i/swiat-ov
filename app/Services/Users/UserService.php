<?php

declare(strict_types=1);

namespace App\Services\Users;

use App\Enums\ItemsPerPageEnum;
use App\Events\Auth\UserDeleted;
use App\Models\User;
use App\Repositories\Eloquent\Users\UserRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {
    }

    /**
     * @return ?LengthAwarePaginator<User>
     */
    public function getUsersWithRoles(): ?LengthAwarePaginator
    {
        $users = $this->userRepository
            ->with(['roles'])
            ->orderBy('id')
            ->paginate(ItemsPerPageEnum::DEFAULT);

        return filled($users) ? $users : null;
    }

    public function deleteUser(User &$user, bool $forceDelete = false): void
    {
        $this->userRepository->deleteUser($user, $forceDelete);

        event(new UserDeleted($user));
    }
}
