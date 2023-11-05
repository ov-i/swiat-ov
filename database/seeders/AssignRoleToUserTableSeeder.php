<?php

namespace Database\Seeders;

use App\Enums\Auth\RoleNamesEnum;
use App\Exceptions\UserNotFoundException;
use App\Services\Users\UserService;
use Illuminate\Database\Seeder;

class AssignRoleToUserTableSeeder extends Seeder
{
    public function __construct(
        private readonly UserService $userService,
    ) {
    }

    /**
     * Run the database seeds.
     * @throws UserNotFoundException
     */
    public function run(): void
    {
        if (app()->environment('production')) {
            $this->userService->assignRoleFromUserEmail('ov@swiat-ov.pl', RoleNamesEnum::admin());
            return;
        }

        $this->userService->assignRoleFromUserEmail('user@example1.com', RoleNamesEnum::admin());
        $this->userService->assignRoleFromUserEmail('user@example2.com', RoleNamesEnum::moderator());
        $this->userService->assignRoleFromUserEmail('user@example3.com', RoleNamesEnum::user());
        $this->userService->assignRoleFromUserEmail('user@example4.com', RoleNamesEnum::vipMember());
    }
}
