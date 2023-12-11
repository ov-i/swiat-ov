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
        $this->authService->assignRolesFromUserEmail('ov@swiat-ov.pl', RoleNamesEnum::admin());
    }
}
