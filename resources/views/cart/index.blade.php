@extends('layouts.shop')

@section('title', 'Shopping Cart')

@section('content')
<div>
    <h1 class="shop-title">Shopping Cart</h1>
    
    @if(session('success'))
        <div style="background:#d1fae5;color:#065f46;padding:0.75rem 1rem;border-radius:0.5rem;margin-bottom:1rem;">
            {{ session('success') }}
        </div>
    @endif

    @if(empty($items))
        <div class="no-products">
            <p style="font-size:1.125rem;">Your cart is empty.</p>
            <a href="{{ route('shop.index') }}" style="display:inline-block;margin-top:1rem;background:#2563eb;color:white;padding:0.625rem 1.5rem;border-radius:0.375rem;text-decoration:none;font-weight:500;">
                Continue Shopping
            </a>
        </div>
    @else
        <div style="background:white;border-radius:0.75rem;overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,0.1);">
            <table style="width:100%;border-collapse:collapse;">
                <thead style="background:#f9fafb;border-bottom:1px solid #e5e7eb;">
                    <tr>
                        <th style="padding:0.75rem 1rem;text-align:left;font-size:0.75rem;font-weight:600;text-transform:uppercase;color:#6b7280;">Product</th>
                        <th style="padding:0.75rem 1rem;text-align:left;font-size:0.75rem;font-weight:600;text-transform:uppercase;color:#6b7280;">Price</th>
                        <th style="padding:0.75rem 1rem;text-align:left;font-size:0.75rem;font-weight:600;text-transform:uppercase;color:#6b7280;">Quantity</th>
                        <th style="padding:0.75rem 1rem;text-align:left;font-size:0.75rem;font-weight:600;text-transform:uppercase;color:#6b7280;">Total</th>
                        <th style="padding:0.75rem 1rem;text-align:left;font-size:0.75rem;font-weight:600;text-transform:uppercase;color:#6b7280;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $productId => $item)
                    <tr style="border-bottom:1px solid #f3f4f6;">
                        <td style="padding:1rem;display:flex;align-items:center;gap:1rem;">
                            @if(isset($item['image']) && $item['image'])
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" 
                                     style="width:64px;height:64px;object-fit:cover;border-radius:0.375rem;">
                            @else
                                <div style="width:64px;height:64px;background:#e5e7eb;border-radius:0.375rem;display:flex;align-items:center;justify-content:center;color:#9ca3af;font-size:0.75rem;">
                                    No Image
                                </div>
                            @endif
                            <span style="font-weight:500;color:#111827;">{{ $item['name'] }}</span>
                        </td>
                        <td style="padding:1rem;color:#374151;">RM{{ number_format($item['price'], 2) }}</td>
                        <td style="padding:1rem;">
                            <form action="{{ route('cart.update', $productId) }}" method="POST" style="display:flex;align-items:center;gap:0.5rem;">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" 
                                       style="width:64px;border:1px solid #d1d5db;border-radius:0.375rem;padding:0.375rem 0.5rem;font-size:0.875rem;">
                                <button type="submit" style="color:#2563eb;background:none;border:none;cursor:pointer;font-size:0.875rem;">
                                    Update
                                </button>
                            </form>
                        </td>
                        <td style="padding:1rem;font-weight:600;color:#111827;">
                            RM{{ number_format($item['price'] * $item['quantity'], 2) }}
                        </td>
                        <td style="padding:1rem;">
                            <form action="{{ route('cart.remove', $productId) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="color:#dc2626;background:none;border:none;cursor:pointer;font-size:0.875rem;">
                                    Remove
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot style="background:#f9fafb;">
                    <tr>
                        <td colspan="3" style="padding:1rem;text-align:right;font-weight:600;font-size:1.125rem;color:#111827;">
                            Total:
                        </td>
                        <td style="padding:1rem;font-weight:700;font-size:1.125rem;color:#111827;">
                            RM{{ number_format($total, 2) }}
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <div style="display:flex;justify-content:space-between;margin-top:1.5rem;flex-wrap:wrap;gap:1rem;">
            <a href="{{ route('shop.index') }}" style="background:#6b7280;color:white;padding:0.625rem 1.5rem;border-radius:0.375rem;text-decoration:none;font-weight:500;transition:background 0.2s;">
                Continue Shopping
            </a>
            <div style="display:flex;gap:0.75rem;">
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background:#dc2626;color:white;padding:0.625rem 1.5rem;border-radius:0.375rem;border:none;font-weight:500;cursor:pointer;transition:background 0.2s;">
                        Clear Cart
                    </button>
                </form>
                <a href="{{ route('checkout.index') }}" style="background:#16a34a;color:white;padding:0.625rem 1.5rem;border-radius:0.375rem;text-decoration:none;font-weight:500;transition:background 0.2s;">
                    Proceed to Checkout
                </a>
            </div>
        </div>
    @endif
</div>
@endsection