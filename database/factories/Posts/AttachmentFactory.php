<?php

namespace Database\Factories\Posts;

use App\Models\Posts\Attachment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @template TModel of Attachment
 *
 * @extends Factory<TModel>
 */
class AttachmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = Attachment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $filename = sprintf('%s.%s', fake()->slug(2), fake()->fileExtension());

        return [
            'user_id' => 1,
            'original_name' => $filename,
            'filename' => sprintf('%s%s', fake()->uuid(), $filename),
            'checksum' => fake()->uuid(),
            'mimetype' => fake()->mimeType(),
            'size' => fake()->numberBetween(100, 100000),
            'location' => fake()->imageUrl(),
        ];
    }
}
