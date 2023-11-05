<?php

namespace Database\Seeders;

use App\Enums\Auth\RoleNamesEnum;
use App\Models\Auth\Role;
use App\Services\Users\UserService;
use App\Strategies\Auth\RoleHasPermissions\AdminHasPermissionsStrategy;
use App\Strategies\Auth\RoleHasPermissions\ModeratorHasPermissions;
use App\Strategies\Auth\RoleHasPermissions\RoleHasPermissionsStrategy;
use App\Strategies\Auth\RoleHasPermissions\RoleHasPermissionsStrategyInterface;
use App\Strategies\Auth\RoleHasPermissions\SubAuthorHasPermissionsStrategy;
use App\Strategies\Auth\RoleHasPermissions\UserHasPermissionsStrategy;
use App\Strategies\Auth\RoleHasPermissions\VipMemberHasPermissionsStrategy;
use Illuminate\Database\Seeder;

class RolesPermissionsTableSeeder extends Seeder
{
    public function __construct(
        private readonly UserService $userService,
        private readonly UserHasPermissionsStrategy $userHasPermissionsStrategy,
        private readonly AdminHasPermissionsStrategy $adminHasPermissionsStrategy,
        private readonly ModeratorHasPermissions $moderatorHasPermissions,
        private readonly VipMemberHasPermissionsStrategy $vipMemberHasPermissionsStrategy,
    ) {
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userRole = $this->userService->getRoleByName(RoleNamesEnum::user());
        $this->userService
            ->giveRolePermissions($userRole, $this->userHasPermissionsStrategy);

        $adminRole = $this->userService->getRoleByName(RoleNamesEnum::admin());
        $this->userService
            ->giveRolePermissions($adminRole, $this->adminHasPermissionsStrategy);

        $moderator = $this->userService->getRoleByName(RoleNamesEnum::moderator());
        $this->userService
            ->giveRolePermissions($moderator, $this->moderatorHasPermissions);

        $vipMember = $this->userService->getRoleByName(RoleNamesEnum::vipMember());
        $this->userService
            ->giveRolePermissions($vipMember, $this->vipMemberHasPermissionsStrategy);

        // TODO: Fix seeder for api permissins
//        $subAuthor = $this->userService->getRoleByName(RoleNamesEnum::subAuthor());
//        $this->userService
//            ->giveRolePermissions($subAuthor, $this->subAuthorHasPermissionsStrategy);
    }
}
