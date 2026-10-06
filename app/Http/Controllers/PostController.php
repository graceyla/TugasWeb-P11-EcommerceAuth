<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Gate;

// halaman artikel untuk pengunjung (publik)
class PostController extends Controller
{
    public function index()
    {
        $posts = Post::published()->with('user')->latest()->paginate(6);

        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        // draft dianggap ga ada (404) kalau yang buka bukan admin / penulisnya
        abort_unless(Gate::allows('view', $post), 404);

        $post->load('user');

        return view('posts.show', compact('post'));
    }
}
