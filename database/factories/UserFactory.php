<?php

namespace Database\Factories;

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
        if (app()->environment('production')) {
            return [
                'name' => 'ov',
                'email' => 'ov@swiat-ov.pl',
                'profile_photo_path' => fake()->imageUrl(640, 480, 'user'), // TODO: upload real photo profile
                'email_verified_at' => now(),
                'password' => bcrypt(config('admin_pass')),
                'remember_token' => Str::random(10),
            ];
        }

        return $this->generateFakeUsers();
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

    private function generateFakeUsers(): array
    {
        $userEmailNumber = fake()->unique()->numberBetween(1, 4);
        return [
            'name' => fake()->unique()->userName(),
            'ip' => fake()->ipv4(),
            'email' => "user@example{$userEmailNumber}.com",
            'profile_photo_path' => fake()->imageUrl(640, 480, 'user'),
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
        ];
    }
}
