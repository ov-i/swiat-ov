<?php

namespace App\Strategies\Auth\RoleHasPermissions;

interface RoleHasPermissionsStrategyInterface
{
    /**
     * @return array<string>
     */
    public function boot(): array;
}
