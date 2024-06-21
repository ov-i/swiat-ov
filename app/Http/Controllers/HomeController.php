<?php

namespace App\Http\Controllers;

use App\Enums\ItemsPerPage;
use App\Repositories\Eloquent\Posts\PostRepository;
use App\Services\Post\PostService;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __construct(
        private readonly PostRepository $postRepository,
        private readonly PostService $postService,
    ) {
    }

    public function index(): View
    {
        $posts = $this->postRepository
            ->getPublishedPosts()
            ->paginate(ItemsPerPage::Default->value);

        return view('welcome', [
            'posts' => $posts,
        ]);
    }

    public function pricing(): View
    {
        return view('welcome');
    }
}
