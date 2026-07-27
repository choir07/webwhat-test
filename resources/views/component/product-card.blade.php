
    Usage:
        <x-product-card
            :href="route('shop.show', $product)"
            :name="$product->name"
            :category="$product->category->name"
            :price="$product->price"
            :image="$product->image_url"
            tile-color="sky"
            :add-to-cart-action="route('cart.add', $product)"
        >
            <path d="M4 4h16v16H4z" />
        </x-product-card>

@props([
    'href' => '#',
    'name' => '',
    'category' => null,
    'price' => 0,
    'image' => null,
    'tileColor' => 'sky',
    'addToCartAction' => null,
])

<div class="bg-ink-50 rounded-card overflow-hidden">
    <a href="{{ $href }}" class="block">
        <x-media-tile :image="$image" :color="$tileColor" height="h-24">
            {{ $slot }}
        </x-media-tile>
    </a>
    <div class="p-3.5">
        <a href="{{ $href }}">
            <p class="font-medium text-sm text-ink-900">{{ $name }}</p>
        </a>
        @if ($category)
            <p class="text-xs text-ink-500 mt-0.5 mb-2">{{ $category }}</p>
        @endif
        <div class="flex items-center justify-between">
            <span class="text-sm font-medium text-ink-900">
                {{ '$' . number_format($price, 2) }}
            </span>
            @if ($addToCartAction)
                <form action="{{ $addToCartAction }}" method="POST">
                    @csrf
                    <button type="submit" aria-label="Add {{ $name }} to cart" class="text-accent-600 hover:text-accent-800">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1" /><circle cx="20" cy="21" r="1" />
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                        </svg>
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
