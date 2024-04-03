<?php

namespace Database\Seeders;

use App\Models\Posts\Attachment;
use App\Models\Posts\Comment;
use App\Models\Posts\LangPost;
use App\Models\Posts\Tag;
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
            ->has(LangPost::factory())
            ->has(Tag::factory())
            ->has(Comment::factory())
            ->has(Attachment::factory()->count(2))
            ->create();
    }
}
