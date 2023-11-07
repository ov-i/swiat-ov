<?php

namespace Database\Seeders;

use App\Enums\Auth\RoleNamesEnum;
use App\Exceptions\UserNotFoundException;
use App\Services\Auth\AuthService;
use Illuminate\Database\Seeder;

class AssignRoleToUserTableSeeder extends Seeder
{
    public function __construct(
        private readonly AuthService $authService,
    ) {
    }

    /**
     * Run the database seeds.
     * @throws UserNotFoundException
     */
    public function run(): void
    {
        if (app()->environment('production')) {
            $this->authService->assignRolesFromUserEmail('ov@swiat-ov.pl', RoleNamesEnum::admin());
            return;
        }

        $this->authService->assignRolesFromUserEmail('user@example1.com', RoleNamesEnum::admin());
        $this->authService->assignRolesFromUserEmail('user@example2.com', RoleNamesEnum::moderator());
        $this->authService->assignRolesFromUserEmail(
            'user@example3.com',
            RoleNamesEnum::user(),
            RoleNamesEnum::vipMember()
        );

        $this->authService->assignRolesFromUserEmail('user@example4.com', RoleNamesEnum::user());
    }
}
