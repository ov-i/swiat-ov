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

    public function setPermissionsInstance(RoleHasPermissionsStrategyInterface $permission): self
    {
        $this->permission = $permission;

        return $this;
    }

    /**
     * Returns the booted strategy
     *
     * @return array<int|string, int|string>
     */
    public function register(): array
    {
        return $this->permission->boot();
    }
}
