<?php

namespace Database\Seeders;

use App\Models\Posts\Comment;
use App\Models\Posts\LangPost;
use App\Models\Posts\Tag;
use App\Models\User;
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
            ->has(User::factory())
            ->has(LangPost::factory()->count(3))
            ->has(Tag::factory())
            ->has(Comment::factory()->count(10))
            ->create();
    }
}
