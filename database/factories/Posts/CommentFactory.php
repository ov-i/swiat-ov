<?php

namespace Database\Factories\Posts;

use App\Enums\Post\CommentStatus;
use App\Models\Posts\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @template TModel of Comment
 *
 * @extends Factory<TModel>
 */
class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'content' => fake()->realText(120),
            'status' => fake()->randomElement(CommentStatus::toArray()),
        ];
    }
}
