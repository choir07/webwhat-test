@extends('layouts.app')

@section('title', 'The Powerful Posts')

@section('content')

    <!-- Hero Section -->
    <div class="bg-ink-50 dark:bg-ink-950 bg-cover bg-center"
        style="background-image: linear-gradient(rgba(15,23,42,0.75), rgba(15,23,42,0.75)), url('https://res.cloudinary.com/dgk1pwiet/image/upload/q_auto,f_auto,w_1600/v1785723579/3293677_aezjjh.jpg'); background-size: cover; background-position: center;">
        <div class="max-w-7xl mx-auto px-4 py-16 grid grid-cols-1 md:grid-cols-[1.4fr_1fr] gap-8 items-center">
            <div>
                <span class="inline-block bg-tile-sand text-tile-sand-fg text-xs px-3.5 py-1.5 rounded-full mb-4">
                    Web app
                </span>
                <h1
                    class="font-display font-semibold text-4xl md:text-5xl leading-tight text-ink-50 mb-4">
                    <span id="typing-text" class="border-r-2 border-ink-50 pr-1"></span>
                </h1>
                <p class="text-ink-300 text-base mb-8 max-w-lg">
                    Long-form writing on things worth reading twice. 
                </p>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="/blog"
                        class="bg-ink-50 text-ink-900 px-7 py-3 rounded-full font-medium text-sm hover:bg-ink-100 transition">
                        Explore Posts
                    </a>
                </div>
            </div>
            <div class="bg-ink-900/60 border border-ink-700 rounded-card p-6">
                <svg class="w-6 h-6 text-accent-400 mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 21c3-4 4-8 4-12a4 4 0 0 1 8 0c0 4-1 8 4 12" />
                    <path d="M14 9a4 4 0 0 1 4-4" />
                </svg>
                <p class="font-display italic text-lg leading-snug text-ink-50">
                    The correct narrative and efficient media can control the world.
                </p>
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
                        <div class="blog-card border rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                            @if($post->featured_image_url)
                                <img src="{{ $post->featured_image }}" class="w-full h-48 object-cover">
                            @endif
                            <div class="p-4">
                                <h3 class="font-bold text-lg mb-2">
                                    <a href="/blog/{{ $post->slug }}">{{ $post->title }}</a>
                                </h3>
                                <p class="description-text text-sm">
                                    {{ Str::limit(strip_tags($post->content ?? $post->description), 100) }}
                                </p>
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
                    <div class="blog-card border rounded-lg shadow overflow-hidden hover:shadow-lg transition">
                        @if($post->featured_image_url)
                            <img src="{{ $post->featured_image }}" class="w-full h-48 object-cover">
                        @endif
                        <div class="p-4">
                            <div class="text-xs mb-1" style="color: var(--link-color);">{{ $post->category->name ?? 'Uncategorized' }}</div>
                            <h3 class="font-semibold text-lg mb-2">
                                <a href="/blog/{{ $post->slug }}">{{ $post->title }}</a>
                            </h3>
                            <p class="description-text text-sm mb-3">
                                {{ Str::limit(strip_tags($post->content ?? $post->description), 100) }}
                            </p>
                            <div class="flex justify-between text-xs post-meta">
                                <span>{{ $post->published_at ? $post->published_at->format('M d, Y') : 'Draft' }}</span>
                                <span> {{ $post->views ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 blog-card border rounded-lg">
                        <p class="post-meta">No posts yet. Check back soon!</p>
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