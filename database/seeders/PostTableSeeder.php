<?php

namespace Database\Seeders;

use App\Models\Posts\Comment;
use App\Models\Posts\LangPost;
use App\Models\Posts\Tag;
use App\Models\User;
use Database\Factories\Posts\CategoryFactory;
use Illuminate\Database\Seeder;
use App\Models\Posts\Category;
use App\Models\Posts\Post;
use App\Models\Posts\Attachment;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {        
        Category::factory()->count(count(CategoryFactory::$categories))->create();
        Post::factory()
            ->has(User::factory())
            ->has(LangPost::factory()->count(3))
            ->has(Tag::factory()->count(3))
            ->has(Comment::factory()->count(10))
            ->create();
        Attachment::factory()->count(3);
    }
}
