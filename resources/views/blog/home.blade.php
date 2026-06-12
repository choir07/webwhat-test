<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Blog - Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900">
    <!-- Navigation -->
    <nav class="bg-white dark:bg-gray-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a href="/" class="text-xl font-bold text-gray-800 dark:text-gray-100">My Blog</a>
                <div class="space-x-4">
                    <a href="/blog" class="text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:text-gray-100">All Posts</a>
                    <a href="/admin" class="text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:text-gray-100">Admin</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white">
        <div class="max-w-7xl mx-auto px-4 py-16 text-center">
            <h1 class="text-5xl font-extrabold tracking-tight mb-4">Welcome to The Powerful Posts</h1>
            <p class="text-xl font-light tracking-wide">Sharing  great, powerful and bizzare thoughts, ideas, and stories around us!</p>
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-4 py-8">
        <!-- Search Bar -->
        <div class="mb-8">
            <form action="/blog/search" method="GET" class="max-w-md mx-auto">
                <input type="search" 
                       name="q" 
                       placeholder="Search posts..." 
                       class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-blue-500">
            </form>
        </div>

        <!-- Featured Posts -->
        @if(isset($featuredPosts) && $featuredPosts->count())
        <div class="mb-12">
            <h2 class="text-2xl font-semibold tracking-tight mb-6">Featured Posts</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($featuredPosts as $post)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                    @if($post->featured_image_url)
                        <img src="{{ $post->featured_image_url }}" class="w-full h-48 object-cover">
                    @endif
                    <div class="p-4">
                        <h3 class="font-bold text-lg mb-2">
                            <a href="/blog/{{ $post->slug }}" class="hover:text-blue-600">{{ $post->title }}</a>
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300 text-sm">{{ Str::limit(strip_tags($post->content ?? $post->description), 100) }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Recent Posts -->
        <div>
            <h2 class="text-2xl font-semibold tracking-tight font-bold mb-6">ðŸ“ Recent Posts</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($recentPosts ?? [] as $post)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden hover:shadow-lg transition">
                    @if($post->featured_image_url)
                        <img src="{{ $post->featured_image_url }}" class="w-full h-48 object-cover">
                    @endif
                    <div class="p-4">
                        <div class="text-xs text-blue-600 mb-1">{{ $post->category->name ?? 'Uncategorized' }}</div>
                        <h3 class="font-semibold text-lg mb-2">
                            <a href="/blog/{{ $post->slug }}" class="hover:text-blue-600">{{ $post->title }}</a>
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300 text-sm mb-3">{{ Str::limit(strip_tags($post->content ?? $post->description), 100) }}</p>
                        <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400">
                            <span>{{ $post->published_at ? $post->published_at->format('M d, Y') : 'Draft' }}</span>
                            <span>ðŸ‘ï¸ {{ $post->views ?? 0 }}</span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12 bg-white dark:bg-gray-800 rounded-lg">
                    <p class="text-gray-500 dark:text-gray-400">No posts yet. Check back soon!</p>
                    <a href="/admin/posts/create" class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Create First Post
                    </a>
                </div>
                @endforelse
            </div>
        </div>
    </main>

    <footer class="bg-white dark:bg-gray-800 mt-12 py-6 border-t">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-500 dark:text-gray-400">
            &copy; {{ date('Y') }} . All rights reserved.
        </div>
    </footer>
</body>
</html>
'@




