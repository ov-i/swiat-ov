<?php

namespace Database\Factories\Auth;

use App\Enums\Auth\RoleNamesEnum;
use App\Models\Auth\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @template TModel of Role
 *
 * @extends Factory<TModel>
 */
class RoleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = Role::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $role = fake()->unique()->randomElement(RoleNamesEnum::toValues());

        return [
            'name' => $role,
            'guard_name' => $role === RoleNamesEnum::subAuthor()->value ? 'api' : 'web',
        ];
    }
}
