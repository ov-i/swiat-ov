<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Factories\Posts\CategoryFactory;
use App\Models\Posts\Category;

class PostCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory()->count(count(CategoryFactory::$categories))->create();
    }
}
