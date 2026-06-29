@extends('layouts.app')

@section('title', 'The Powerful Posts')

@section('content')

    <!-- Hero Section with Typing Animation -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white">
        <div class="max-w-7xl mx-auto px-4 py-20 text-center">
            <h1 class="text-5xl md:text-6xl font-extrabold mb-4 tracking-tight">
                Welcome to <span class="text-yellow-300">The Powerful Posts</span>
            </h1>

            <!-- Typing Animation -->
            <div class="text-xl md:text-2xl font-light mb-8 h-12">
                <span id="typing-text" class="border-r-2 border-white pr-1"></span>
            </div>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/blog"
                    class="bg-white text-blue-600 px-8 py-3 rounded-full font-semibold hover:bg-gray-100 transition transform hover:scale-105">
                    Explore Posts
                </a>
                <a href="#newsletter"
                    class="border-2 border-white text-white px-8 py-3 rounded-full font-semibold hover:bg-white/10 transition">
                    Subscribe
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-8">

        <!-- Featured Posts -->
        @if(isset($featuredPosts) && $featuredPosts->count())
            <div class="mb-12">
                <h2 class="text-2xl font-semibold tracking-tight mb-6">Featured Posts</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($featuredPosts as $post)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                            @if($post->featured_image_url)
                                <img src="{{ $post->featured_image }}"  class="w-full h-48 object-cover">
                            @endif
                            <div class="p-4">
                                <h3 class="font-bold text-lg mb-2">
                                    <a href="/blog/{{ $post->slug }}" class="hover:text-blue-600">{{ $post->title }}</a>
                                </h3>
                                <p class="text-gray-600 dark:text-gray-300 text-sm">
                                    {{ Str::limit(strip_tags($post->content ?? $post->description), 100) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Recent Posts -->
        <div>
            <h2 class="text-2xl font-semibold tracking-tight font-bold mb-6"> Recent Posts</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($recentPosts ?? [] as $post)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden hover:shadow-lg transition">
                        @if($post->featured_image_url)
                            <img src="{{ $post->featured_image }}" class="w-full h-48 object-cover">
                        @endif
                        <div class="p-4">
                            <div class="text-xs text-blue-600 mb-1">{{ $post->category->name ?? 'Uncategorized' }}</div>
                            <h3 class="font-semibold text-lg mb-2">
                                <a href="/blog/{{ $post->slug }}" class="hover:text-blue-600">{{ $post->title }}</a>
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm mb-3">
                                {{ Str::limit(strip_tags($post->content ?? $post->description), 100) }}</p>
                            <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400">
                                <span>{{ $post->published_at ? $post->published_at->format('M d, Y') : 'Draft' }}</span>
                                <span> {{ $post->views ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 bg-white dark:bg-gray-800 rounded-lg">
                        <p class="text-gray-500 dark:text-gray-400">No posts yet. Check back soon!</p>
                        <a href="/admin/posts/create"
                            class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            Create First Post
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    <!-- Typing Animation Script -->
    <script>
        const phrases = [
            "Sharing powerful insights ",
            "Your daily dose of inspiration ",
            "Stories that matter ",
            "Learn, grow, succeed "
        ];

        let i = 0;
        let j = 0;
        let currentPhrase = [];
        let isDeleting = false;

        function typeEffect() {
            const textElement = document.getElementById('typing-text');

            if (isDeleting) {
                currentPhrase.pop();
                textElement.innerHTML = currentPhrase.join('');
                if (currentPhrase.length === 0) {
                    isDeleting = false;
                    i++;
                    if (i >= phrases.length) i = 0;
                }
                setTimeout(typeEffect, 80);
            } else {
                if (j < phrases[i].length) {
                    currentPhrase.push(phrases[i][j]);
                    textElement.innerHTML = currentPhrase.join('');
                    j++;
                    setTimeout(typeEffect, 100);
                } else {
                    setTimeout(() => {
                        isDeleting = true;
                        setTimeout(typeEffect, 2000);
                    }, 3000);
                }
            }
        }

        typeEffect();
    </script>

@endsection