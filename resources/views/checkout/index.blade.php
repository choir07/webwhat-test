@extends('layouts.shop')

@section('title', 'Checkout')

@section('content')
<div>
    <h1 class="shop-title">Checkout</h1>

    @if(session('error'))
        <div style="background:#fee2e2;color:#991b1b;padding:0.75rem 1rem;border-radius:0.5rem;margin-bottom:1rem;">
            {{ session('error') }}
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
        <div style="display:grid;grid-template-columns:1fr;gap:2rem;">
            <!-- Shipping Details -->
            <div style="background:white;border-radius:0.75rem;padding:1.5rem;box-shadow:0 1px 3px rgba(0,0,0,0.1);">
                <h2 style="font-size:1.25rem;font-weight:600;color:#111827;margin-bottom:1rem;">Shipping Details</h2>
                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf

                    <div style="margin-bottom:1rem;">
                        <label style="display:block;font-size:0.875rem;font-weight:500;color:#374151;margin-bottom:0.25rem;">
                            Full Name *
                        </label>
                        <input type="text" name="name" required
                               style="width:100%;border:1px solid #d1d5db;border-radius:0.375rem;padding:0.625rem;font-size:0.875rem;">
                    </div>

                    <div style="margin-bottom:1rem;">
                        <label style="display:block;font-size:0.875rem;font-weight:500;color:#374151;margin-bottom:0.25rem;">
                            Email *
                        </label>
                        <input type="email" name="email" required
                               style="width:100%;border:1px solid #d1d5db;border-radius:0.375rem;padding:0.625rem;font-size:0.875rem;">
                    </div>

                    <div style="margin-bottom:1rem;">
                        <label style="display:block;font-size:0.875rem;font-weight:500;color:#374151;margin-bottom:0.25rem;">
                            Shipping Address *
                        </label>
                        <textarea name="address" required rows="3"
                                  style="width:100%;border:1px solid #d1d5db;border-radius:0.375rem;padding:0.625rem;font-size:0.875rem;resize:vertical;"></textarea>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                        <div style="margin-bottom:1rem;">
                            <label style="display:block;font-size:0.875rem;font-weight:500;color:#374151;margin-bottom:0.25rem;">
                                City *
                            </label>
                            <input type="text" name="city" required
                                   style="width:100%;border:1px solid #d1d5db;border-radius:0.375rem;padding:0.625rem;font-size:0.875rem;">
                        </div>
                        <div style="margin-bottom:1rem;">
                            <label style="display:block;font-size:0.875rem;font-weight:500;color:#374151;margin-bottom:0.25rem;">
                                Postal Code *
                            </label>
                            <input type="text" name="postal_code" required
                                   style="width:100%;border:1px solid #d1d5db;border-radius:0.375rem;padding:0.625rem;font-size:0.875rem;">
                        </div>
                    </div>

                    <div style="margin-bottom:1.5rem;">
                        <label style="display:block;font-size:0.875rem;font-weight:500;color:#374151;margin-bottom:0.25rem;">
                            Payment Method
                        </label>
                        <input type="hidden" name="payment_method" value="billplz">
                        <div style="border:1px solid #d1d5db;border-radius:0.375rem;padding:0.625rem;font-size:0.875rem;color:#374151;background:#f9fafb;">
                            Billplz — FPX / Online Banking / Cards
                        </div>
                    </div>

                    <button type="submit" style="width:100%;background:#16a34a;color:white;padding:0.75rem;border-radius:0.375rem;border:none;font-weight:600;font-size:1rem;cursor:pointer;transition:background 0.2s;">
                        Place Order - RM{{ number_format($total, 2) }}
                    </button>
                </form>
            </div>

            <!-- Order Summary -->
            <div style="background:white;border-radius:0.75rem;padding:1.5rem;box-shadow:0 1px 3px rgba(0,0,0,0.1);">
                <h2 style="font-size:1.25rem;font-weight:600;color:#111827;margin-bottom:1rem;">Order Summary</h2>
                @foreach($items as $productId => $item)
                    <div style="display:flex;justify-content:space-between;padding:0.5rem 0;border-bottom:1px solid #f3f4f6;">
                        <div>
                            <span style="font-weight:500;color:#111827;">{{ $item['name'] }}</span>
                            <span style="color:#6b7280;font-size:0.875rem;margin-left:0.5rem;">x {{ $item['quantity'] }}</span>
                        </div>
                        <span style="color:#374151;">RM{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                    </div>
                @endforeach
                <div style="display:flex;justify-content:space-between;padding-top:0.75rem;font-weight:700;font-size:1.125rem;color:#111827;">
                    <span>Total</span>
                    <span>RM{{ number_format($total, 2) }}</span>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection