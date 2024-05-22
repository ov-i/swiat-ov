<?php

namespace App\Http\Controllers;

use App\Models\Posts\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

class PostController extends Controller
{
    public function show(Post $post): View
    {
        abort_if(!$post->isPublished(), Response::HTTP_NOT_FOUND);
        abort_if($post->isDelayed(), Response::HTTP_NOT_FOUND);

        if ($post->isVipOnly()) {
            $user = auth()->user();

            $this->authorize('view-vip-posts', $user);
        }

        return view('posts.show', compact('post'));
    }
}
