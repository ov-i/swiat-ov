<?php

namespace App\Http\Controllers;

use App\Models\Posts\Post;
use Illuminate\Contracts\View\View;

class PostController extends Controller
{
    public function show(Post $post): View
    {
        return view('posts.show', compact('post'));
    }
}
