<?php

namespace App\Strategies\Auth\RoleHasPermissions;

use App\Enums\Auth\PermissionsEnum;

class ModeratorHasPermissions implements RoleHasPermissionsStrategyInterface
{
    /**
     * @inheritdoc
     */
    public function boot(): array
    {
        return PermissionsEnum::getAllExcept(
            basePermissions: PermissionsEnum::adminPermissions(),
            excepts: [
                PermissionsEnum::tokenWrite()->value,
                PermissionsEnum::userAssignRole()->value,
                PermissionsEnum::userRevokeRole()->value
            ],
        );
    }
}
