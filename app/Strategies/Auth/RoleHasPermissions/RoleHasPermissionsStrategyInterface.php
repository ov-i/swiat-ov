<?php

namespace App\Strategies\Auth\RoleHasPermissions;

interface RoleHasPermissionsStrategyInterface
{
    /**
     * @return array<int|string, int|string>
     */
    public function boot(): array;
}
