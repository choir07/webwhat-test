<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Results - My Blog</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <a href="/" class="text-xl font-bold">My Blog</a>
            <a href="/blog" class="ml-4 text-gray-600">Back to Blog</a>
        </div>
    </nav>
    <main class="max-w-4xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Search Results for "{{ $query }}"</h1>
        @if($posts->count())
            @foreach($posts as $post)
            <div class="bg-white rounded-lg shadow p-4 mb-4">
                <h2><a href="/blog/{{ $post->slug }}" class="text-blue-600 hover:underline">{{ $post->title }}</a></h2>
                <p>{{ Str::limit($post->description ?? $post->content, 150) }}</p>
            </div>
            @endforeach
            {{ $posts->links() }}
        @else
            <p>No posts found.</p>
        @endif
    </main>
</body>
</html>
