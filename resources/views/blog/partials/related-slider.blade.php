@if($relatedPosts->count() > 0)
<div class="mt-12">
    <h2 class="text-2xl font-bold mb-6">📚 You Might Also Like</h2>
    
    <div class="relative">
        <div id="relatedSlider" class="flex overflow-x-auto scroll-smooth gap-6 pb-4 hide-scrollbar">
            @foreach($relatedPosts as $related)
            <div class="min-w-[280px] md:min-w-[320px] bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                @if($related->featured_image_url)
                    <img src="{{ $related->featured_image_url }}" class="w-full h-40 object-cover">
                @endif
                <div class="p-4">
                    <h3 class="font-semibold mb-2">
                        <a href="/blog/{{ $related->slug }}" class="hover:text-blue-600">
                            {{ Str::limit($related->title, 50) }}
                        </a>
                    </h3>
                    <p class="text-sm text-gray-500">{{ $related->created_at->diffForHumans() }}</p>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Navigation Buttons -->
        <button onclick="scrollSlider('prev')" 
                class="absolute left-0 top-1/2 -translate-y-1/2 -ml-4 bg-white dark:bg-gray-800 rounded-full p-2 shadow-lg">
            ◀
        </button>
        <button onclick="scrollSlider('next')" 
                class="absolute right-0 top-1/2 -translate-y-1/2 -mr-4 bg-white dark:bg-gray-800 rounded-full p-2 shadow-lg">
            ▶
        </button>
    </div>
</div>

<style>
.hide-scrollbar::-webkit-scrollbar {
    display: none;
}
.hide-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>

<script>
function scrollSlider(direction) {
    const slider = document.getElementById('relatedSlider');
    const scrollAmount = 350;
    
    if (direction === 'prev') {
        slider.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    } else {
        slider.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    }
}
</script>
@endif