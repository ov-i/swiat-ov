<?php

namespace Database\Seeders;

use App\Models\Posts\Category;
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
            ->count(20)
            ->create();
    }
}
