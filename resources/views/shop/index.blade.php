@extends('layouts.shop')

@section('title', 'Products')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">All Products</h1>

            <form action="{{ route('shop.index') }}" method="GET" class="flex items-center">
                <input type="text" name="search" placeholder="Search products..."
                    value="{{ request('search') }}"
                    class="border border-gray-300 rounded-l px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-r hover:bg-blue-600">
                    Search
                </button>
            </form>
        </div>

        <!-- Category Filter -->
        <div class="mb-6 flex flex-wrap gap-2">
            <a href="{{ route('shop.index') }}"
                class="px-4 py-2 rounded-full {{ !request('category') ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                All
            </a>
            @foreach($categories as $category)
                <a href="{{ route('shop.index', ['category' => $category->id]) }}"
                    class="px-4 py-2 rounded-full {{ request('category') == $category->id ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        <!-- Products Grid -->
        @if($products->isEmpty())
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">No products found.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                        @if($product->slug)
                            <a href="{{ route('shop.show', $product->slug) }}">
                                <img src="{{ $product->image_url ?? 'https://placehold.co/400x300?text=No+Image' }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-48 object-cover">
                            </a>
                        @else
                            <img src="{{ $product->image_url ?? 'https://placehold.co/400x300?text=No+Image' }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-48 object-cover">
                        @endif

                        <div class="p-4">
                            @if($product->slug)
                                <a href="{{ route('shop.show', $product->slug) }}" class="block">
                                    <h3 class="text-lg font-semibold text-gray-800 hover:text-blue-600">
                                        {{ $product->name }}
                                    </h3>
                                </a>
                            @else
                                <h3 class="text-lg font-semibold text-gray-800">
                                    {{ $product->name }}
                                </h3>
                            @endif

                            @if($product->category)
                                <p class="text-sm text-gray-500">{{ $product->category->name }}</p>
                            @endif

                            <div class="mt-2 flex items-center justify-between">
                                <div>
                                    @if($product->sale_price)
                                        <span class="text-lg font-bold text-red-600">
                                            ${{ number_format($product->sale_price, 2) }}
                                        </span>
                                        <span class="text-sm text-gray-400 line-through ml-2">
                                            ${{ number_format($product->price, 2) }}
                                        </span>
                                    @else
                                        <span class="text-lg font-bold text-gray-800">
                                            ${{ number_format($product->price, 2) }}
                                        </span>
                                    @endif
                                </div>
                                <form action="{{ route('cart.add') }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit"
                                        class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-sm">
                                        Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>  {{-- closes product card --}}
                @endforeach
            </div>  {{-- closes grid --}}

            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @endif
    </div>
@endsection