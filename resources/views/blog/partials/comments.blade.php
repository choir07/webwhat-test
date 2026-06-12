<!-- Comments Section -->
<div class="mt-12 bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6" x-data="{ showForm: true }">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
             Comments ({{ $post->comments->count() }})
        </h3>
        <button @click="showForm = !showForm" class="text-blue-600 hover:text-blue-800">
            <span x-show="!showForm"> Write a comment</span>
            <span x-show="showForm">âˆ’ Hide form</span>
        </button>
    </div>
    
    <!-- Display Comments -->
    <div class="space-y-6 mb-8 max-h-96 overflow-y-auto">
        @forelse($post->comments as $comment)
            <div class="border-b border-gray-100 pb-4 last:border-0">
                <div class="flex items-start space-x-3">
                    <img src="{{ $comment->avatar }}" alt="{{ $comment->author_name }}" class="w-10 h-10 rounded-full">
                    <div class="flex-1">
                        <div class="flex items-center space-x-2 mb-1">
                            <span class="font-semibold text-gray-800 dark:text-gray-100">{{ $comment->author_name }}</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300">{{ $comment->content }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                No comments yet. Be the first to comment!
            </div>
        @endforelse
    </div>
    
    <!-- Comment Form -->
    @if($post->allow_comments)
        <div x-show="showForm" x-transition>
            <form action="/blog/{{ $post->slug }}/comment" method="POST" class="mt-6 bg-gray-50 dark:bg-gray-700/50 rounded-lg p-6">
                @csrf
                <h4 class="font-bold text-lg mb-4 text-gray-800 dark:text-gray-100">âœï¸ Leave a Comment</h4>
                
                @if(session('success'))
                    <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg mb-4">
                        {{ session('success') }}
                    </div>
                @endif
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Your Name *</label>
                        <input type="text" name="author_name" required 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Your Email *</label>
                        <input type="email" name="author_email" required 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Your email won't be published</p>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Comment *</label>
                    <textarea name="content" rows="4" required 
                              class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                              placeholder="Share your thoughts..."></textarea>
                </div>
                
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition transform hover:scale-105">
                     Post Comment
                </button>
            </form>
        </div>
    @endif
</div>
