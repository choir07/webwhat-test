@extends('layouts.shop')

@section('title', 'Products')

@section('content')
<div class="shop-container py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="shop-title">All Products</h1>

        <form action="{{ route('shop.index') }}" method="GET" class="flex items-center">
            <input type="text" name="search" placeholder="Search products..."
                value="{{ request('search') }}" class="search-input">
            <button type="submit" class="search-btn">Search</button>
        </form>
    </div>

    <!-- Category Filter -->
    <div class="mb-8 flex flex-wrap gap-2">
        <a href="{{ route('shop.index') }}" 
           class="category-pill {{ !request('category') ? 'active' : 'inactive' }}">
            All
        </a>
        @foreach($categories as $category)
            <a href="{{ route('shop.index', ['category' => $category->id]) }}" 
               class="category-pill {{ request('category') == $category->id ? 'active' : 'inactive' }}">
                {{ $category->name }}
            </a>
        @endforeach
    </div>

    @if($products->isEmpty())
        <div class="no-products">No products found.</div>
    @else
        <div class="shop-grid">
            @foreach($products as $product)
                <div class="product-card">
                    <a href="{{ route('shop.show', $product->slug) }}">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="product-image">
                    </a>
                    <div class="product-body">
                        <a href="{{ route('shop.show', $product->slug) }}" class="product-name">
                            {{ $product->name }}
                        </a>
                        @if($product->category)
                            <p class="product-category">{{ $product->category->name }}</p>
                        @endif
                        <div class="mt-2 flex items-center justify-between">
                            <div>
                                @if($product->sale_price)
                                    <span class="product-price sale">${{ number_format($product->sale_price, 2) }}</span>
                                    <span class="text-sm text-gray-400 line-through ml-2">${{ number_format($product->price, 2) }}</span>
                                @else
                                    <span class="product-price">${{ number_format($product->price, 2) }}</span>
                                @endif
                            </div>
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="btn-add-cart">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="pagination">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection