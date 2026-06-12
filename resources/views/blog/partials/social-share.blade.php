<div class="flex space-x-4 my-4">
    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
       target="_blank" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Facebook
    </a>
    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}" 
       target="_blank" class="bg-black text-white px-4 py-2 rounded hover:bg-gray-800">
        Twitter
    </a>
    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->url()) }}" 
       target="_blank" class="bg-blue-800 text-white px-4 py-2 rounded hover:bg-blue-900">
        LinkedIn
    </a>
</div>