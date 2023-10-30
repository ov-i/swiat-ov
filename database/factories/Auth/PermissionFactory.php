<?php

namespace Database\Factories\Auth;

use App\Enums\Auth\PermissionsEnum;
use App\Models\Auth\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @template TModel of Permission
 *
 * @extends Factory<TModel>
 */
class PermissionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = Permission::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->randomElement(PermissionsEnum::toValues());

        return [
            'name' => $name,
            'guard_name' => 'web',
        ];
    }
}
