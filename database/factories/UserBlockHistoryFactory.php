<?php

namespace Database\Factories;

use App\Enums\Auth\BanDurationEnum;
use App\Enums\Auth\UserBlockHistoryActionEnum;
use App\Models\UserBlockHistory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @template TModel of \App\Models\UserBlockHistory
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<TModel>
 */
class UserBlockHistoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = UserBlockHistory::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $actions = UserBlockHistoryActionEnum::toValues();

        return [
            'user_id' => User::factory(),
            'operator_id' => 1,
            'action' => fake()->randomElement($actions),
            'ban_duration' => app($this->model)->action === UserBlockHistoryActionEnum::locked() ? fake()->randomElement(BanDurationEnum::toValues()) : null
        ];
    }

    public function locked(BanDurationEnum $banDurationEnum): static
    {
        return $this->state(fn (array $attributes) => [
            'action' => UserBlockHistoryActionEnum::locked(),
            'ban_duration' => $banDurationEnum
        ]);
    }

    public function unlocked(): static
    {
        return $this->state(fn (array $attributes) => [
            'action' => UserBlockHistoryActionEnum::unlocked(),
        ]);
    }
}
