<?php

namespace Database\Factories;

use App\Enums\Auth\BanDurationEnum;
use App\Enums\Auth\UserBlockHistoryActionEnum;
use App\Models\UserBlockHistory;
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
            'user_id' => 1,
            'action' => fake()->randomElement($actions),
            'ban_duration' => app($this->model)->action === UserBlockHistoryActionEnum::locked() ? fake()->randomElement(BanDurationEnum::toValues()) : null
        ];
    }
}
