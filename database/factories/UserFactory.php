<?php

namespace Database\Factories;

use App\Enums\Auth\BanDurationEnum;
use App\Enums\Auth\UserStatusEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @template TModel of User
 *
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * @var class-string<TModel>
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $adminPass = 'password';
        if (false === app()->environment('testing')) {
            $adminPass = config('app.admin_pass');
        }

        return [
            'name' => 'ov',
            'email' => 'ov@swiat-ov.pl',
            'ip' => fake()->ipv4(),
            'email_verified_at' => now(),
            'password' => bcrypt($adminPass),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function locked(BanDurationEnum|null $banDuration = null): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => UserStatusEnum::banned(),
            'banned_at' => now(),
            'ban_duration' => $banDuration ?? BanDurationEnum::oneDay()->value,
        ]);
    }

    public function dummy(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => fake()->userName(),
            'email' => fake()->safeEmail(),
            'ip' => fake()->ipv4(),
            'email_verified_at' => now(),
            'password' => fake()->password(),
            'remember_token' => Str::random(10),
        ]);
    }
}
