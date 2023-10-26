<?php

namespace Database\Factories\Posts;

use App\Enums\Post\AllowPostLangsEnum;
use App\Models\Posts\LangPost;
use App\Models\Posts\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @template TModel of LangPost
 *
 * @extends Factory<TModel>
 */
class LangPostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = LangPost::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'post_id' => Post::factory()->create(),
            'langs' => fake()->unique()->randomElement(AllowPostLangsEnum::toValues())
        ];
    }
}
