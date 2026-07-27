{{--
    Usage:
        <x-cart-row
            :name="$item->product->name"
            :price="$item->product->price"
            :quantity="$item->quantity"
            :image="$item->product->image_url"
            :update-action="route('cart.update', $item)"
            :remove-action="route('cart.remove', $item)"
            tile-color="plum"
        >
            <path d="M4 4h16v16H4z" />
        </x-cart-row>
--}}
@props([
    'name' => '',
    'price' => 0,
    'quantity' => 1,
    'image' => null,
    'tileColor' => 'plum',
    'updateAction' => null,
    'removeAction' => null,
])

<div class="flex items-center gap-3.5 py-3.5 border-b border-ink-100">
    <div class="w-13 h-13 rounded flex-shrink-0" style="width:52px;height:52px">
        <x-media-tile :image="$image" :color="$tileColor" height="h-full" rounded="rounded">
            {{ $slot }}
        </x-media-tile>
    </div>

    <div class="flex-1 min-w-0">
        <p class="font-medium text-sm text-ink-900 truncate">{{ $name }}</p>
        <p class="text-xs text-ink-500">{{ '$' . number_format($price, 2) }} each</p>
    </div>

    @if ($updateAction)
        <form action="{{ $updateAction }}" method="POST" class="flex items-center border border-ink-300 rounded">
            @csrf
            @method('PATCH')
            <button type="submit" name="quantity" value="{{ max(1, $quantity - 1) }}" class="w-7 text-sm" aria-label="Decrease quantity">−</button>
            <span class="w-7 text-center text-sm">{{ $quantity }}</span>
            <button type="submit" name="quantity" value="{{ $quantity + 1 }}" class="w-7 text-sm" aria-label="Increase quantity">+</button>
        </form>
    @endif

    <span class="font-medium text-sm text-ink-900 w-16 text-right">
        {{ '$' . number_format($price * $quantity, 2) }}
    </span>

    @if ($removeAction)
        <form action="{{ $removeAction }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" aria-label="Remove {{ $name }} from cart" class="text-red-600 hover:text-red-800">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6h14z" />
                </svg>
            </button>
        </form>
    @endif
</div>
