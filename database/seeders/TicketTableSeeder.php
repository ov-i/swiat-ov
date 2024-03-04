<?php

namespace Database\Seeders;

use App\Enums\Ticket\TicketCategoriesEnum;
use App\Models\Tickets\Category;
use App\Models\Tickets\Ticket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {        
        Category::factory()
            ->has(Ticket::factory())
            ->count(count(TicketCategoriesEnum::toValues()))
            ->create();
    }
}
