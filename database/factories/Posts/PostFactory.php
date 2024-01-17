<?php

namespace Database\Factories\Posts;

use App\Enums\Post\PostStatusEnum;
use App\Enums\Post\PostTypeEnum;
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
        $status = fake()->randomElement(PostStatusEnum::toValues());
        $archived = $status === PostStatusEnum::archived()->value;
        $published_at = $status === PostStatusEnum::published()->value ?
            now()->toDateTimeString() :
            null;

        return [
            'user_id' => 1,
            'category_id' => fake()->numberBetween(1, count(CategoryFactory::$categories)),
            'title' => fake()->unique()->realText(30),
            'type' => fake()->randomElement(PostTypeEnum::toValues()),
            'thumbnail_path' => fake()->imageUrl(1024, 1024, fake()->randomElement(PostTypeEnum::toValues())),
            'content' => fake()->realText(1000),
            'status' => $status,
            'archived' => $archived,
            'archived_at' => $archived ? now()->toDateString() : null,
            'published_at' => $archived ? null : $published_at,
        ];
    }

    public function unpublished(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => PostStatusEnum::unpublished(),
        ]);
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => PostStatusEnum::published(),
        ]);
    }
}
