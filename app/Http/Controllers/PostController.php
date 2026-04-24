<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::published()
            ->news()
            ->orderByDesc('published_at')
            ->paginate(10);

        return view('posts.index', compact('posts'));
    }

    public function show(string $slug)
    {
        $post = Post::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedPosts = Post::published()
            ->where('category_type', $post->category_type)
            ->where('id', '!=', $post->id)
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return view('posts.show', compact('post', 'relatedPosts'));
    }

    public function recruitment()
    {
        $posts = Post::published()
            ->recruitment()
            ->orderByDesc('published_at')
            ->paginate(10);

        return view('posts.index', ['posts' => $posts, 'pageTitle' => 'Tuyển dụng']);
    }
}
