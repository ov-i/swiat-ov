<?php

namespace Database\Factories;

use App\Enums\Ticket\TicketCategoriesEnum;
use App\Models\Tickets\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @template TModel of Category
 *
 * @extends Factory<TModel>
 */
class CategoryFactory extends Factory
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
        $allowedCategories = TicketCategoriesEnum::toValues();

        return [
            'name' => fake()->unique()->randomElement($allowedCategories),
        ];
    }
}
