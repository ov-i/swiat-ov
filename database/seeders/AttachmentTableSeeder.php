<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Posts\Attachment;

class AttachmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Attachment::factory()->count(3);
    }
}
