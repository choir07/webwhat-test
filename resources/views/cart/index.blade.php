@extends('layouts.shop')

@section('title', 'Shopping Cart')

@section('content')
<div>
    <h1 class="shop-title">Shopping Cart</h1>
    
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(empty($items))
        <div class="no-products">
            <p style="font-size:1.125rem;">Your cart is empty.</p>
            <a href="{{ route('shop.index') }}" style="display:inline-block;margin-top:1rem;background:var(--btn-primary-bg);color:white;padding:0.625rem 1.5rem;border-radius:0.375rem;text-decoration:none;font-weight:500;">
                Continue Shopping
            </a>
        </div>
    @else
        <div style="background:var(--bg-card);border-radius:0.75rem;overflow:hidden;box-shadow:0 1px 3px var(--shadow-color);">
            <table style="width:100%;border-collapse:collapse;">
                <thead style="background:var(--bg-table-header);border-bottom:1px solid var(--border-color);">
                    <tr>
                        <th style="padding:0.75rem 1rem;text-align:left;font-size:0.75rem;font-weight:600;text-transform:uppercase;color:var(--text-muted);">Product</th>
                        <th style="padding:0.75rem 1rem;text-align:left;font-size:0.75rem;font-weight:600;text-transform:uppercase;color:var(--text-muted);">Price</th>
                        <th style="padding:0.75rem 1rem;text-align:left;font-size:0.75rem;font-weight:600;text-transform:uppercase;color:var(--text-muted);">Quantity</th>
                        <th style="padding:0.75rem 1rem;text-align:left;font-size:0.75rem;font-weight:600;text-transform:uppercase;color:var(--text-muted);">Total</th>
                        <th style="padding:0.75rem 1rem;text-align:left;font-size:0.75rem;font-weight:600;text-transform:uppercase;color:var(--text-muted);">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $productId => $item)
                    <tr style="border-bottom:1px solid var(--border-light);">
                        <td style="padding:1rem;display:flex;align-items:center;gap:1rem;">
                            @if(isset($item['image']) && $item['image'])
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" 
                                     style="width:64px;height:64px;object-fit:cover;border-radius:0.375rem;">
                            @else
                                <div style="width:64px;height:64px;background:var(--bg-hover);border-radius:0.375rem;display:flex;align-items:center;justify-content:center;color:var(--text-light);font-size:0.75rem;">
                                    No Image
                                </div>
                            @endif
                            <span style="font-weight:500;color:var(--text-primary);">{{ $item['name'] }}</span>
                        </td>
                        <td style="padding:1rem;color:var(--text-secondary);">RM{{ number_format($item['price'], 2) }}</td>
                        <td style="padding:1rem;">
                            <form action="{{ route('cart.update', $productId) }}" method="POST" style="display:flex;align-items:center;gap:0.5rem;">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" 
                                       style="width:64px;border:1px solid var(--border-color);border-radius:0.375rem;padding:0.375rem 0.5rem;font-size:0.875rem;background:var(--bg-input);color:var(--text-primary);">
                                <button type="submit" style="color:var(--btn-primary-bg);background:none;border:none;cursor:pointer;font-size:0.875rem;">
                                    Update
                                </button>
                            </form>
                        </td>
                        <td style="padding:1rem;font-weight:600;color:var(--text-primary);">
                            RM{{ number_format($item['price'] * $item['quantity'], 2) }}
                        </td>
                        <td style="padding:1rem;">
                            <form action="{{ route('cart.remove', $productId) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="color:var(--btn-danger-bg);background:none;border:none;cursor:pointer;font-size:0.875rem;">
                                    Remove
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot style="background:var(--bg-table-header);">
                    <tr>
                        <td colspan="3" style="padding:1rem;text-align:right;font-weight:600;font-size:1.125rem;color:var(--text-primary);">
                            Total:
                        </td>
                        <td style="padding:1rem;font-weight:700;font-size:1.125rem;color:var(--text-primary);">
                            RM{{ number_format($total, 2) }}
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <div style="display:flex;justify-content:space-between;margin-top:1.5rem;flex-wrap:wrap;gap:1rem;">
            <a href="{{ route('shop.index') }}" style="background:var(--btn-gray-bg);color:white;padding:0.625rem 1.5rem;border-radius:0.375rem;text-decoration:none;font-weight:500;transition:background 0.2s;">
                Continue Shopping
            </a>
            <div style="display:flex;gap:0.75rem;">
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background:var(--btn-danger-bg);color:white;padding:0.625rem 1.5rem;border-radius:0.375rem;border:none;font-weight:500;cursor:pointer;transition:background 0.2s;">
                        Clear Cart
                    </button>
                </form>
                <a href="{{ route('checkout.index') }}" style="background:var(--btn-success-bg);color:white;padding:0.625rem 1.5rem;border-radius:0.375rem;text-decoration:none;font-weight:500;transition:background 0.2s;">
                    Proceed to Checkout
                </a>
            </div>
        </div>
    @endif
</div>
@endsection