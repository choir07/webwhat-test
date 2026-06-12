@extends('layouts.app')

@section('title', 'Home - My Blog')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl text-white p-8 mb-12">
        <h1 class="text-4xl font-bold mb-4">Welcome to My Blog</h1>
        <p class="text-xl">Sharing thoughts, ideas, and stories</p>
    </div>

    <!-- Featured Posts -->
    @if(isset($featuredPosts) && $featuredPosts->count())
    <div class="mb-12">
        <h2 class="text-2xl font-bold mb-6">Featured Posts</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($featuredPosts as $post)
            <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition">
                @if($post->featured_image_url)
                <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                @endif
                <div class="p-4">
                    <h3 class="text-lg font-semibold mb-2">
                        <a href="/blog/{{ $post->slug }}" class="hover:text-blue-600">{{ $post->title }}</a>
                    </h3>
                    <p class="text-gray-600 text-sm">{{ Str::limit(strip_tags($post->content), 100) }}</p>
                    <div class="mt-3 text-sm text-gray-500">
                        {{ $post->published_at ? $post->published_at->format('M d, Y') : 'Draft' }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Recent Posts -->
    <div>
        <h2 class="text-2xl font-bold mb-6">Recent Posts</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($recentPosts as $post)
            <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition">
                @if($post->featured_image_url)
                <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                @endif
                <div class="p-4">
                    <div class="text-sm text-blue-600 mb-1">{{ $post->category->name ?? 'Uncategorized' }}</div>
                    <h3 class="text-lg font-semibold mb-2">
                        <a href="/blog/{{ $post->slug }}" class="hover:text-blue-600">{{ $post->title }}</a>
                    </h3>
                    <p class="text-gray-600 text-sm">{{ Str::limit(strip_tags($post->content), 100) }}</p>
                    <div class="mt-3 flex justify-between text-sm text-gray-500">
                        <span>{{ $post->published_at ? $post->published_at->diffForHumans() : 'Draft' }}</span>
                        <span>👁️ {{ $post->views ?? 0 }} views</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection