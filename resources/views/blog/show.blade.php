<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }} - My Blog</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/dark-mode.css') }}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        function toggleTheme() {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        }
        
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="bg-gray-100 dark:bg-gray-900">
    <nav class="bg-white dark:bg-gray-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a href="/" class="text-xl font-bold text-gray-800 dark:text-white">The Powerful Posts</a>
                <div class="space-x-4">
                    <a href="/blog" class="text-gray-600 dark:text-gray-300 hover:text-gray-800">All Posts</a>
                    <a href="/admin" class="text-gray-600 dark:text-gray-300 hover:text-gray-800">Admin</a>
                    <button onclick="toggleTheme()" class="text-gray-600 dark:text-gray-300">
                        <span class="dark:hidden">🌙 Dark</span>
                        <span class="hidden dark:inline">☀️ Light</span>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-4 py-8">
        <article class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <!-- Featured Image with proper detection -->
            @php
                $imageUrl = null;
                if ($post->featured_image) {
                    $imageUrl = asset('storage/' . $post->featured_image);
                } elseif ($post->featured_image_id) {
                    $file = App\Models\File::find($post->featured_image_id);
                    if ($file) {
                        $imageUrl = $file->url;
                    }
                }
            @endphp
            
            @if($imageUrl)
                <img src="{{ $imageUrl }}" alt="{{ $post->title }}" class="w-full h-96 object-cover">
            @else
                <div class="w-full h-96 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                    <span class="text-gray-400">No image</span>
                </div>
            @endif
            
            <div class="p-8">
                @if($post->category)
                    <div class="text-sm text-blue-600 mb-2">{{ $post->category->name }}</div>
                @endif
                
                <h1 class="text-4xl font-extrabold tracking-tight mb-4 text-gray-800 dark:text-white">{{ $post->title }}</h1>
                
                <div class="post-meta flex flex-wrap gap-4 dark:text-gray-400 text-sm mb-6 pb-4 border-b dark:border-gray-700">
                    <div>📅 {{ $post->published_at ? $post->published_at->format('F j, Y') : 'Date not set' }}</div>
                    <div>👤 By {{ $post->author->name ?? 'Unknown' }}</div>
                    <div>📖 {{ $post->reading_time ?? '1 min read' }}</div>
                    <div>👁️ {{ $post->views ?? 0 }} views</div>
                </div>
                
                @if($post->excerpt)
                    <div class="text-lg text-gray-600 dark:text-gray-300 italic mb-6 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        {{ $post->excerpt }}
                    </div>
                @endif
                
                <div class="prose max-w-none dark:prose-invert">
                    @if($post->description)
                        <p class="description-text text-lg leading-relaxed">{{ $post->description }}</p>
                    @elseif($post->content)
                        {!! $post->content !!}
                    @else
                        <p class="text-gray-500 italic">No description available.</p>
                    @endif
                </div>
            </div>
        </article>

        @include('blog.partials.comments')

        @if(isset($relatedPosts) && $relatedPosts->count())
            <div class="mt-12">
                <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Related Posts</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedPosts as $related)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                            @php
                                $relatedImage = null;
                                if ($related->featured_image) {
                                    $relatedImage = asset('storage/' . $related->featured_image);
                                } elseif ($related->featured_image_id) {
                                    $file = App\Models\File::find($related->featured_image_id);
                                    if ($file) $relatedImage = $file->url;
                                }
                            @endphp
                            @if($relatedImage)
                                <img src="{{ $relatedImage }}" class="w-full h-40 object-cover">
                            @endif
                            <div class="p-4">
                                <h3 class="font-semibold">
                                    <a href="/blog/{{ $related->slug }}" class="hover:text-blue-600 dark:text-white">
                                        {{ $related->title }}
                                    </a>
                                </h3>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </main>
</body>
</html>

