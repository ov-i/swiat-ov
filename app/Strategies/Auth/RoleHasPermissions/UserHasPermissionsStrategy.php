<?php

namespace App\Strategies\Auth\RoleHasPermissions;

use App\Enums\Auth\PermissionsEnum;

class UserHasPermissionsStrategy implements RoleHasPermissionsStrategyInterface
{
    /**
     * @inheritdoc
     */
    public function boot(): array
    {
        return PermissionsEnum::userPermissions();
    }
}
