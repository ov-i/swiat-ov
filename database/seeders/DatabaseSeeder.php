<?php

namespace Database\Seeders;

use App\Enums\Auth\PermissionsEnum;
use App\Enums\Auth\RoleNamesEnum;
use App\Models\Auth\Permission;
use App\Models\Auth\Role;
use App\Models\Posts\Attachment;
use App\Models\Posts\Category;
use App\Models\Posts\Comment;
use App\Models\Posts\LangPost;
use App\Models\Posts\Post;
use App\Models\Posts\Tag;
use App\Models\User;
use Database\Factories\Posts\CategoryFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Permission::factory()->count(count(PermissionsEnum::toValues()))->create();
        Role::factory()->count(RoleNamesEnum::count())->create();
        Category::factory()->count(count(CategoryFactory::$categories))->create();

        User::factory()
            ->count(3)
            ->create();

        User::query()
            ->where('email', 'user@example1.com')
            ->first()
            ->assignRole(RoleNamesEnum::admin()->value);

        User::query()
            ->where('email', 'user@example2.com')
            ->first()
            ->assignRole(RoleNamesEnum::moderator()->value);

        User::query()
            ->where('email', 'user@example3.com')
            ->first()
            ->assignRole(RoleNamesEnum::user()->value);

        Post::factory()
            ->has(User::factory())
            ->has(Attachment::factory()->count(3))
            ->has(LangPost::factory()->count(3))
            ->has(Tag::factory()->count(3))
            ->has(Comment::factory()->count(10))
            ->create();

        Role::query()
            ->where('name', RoleNamesEnum::admin()->value)
            ->first()
            ->givePermissionTo(Permission::all());

        Role::query()
            ->where('name', RoleNamesEnum::user()->value)
            ->first()
            ->givePermissionTo(
                PermissionsEnum::postRead()->value,
                PermissionsEnum::postDelete()->value,
                PermissionsEnum::postCommentRead()->value,
                PermissionsEnum::postCommentWrite()->value,
                PermissionsEnum::postCommentDelete()->value,
                PermissionsEnum::siteMapRead()->value,
            );

        Role::query()
            ->where('name', RoleNamesEnum::moderator()->value)
            ->first()
            ->givePermissionTo(Permission::query()->whereNot('name', [
                PermissionsEnum::tokenWrite()->value,
                PermissionsEnum::tokenUpdate()->value,
                PermissionsEnum::tokenRestore()->value,
                PermissionsEnum::tokenDelete()->value,
                PermissionsEnum::tokenForceDelete()->value,
            ])->get());
    }
}
