<?php

namespace App\Http\Controllers;

use App\Enums\Status;       
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Comment;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function home()
    {
        $featuredPosts = Post::where('status', Status::Published)  
            ->where('is_featured', true)
            ->latest('published_at')
            ->take(3)
            ->get();

        $recentPosts = Post::where('status', Status::Published)    
            ->latest('published_at')
            ->take(6)
            ->get();

        $popularPosts = Post::where('status', Status::Published)   
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();

        $categories = Category::withCount('posts')->get();

        return view('blog.home', compact('featuredPosts', 'recentPosts', 'popularPosts', 'categories'));
    }

    public function index()
    {
        $posts = Post::where('status', Status::Published)          
            ->with(['category', 'author'])
            ->latest('published_at')
            ->paginate(12);

        $categories = Category::withCount('posts')->get();
        $tags = Tag::withCount('posts')->get();

        return view('blog.index', compact('posts', 'categories', 'tags'));
    }

    public function show(string $slug)
    {
        $post = Post::where('slug', $slug)
            ->where('status', Status::Published)                   
            ->firstOrFail();

        $post->increment('views');

        $relatedPosts = Post::where('status', Status::Published)   
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        $comments = $post->comments()
            ->where('is_approved', true)
            ->latest()
            ->get();

        return view('blog.show', compact('post', 'relatedPosts', 'comments'));
    }

    public function category(Category $category)
    {
        $posts = $category->posts()
            ->where('status', Status::Published)                   
            ->latest('published_at')
            ->paginate(12);

        return view('blog.category', compact('category', 'posts'));
    }

    public function tag(Tag $tag)
    {
        $posts = $tag->posts()
            ->where('status', Status::Published)                  
            ->latest('published_at')
            ->paginate(12);

        return view('blog.tag', compact('tag', 'posts'));
    }

    public function storeComment(Request $request, Post $post)
    {
        $request->validate([
            'author_name'  => 'required|string|max:100',
            'author_email' => 'required|email|max:255',
            'content'      => 'required|string|max:1000',
        ]);

        $post->comments()->create([
            'author_name'  => $request->input('author_name'),
            'author_email' => $request->input('author_email'),
            'content'      => $request->input('content'),
            'is_approved'  => false,
        ]);

        return back()->with('success', 'Comment submitted for approval!');
    }
}