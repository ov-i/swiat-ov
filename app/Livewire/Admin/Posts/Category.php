<?php

namespace App\Livewire\Admin\Posts;

use App\Livewire\Resource;
use App\Repositories\Eloquent\Posts\CategoryRepository;

class Category extends Resource
{
    protected $repository = CategoryRepository::class;

    protected function getView(): string
    {
        return 'posts.category';
    }
}
