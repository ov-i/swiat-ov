<?php

namespace App\Strategies\Auth\RoleHasPermissions;

class RoleHasPermissionsStrategy
{
    /**
     * Strategy instance for setting up proper permissions to a specific role.
     *
     * @var RoleHasPermissionsStrategyInterface $permission
     */
    private RoleHasPermissionsStrategyInterface $permission;

    /**
     * Available permissions for a role.
     *
     * @var array<array-key, string>
     */
    private array $permissionsList;

    public function setPermissionsInstance(RoleHasPermissionsStrategyInterface $permission): self
    {
        $this->permission = $permission;

        return $this;
    }

    public function register(): array
    {
        return $this->permission->boot();
    }
}
