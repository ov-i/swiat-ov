<?php

declare(strict_types=1);

namespace App\Services\Users;

use App\Enums\Auth\RoleNamesEnum;
use App\Exceptions\UserNotFoundException;
use App\Models\Auth\Role;
use App\Models\User;
use App\Repositories\Eloquent\Users\UserRepository;
use App\Strategies\Auth\RoleHasPermissions\RoleHasPermissionsStrategy;
use App\Strategies\Auth\RoleHasPermissions\RoleHasPermissionsStrategyInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly RoleHasPermissionsStrategy $roleHasPermissionsStrategy,
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

    /**
     * @param string ...$roles Seperated by (optional) coma roles
     *
     * @return self
     */
    public function assignRole(User $user, string ...$roles): self
    {
        $user->assignRole($roles);

        return $this;
    }

    public function assignRoleFromUserEmail(string $userEmail, RoleNamesEnum $role): ?self
    {
        /** @var ?User $user */
        $user = User::query()->where('email', $userEmail)->first();
        if (null === $user) {
            throw new UserNotFoundException("User with an email [{$userEmail}] does not exist");
        }

        $this->assignRole($user, $role->value);

        return $this;
    }

    public function giveUserPermissions(User $user, string ...$permissions): self
    {
        $user->givePermissionTo($permissions);

        return $this;
    }

    public function giveRolePermissions(
        Role $role,
        RoleHasPermissionsStrategyInterface $rolePermissionsStrategy
    ): self {
        $roleHasPermissionsStrategy = $this->roleHasPermissionsStrategy
            ->setPermissionsInstance($rolePermissionsStrategy);

        $role->givePermissionTo(...$roleHasPermissionsStrategy->register());

        return $this;
    }

    public function getRoleByName(RoleNamesEnum $roleName): Role
    {
        return Role::query()->where('name', $roleName->value)->first();
    }

    public function getRolePermissions(Role $role): Collection
    {
        return $role->permissions()->get();
    }
}
