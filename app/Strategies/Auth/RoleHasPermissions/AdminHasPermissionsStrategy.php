<?php

namespace App\Strategies\Auth\RoleHasPermissions;

use App\Enums\Auth\PermissionsEnum;

class AdminHasPermissionsStrategy implements RoleHasPermissionsStrategyInterface
{
    /**
     * @inheritdoc
     */
    public function boot(): array
    {
        return PermissionsEnum::toValues();
    }
}
