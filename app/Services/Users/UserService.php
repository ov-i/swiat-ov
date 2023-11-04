<?php

declare(strict_types=1);

namespace App\Services\Users;

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
     * Gets all tickets that belong to a User, and paginates them.
     * 
     * @param User $user
     * 
     * @return LengthAwarePaginator|null Returns null, if user was not found.
     */
    public function getUserTickets(User $user): ?LengthAwarePaginator
    {
        if (false === $this->hasAnyTickets($user)) {
            return null;
        }

        return $user->tickets()
            ->orderByDesc()
            ->paginate(10);
    }

    /**
     * Checks if user has any tickets.
     * 
     * @param User $user
     * 
     * @return bool
     */
    public function hasAnyTickets(User $user): bool
    {
        return 0 === count($user->tickets()->get());
    }
}