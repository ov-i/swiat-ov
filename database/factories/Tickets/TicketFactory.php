<?php

namespace Database\Factories;

use App\Models\Tickets\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

/**
 * @template TModel of Ticket
 *
 * @extends Factory<TModel>
 */
class TicketFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = Ticket::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => Uuid::uuid4(),
            'title' => fake()->realText(),
            'user_id'
        ];
    }
}
