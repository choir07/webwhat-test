@extends('layouts.shop')

@section('title', 'Products')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="font-display font-semibold text-2xl text-ink-900 dark:text-ink-50">All Products</h1>
            <form action="{{ route('shop.index') }}" method="GET" class="flex items-center">
                <input type="text" name="search" placeholder="Search products..."
                    value="{{ request('search') }}"
                    class="border border-ink-300 dark:border-ink-700 bg-transparent rounded-l px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent-400">
                <button type="submit"
                    class="bg-ink-900 dark:bg-ink-50 text-ink-50 dark:text-ink-900 px-4 py-2 rounded-r text-sm font-medium hover:bg-ink-700 dark:hover:bg-ink-100 transition">
                    Search
                </button>
            </form>
        </div>

        <!-- Category Filter -->
        <div class="mb-8 flex flex-wrap gap-2">
            <x-category-pill :href="route('shop.index')" :active="!request('category')">
                All
            </x-category-pill>
            @foreach($categories as $category)
                <x-category-pill
                    :href="route('shop.index', ['category' => $category->id])"
                    :active="request('category') == $category->id"
                >
                    {{ $category->name }}
                </x-category-pill>
            @endforeach
        </div>

        @if($products->isEmpty())
            <div class="text-center py-12">
                <p class="text-ink-500">No products found.</p>
            </div>
        @else
            {{-- Featured product — only on the default, unfiltered view --}}
            @if(!request('search') && !request('category') && $products->currentPage() === 1)
                @php $featured = $products->first(); @endphp
                <div class="grid grid-cols-1 md:grid-cols-[1.3fr_1fr] gap-4 mb-8">
                    <div class="bg-ink-50 rounded-card p-6 flex flex-col justify-between">
                        <div>
                            <span class="inline-block bg-tile-sand text-tile-sand-fg text-xs px-3 py-1.5 rounded-full mb-3">
                                Featured
                            </span>
                            <a href="{{ $featured->slug ? route('shop.show', $featured->slug) : '#' }}">
                                <p class="font-display font-medium text-xl text-ink-900 mb-1.5">{{ $featured->name }}</p>
                            </a>
                            @if($featured->category)
                                <p class="text-sm text-ink-500">{{ $featured->category->name }}</p>
                            @endif
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <span class="text-xl font-medium text-ink-900">
                                {{ '$' . number_format($featured->sale_price ?? $featured->price, 2) }}
                            </span>
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $featured->id }}">
                                <button type="submit"
                                    class="bg-ink-900 text-ink-50 px-5 py-2 rounded-full text-sm font-medium hover:bg-ink-700 transition">
                                    Add to cart
                                </button>
                            </form>
                        </div>
                    </div>
                    <x-media-tile :image="$featured->image_url" color="sky" height="h-full">
                        <path d="M4 4h16v16H4z" />
                    </x-media-tile>
                </div>
            @endif

            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @php $tileColors = ['coral', 'sage', 'sand', 'sky', 'plum']; @endphp
                @foreach($products as $product)
                    <x-product-card
                        :href="$product->slug ? route('shop.show', $product->slug) : '#'"
                        :name="$product->name"
                        :category="$product->category->name ?? null"
                        :price="$product->price"
                        :sale-price="$product->sale_price"
                        :image="$product->image_url"
                        :tile-color="$tileColors[$loop->index % count($tileColors)]"
                        :add-to-cart-action="route('cart.add')"
                        :product-id="$product->id"
                    >
                        <path d="M4 4h16v16H4z" />
                    </x-product-card>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @endif
    </div>
@endsection