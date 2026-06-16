@extends('layouts.app')

@section('title', 'All Posts - The Powerful Posts')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">All Posts</h1>

        @if($posts->count())
            <div class="space-y-6">
                @foreach($posts as $post)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                        <h2 class="text-2xl font-bold tracking-tight mb-2">
                            <a href="/blog/{{ $post->slug }}" class="hover:text-blue-600">{{ $post->title }}</a>
                        </h2>
                        <p class="description-text dark:text-gray-300">{{ Str::limit(strip_tags($post->content), 150) }}</p>
                        <div class="mt-3 text-sm text-gray-500 dark:text-gray-400">
                            {{ $post->published_at ? $post->published_at->format('M d, Y') : 'Draft' }}
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $posts->links() }}
            </div>
        @else
            <p class="text-gray-500 dark:text-gray-400">No posts found.</p>
        @endif
    </div>
@endsection