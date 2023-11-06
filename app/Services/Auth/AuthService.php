<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Data\Auth\RegisterRequestData;
use App\Enums\Auth\RoleNamesEnum;
use App\Exceptions\UserNotFoundException;
use App\Models\Auth\Role;
use App\Models\User;
use App\Repositories\Eloquent\Auth\AuthRepository;
use App\Strategies\Auth\RoleHasPermissions\RoleHasPermissionsStrategy;
use App\Strategies\Auth\RoleHasPermissions\RoleHasPermissionsStrategyInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Request;

class AuthService
{
    public function __construct(
        private readonly AuthRepository $authRepository,
        private readonly RoleHasPermissionsStrategy $roleHasPermissionsStrategy,
    ) {
    }

    /**
     * Creates new user and validates registration data
     *
     * @param RegisterRequestData $requestData
     *
     * @return User
     */
    public function create(RegisterRequestData $requestData): User
    {
        /** @var User $user */
        $user = $this->authRepository->createUser([
            ...$requestData->toArray(),
            'ip' => Request::ip(),
        ]);

        $this->assignRolesFromUserEmail($user->email, RoleNamesEnum::user());
        return $user;
    }


    /**
     * @param RoleNamesEnum ...$roles Seperated by (optional) coma roles
     * 
     * @return self
     */
    public function assignRolesFromUserEmail(string $userEmail, RoleNamesEnum ...$roles): ?self
    {
        /** @var ?User $user */
        $user = User::query()->where('email', $userEmail)->first();
        if (null === $user) {
            throw new UserNotFoundException("User with an email [{$userEmail}] does not exist");
        }

        foreach ($roles as $role) {
            $user->assignRole($role->value);
        }

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
