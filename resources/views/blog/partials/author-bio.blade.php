@if($post->author)
<div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 my-8">
    <div class="flex items-start space-x-4">
        @php
            $avatarUrl = $post->author->email ? 
                'https://www.gravatar.com/avatar/' . md5($post->author->email) . '?s=80' : 
                'https://ui-avatars.com/api/?name=' . urlencode($post->author->name) . '&background=4f46e5&color=fff';
        @endphp
        
        <img src="{{ $avatarUrl }}" alt="{{ $post->author->name }}" 
             class="w-16 h-16 rounded-full">
        
        <div class="flex-1">
            <h3 class="font-bold text-lg">{{ $post->author->name }}</h3>
            <p class="text-gray-600 dark:text-gray-300 text-sm mt-1">
                Passionate writer sharing insights about technology, development, and life.
            </p>
            <div class="flex space-x-3 mt-3">
                <a href="#" class="text-blue-600 hover:text-blue-800 text-sm">Twitter</a>
                <a href="#" class="text-blue-600 hover:text-blue-800 text-sm">GitHub</a>
                <a href="/blog?author={{ $post->author->id }}" class="text-blue-600 hover:text-blue-800 text-sm">
                    View all posts
                </a>
            </div>
        </div>
    </div>
</div>
@endif