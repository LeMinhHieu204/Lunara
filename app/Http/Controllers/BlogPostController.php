<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;

class BlogPostController extends Controller
{
    public function index() { return view('blog.index', ['posts' => BlogPost::where('status', 'published')->latest('published_at')->paginate(9)]); }
    public function show(BlogPost $post) { abort_unless($post->status === 'published', 404); return view('blog.show', compact('post')); }
}
