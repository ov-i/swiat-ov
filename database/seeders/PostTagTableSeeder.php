<?php

namespace Database\Seeders;

use App\Models\Posts\Tag;
use Illuminate\Database\Seeder;

class PostTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::factory()->count(3)->create();
    }
}
