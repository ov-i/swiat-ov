<?php

namespace App\Http\Controllers;

use App\Enums\ItemsPerPage;
use App\Models\Posts\Post;
use App\Services\Post\PostService;
use Illuminate\Contracts\View\View;

class PostController extends Controller
{
    public function __construct(
        private readonly PostService $postService
    ) {
    }

    public function show(Post $post): View
    {
        if ($post->isVipOnly()) {
            $user = auth()->user();

            $this->authorize('view-vip-posts', $user);
        }

        $comments = $this->postService->getAcceptedComments($post)->paginate(ItemsPerPage::Default->value);

        return view('posts.show', compact('post', 'comments'));
    }
}
