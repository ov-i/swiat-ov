<?php

namespace App\Strategies\Auth\RoleHasPermissions;

use App\Enums\Auth\PermissionsEnum;

class SubAuthorHasPermissionsStrategy implements RoleHasPermissionsStrategyInterface
{
    public function boot(): array
    {
        return [
            PermissionsEnum::postIndex()->value,
            PermissionsEnum::postRead()->value,
            PermissionsEnum::postCommentRead()->value,
            PermissionsEnum::licenseWrite()->value,
            PermissionsEnum::licenseRead()->value,
            PermissionsEnum::licenseIndex()->value,
        ];
    }
}
