<?php

namespace Database\Seeders;

use App\Enums\Auth\RoleNamesEnum;
use App\Services\Auth\AuthService;
use App\Strategies\Auth\RoleHasPermissions\AdminHasPermissionsStrategy;
use App\Strategies\Auth\RoleHasPermissions\ModeratorHasPermissions;
use App\Strategies\Auth\RoleHasPermissions\UserHasPermissionsStrategy;
use App\Strategies\Auth\RoleHasPermissions\VipMemberHasPermissionsStrategy;
use Illuminate\Database\Seeder;

class RolesPermissionsTableSeeder extends Seeder
{
    public function __construct(
        private readonly AuthService $authService,
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
        $userRole = $this->authService->getRoleByName(RoleNamesEnum::user());
        $this->authService
            ->giveRolePermissions($userRole, $this->userHasPermissionsStrategy);

        $adminRole = $this->authService->getRoleByName(RoleNamesEnum::admin());
        $this->authService
            ->giveRolePermissions($adminRole, $this->adminHasPermissionsStrategy);

        $moderator = $this->authService->getRoleByName(RoleNamesEnum::moderator());
        $this->authService
            ->giveRolePermissions($moderator, $this->moderatorHasPermissions);

        $vipMember = $this->authService->getRoleByName(RoleNamesEnum::vipMember());
        $this->authService
            ->giveRolePermissions($vipMember, $this->vipMemberHasPermissionsStrategy);
    }
}
