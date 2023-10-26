<?php

namespace Database\Factories\Posts;

use App\Models\Posts\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @template TModel of Category
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<TModel>
 */
class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = Category::class;

    public static array $categories = [
        'lifestyle',
        'it',
        'rozwój',
        'programowanie',
        'cybersec'
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement(self::$categories),
        ];
    }
}
