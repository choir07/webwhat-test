{{--
    Usage:
        <x-post-card
            :href="route('posts.show', $post)"
            :title="$post->title"
            :category="$post->category->name"
            :image="$post->image_url"
            tile-color="sage"
        >
            <path d="M4 4h16v16H4z" />   {{-- fallback icon, only used if no image --}}
        </x-post-card>
--}}
@props([
    'href' => '#',
    'title' => '',
    'category' => null,
    'image' => null,
    'tileColor' => 'sand',
])

<a href="{{ $href }}" class="block bg-ink-50 rounded-card overflow-hidden hover:bg-ink-100 transition-colors">
    <x-media-tile :image="$image" :color="$tileColor" height="h-24">
        {{ $slot }}
    </x-media-tile>
    <div class="p-3.5">
        @if ($category)
            <span class="text-xs text-ink-500">{{ $category }}</span>
        @endif
        <p class="font-medium text-sm mt-1 text-ink-900">{{ $title }}</p>
    </div>
</a>
