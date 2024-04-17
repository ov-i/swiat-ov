<?php

namespace Tests\Feature\Livewire\Admin\Posts\Index;

use App\Livewire\Admin\Posts\Index\PostIndex;
use Livewire\Livewire;
use Tests\TestCase;

class PageTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(PostIndex::class)
            ->assertStatus(200);
    }
}
