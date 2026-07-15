@extends('layouts.shop')  {{-- Changed from layouts.app --}}

@section('title', $product->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-4">
        <a href="{{ route('shop.index') }}" class="text-blue-500 hover:text-blue-700">
            â† Back to Products
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Product Image -->
        <div>
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                 class="w-full rounded-lg shadow-md">
        </div>

        <!-- Product Details -->
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $product->name }}</h1>
            @if($product->category)
                <p class="text-sm text-gray-500 mt-1">{{ $product->category->name }}</p>
            @endif

            <div class="mt-4">
                @if($product->sale_price)
                    <span class="text-3xl font-bold text-red-600">${{ number_format($product->sale_price, 2) }}</span>
                    <span class="text-lg text-gray-400 line-through ml-2">${{ number_format($product->price, 2) }}</span>
                @else
                    <span class="text-3xl font-bold text-gray-800">${{ number_format($product->price, 2) }}</span>
                @endif
            </div>

            <div class="mt-4">
                <p class="text-sm text-gray-600">
                    Stock: <span class="font-semibold {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $product->stock > 0 ? $product->stock . ' available' : 'Out of stock' }}
                    </span>
                </p>
            </div>

            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-800">Description</h3>
                <div class="mt-2 prose max-w-none">
                    {!! $product->description !!}
                </div>
            </div>

            @if($product->stock > 0)
                <div class="mt-8">
                    <form action="{{ route('cart.add') }}" method="POST" class="flex items-center gap-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                               class="w-20 border border-gray-300 rounded px-3 py-2">
                        <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition">
                            Add to Cart
                        </button>
                    </form>
                </div>
            @else
                <div class="mt-8">
                    <span class="bg-red-100 text-red-700 px-4 py-2 rounded-lg">Out of Stock</span>
                </div>
            @endif
        </div>
    </div>

    <!-- Related Products -->
    @if($related->isNotEmpty())
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Related Products</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($related as $relatedProduct)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                        @if($relatedProduct->slug)<a href="{{ route('shop.show', $relatedProduct->slug) }}">
                            <img src="{{ $relatedProduct->image_url }}" alt="{{ $relatedProduct->name }}" 
                                 class="w-full h-40 object-cover">
                        </a>
                        <div class="p-4">
                            <a href="{{ route('shop.show', $relatedProduct->slug) }}" class="block">
                                <h3 class="text-lg font-semibold text-gray-800 hover:text-blue-600">
                                    {{ $relatedProduct->name }}
                                </h3>
                            </a>
                            <div class="mt-2">
                                <span class="text-lg font-bold text-gray-800">${{ number_format($relatedProduct->price, 2) }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection