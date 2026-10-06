<?php

namespace App\Http\Controllers\Kelola;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

// kelola artikel untuk admin & editor (route-nya dilindungi middleware role:admin,editor)
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Post::class);

        $posts = Post::with('user')->latest()->paginate(10);

        return view('kelola.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Post::class);

        return view('kelola.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        Gate::authorize('create', Post::class);

        $post = new Post($request->validated());
        $post->slug = $this->buatSlug($post->title);
        $post->user()->associate($request->user());
        $post->save();

        return redirect()->route('kelola.posts.index')->with('success', 'Artikel berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        Gate::authorize('update', $post);

        return view('kelola.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        Gate::authorize('update', $post);

        $post->fill($request->validated());
        if ($post->isDirty('title')) {
            $post->slug = $this->buatSlug($post->title, $post->id);
        }
        $post->save();

        return redirect()->route('kelola.posts.index')->with('success', 'Artikel berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);

        $post->delete();

        return redirect()->route('kelola.posts.index')->with('success', 'Artikel "' . $post->title . '" dihapus.');
    }

    // slug unik, kalau sudah dipakai ditambah angka di belakang
    private function buatSlug(string $title, ?int $abaikanId = null): string
    {
        $dasar = Str::slug($title);
        $slug = $dasar;
        $i = 2;

        while (Post::where('slug', $slug)->when($abaikanId, fn ($q) => $q->whereKeyNot($abaikanId))->exists()) {
            $slug = $dasar . '-' . $i++;
        }

        return $slug;
    }
}
