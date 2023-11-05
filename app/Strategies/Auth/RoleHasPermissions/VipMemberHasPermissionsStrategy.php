<?php

namespace App\Strategies\Auth\RoleHasPermissions;

use App\Enums\Auth\PermissionsEnum;

class VipMemberHasPermissionsStrategy implements RoleHasPermissionsStrategyInterface
{
    public function boot(): array
    {
        return [
            ...PermissionsEnum::userPermissions(),
            PermissionsEnum::postWrite()->value,
            PermissionsEnum::ticketWrite()->value,
            PermissionsEnum::ticketRead()->value,
            PermissionsEnum::ticketIndex()->value,
            PermissionsEnum::tokenRead()->value,
            PermissionsEnum::tokenIndex()->value,
        ];
    }
}