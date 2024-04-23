<?php

namespace Database\Factories\Posts;

use App\Enums\PostStatus;
use App\Enums\PostType;
use App\Models\Posts\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @template TModel of Post
 *
 * @extends Factory<TModel>
 */
class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(PostStatus::cases());
        $archived = $status === PostStatus::Archived;
        $published_at = $status === PostStatus::Published ?
            now()->toDateTimeString() :
            null;

        return [
            'user_id' => 1,
            'category_id' => 1,
            'title' => fake()->unique()->realText(40),
            'slug' => fake()->unique()->slug(),
            'type' => fake()->randomElement(PostType::cases()),
            'thumbnail_path' => fake()->imageUrl(1024, 1024),
            'content' => fake()->realText(1000),
            'status' => $status,
            'archived' => $archived,
            'archived_at' => $archived ? now()->toDateString() : null,
            'published_at' => $archived ? null : $published_at,
            'created_at' => fake()->dateTime(),
        ];
    }

    public function unpublished(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => PostStatus::Unpublished,
            'archived_at' => null,
            'archived' => false
        ]);
    }

    public function published(?PostType $type = null): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => PostStatus::Published,
            'published_at' => now(),
            'type' => $type ?? PostType::Post
        ]);
    }
}
