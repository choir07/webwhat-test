<div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
        <div class="p-6">
            <div class="text-2xl font-bold text-blue-600">{{ $totalProducts }}</div>
            <div class="text-gray-600 dark:text-gray-400">Total Products</div>
        </div>
    </div>
    
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
        <div class="p-6">
            <div class="text-2xl font-bold text-green-600">{{ $totalPosts }}</div>
            <div class="text-gray-600 dark:text-gray-400">Total Posts</div>
        </div>
    </div>
    
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
        <div class="p-6">
            <div class="text-2xl font-bold text-purple-600">{{ $totalCategories }}</div>
            <div class="text-gray-600 dark:text-gray-400">Total Categories</div>
        </div>
    </div>
</div>