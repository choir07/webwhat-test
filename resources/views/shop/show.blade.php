@extends('layouts.shop')

@section('title', $product->name)

@section('content')
<div>
    <a href="{{ route('shop.index') }}" style="color:#60a5fa;text-decoration:none;display:inline-block;margin-bottom:1rem;">
        ← Back to Products
    </a>

    <div style="display:grid;grid-template-columns:1fr;gap:2rem;">
        @if(isset($product->image_url))
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                 style="width:100%;max-height:400px;object-fit:cover;border-radius:0.75rem;box-shadow:0 1px 3px rgba(0,0,0,0.3);">
        @endif

        <div>
            <h1 style="font-size:2rem;font-weight:700;color:#f9fafb;">{{ $product->name }}</h1>
            @if($product->category)
                <p style="color:#9ca3af;font-size:0.875rem;">{{ $product->category->name }}</p>
            @endif

            <div style="margin:1rem 0;">
                @if($product->sale_price)
                    <span style="font-size:2rem;font-weight:700;color:#f87171;">
                        RM{{ number_format($product->sale_price, 2) }}
                    </span>
                    <span style="font-size:1rem;color:#6b7280;text-decoration:line-through;margin-left:0.5rem;">
                        RM{{ number_format($product->price, 2) }}
                    </span>
                @else
                    <span style="font-size:2rem;font-weight:700;color:#f9fafb;">
                        RM{{ number_format($product->price, 2) }}
                    </span>
                @endif
            </div>

            <p style="color:#9ca3af;font-size:0.875rem;">
                Stock: 
                <span style="font-weight:600;{{ $product->stock > 0 ? 'color:#4ade80;' : 'color:#f87171;' }}">
                    {{ $product->stock > 0 ? $product->stock . ' available' : 'Out of stock' }}
                </span>
            </p>

            @if($product->description)
                <div style="margin:1.5rem 0;color:#d1d5db;line-height:1.8;">
                    {!! $product->description !!}
                </div>
            @endif

            @if($product->stock > 0)
                <form action="{{ route('cart.add') }}" method="POST" style="display:flex;align-items:center;gap:1rem;margin-top:1rem;">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                           style="width:80px;border:1px solid #4b5563;border-radius:0.375rem;padding:0.5rem;background:#1f2937;color:#f9fafb;">
                    <button type="submit" style="background:#2563eb;color:white;padding:0.625rem 1.5rem;border-radius:0.375rem;border:none;font-weight:500;cursor:pointer;transition:background 0.2s;">
                        Add to Cart
                    </button>
                </form>
            @else
                <div style="background:#7f1d1d;color:#fecaca;padding:0.5rem 1rem;border-radius:0.375rem;display:inline-block;margin-top:1rem;">
                    Out of Stock
                </div>
            @endif
        </div>
    </div>

    @if(isset($related) && $related->isNotEmpty())
        <div style="margin-top:3rem;">
            <h2 style="font-size:1.5rem;font-weight:700;color:#f9fafb;margin-bottom:1rem;">Related Products</h2>
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:1rem;">
                @foreach($related as $relatedProduct)
                    <div style="background:#1f2937;border-radius:0.5rem;overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,0.3);">
                        <a href="{{ route('shop.show', $relatedProduct->slug) }}">
                            <img src="{{ $relatedProduct->image_url }}" alt="{{ $relatedProduct->name }}" 
                                 style="width:100%;height:150px;object-fit:cover;">
                        </a>
                        <div style="padding:0.75rem;">
                            <a href="{{ route('shop.show', $relatedProduct->slug) }}" 
                               style="font-weight:600;color:#f9fafb;text-decoration:none;">
                                {{ $relatedProduct->name }}
                            </a>
                            <div style="font-weight:700;color:#f9fafb;margin-top:0.25rem;">
                                RM{{ number_format($relatedProduct->price, 2) }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection