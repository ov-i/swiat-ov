<?php

namespace Database\Seeders;

use App\Enums\Auth\PermissionsEnum;
use App\Enums\Auth\RoleNamesEnum;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Auth\Permission;
use App\Models\Auth\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create();
        Permission::factory()->count(count(PermissionsEnum::toValues()))->create();
        Role::factory()->count(RoleNamesEnum::count())->create();

        $this->call([
            RolesPermissionsTableSeeder::class,
            AssignRoleToUserTableSeeder::class,
        ]);
    }
}
