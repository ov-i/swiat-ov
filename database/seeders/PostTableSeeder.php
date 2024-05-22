<?php

namespace Database\Seeders;

use App\Models\Posts\Category;
use App\Models\Posts\Comment;
use Illuminate\Database\Seeder;
use App\Models\Posts\Post;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::factory()
            ->for(Category::factory())
            ->has(Comment::factory()->count(5))
            ->count(20)
            ->create();
    }
}
