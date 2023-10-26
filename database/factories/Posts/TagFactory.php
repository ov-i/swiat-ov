<?php

namespace Database\Factories\Posts;

use App\Models\Posts\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @template TModel of Tag
 *
 * @extends Factory<TModel>
 */
class TagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = Tag::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement(['it', 'lifestyle', 'php', 'js', 'devops']),
        ];
    }
}
