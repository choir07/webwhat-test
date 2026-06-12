<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Posts - The Powerful Posts</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900">
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

    <main class="max-w-7xl mx-auto px-4 py-8">
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
    </main>
</body>
</html>

