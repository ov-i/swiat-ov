<?php

namespace Database\Factories\Tickets;

use App\Enums\Ticket\TicketCategoriesEnum;
use App\Models\Tickets\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @template TModel of \App\Models\Tickets\Category
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<TModel>
 */
class TicketCategoriesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement(TicketCategoriesEnum::toValues()),
        ];
    }
}
