<?php

namespace App\Http\Controllers;

use App\Models\Posts\Post;
use Illuminate\Contracts\View\View;

class PostController extends Controller
{
    public function show(Post $post): View
    {
        if ($post->isVipOnly()) {
            $user = auth()->user();

            $this->authorize('view-vip-posts', $user);
        }

        return view('posts.show', compact('post'));
    }
}
