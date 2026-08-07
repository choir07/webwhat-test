@extends('layouts.shop')

@section('title', 'Order Success')

@section('content')
<div style="max-width:36rem;margin:3rem auto;">
    <div style="text-align:center;background:#d1fae5;border:1px solid #86efac;color:#065f46;padding:2rem;border-radius:0.75rem;">
        <svg style="width:4rem;height:4rem;margin:0 auto 1rem;color:#16a34a;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <h2 style="font-size:1.5rem;font-weight:700;margin-bottom:0.5rem;"> Order Placed!</h2>
        <p style="color:#065f46;">Your order has been placed successfully.</p>
        <p style="color:#065f46;font-size:0.875rem;margin-top:0.5rem;">You will receive a confirmation email shortly.</p>
    </div>

    @if(isset($order))
        <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:0.75rem;padding:1.5rem;margin-top:1.5rem;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;flex-wrap:wrap;gap:0.5rem;">
                <div>
                    <div style="font-size:0.75rem;color:var(--text-secondary);">Order Number</div>
                    <div style="font-weight:600;color:var(--text-primary);">{{ $order->order_number }}</div>
                </div>
                <div style="text-align:right;">
                    <div style="font-size:0.75rem;color:var(--text-secondary);">Total</div>
                    <div style="font-weight:700;color:var(--text-primary);">{{ $order->formatted_total }}</div>
                </div>
            </div>

            <div style="border-top:1px solid var(--border-color);padding-top:1rem;">
                @foreach($order->items as $item)
                    <div style="display:flex;justify-content:space-between;font-size:0.875rem;color:var(--text-secondary);padding:0.35rem 0;">
                        <span>{{ $item->product->name ?? 'Item' }} &times; {{ $item->quantity }}</span>
                        <span>RM{{ number_format($item->total, 2) }}</span>
                    </div>
                @endforeach
            </div>

            <div style="display:flex;gap:0.75rem;margin-top:1.5rem;flex-wrap:wrap;">
                <a href="{{ route('order.invoice', $order->order_number) }}"
                    style="flex:1;text-align:center;background:var(--bg-body);border:1px solid var(--border-color);color:var(--text-primary);padding:0.625rem 1rem;border-radius:0.375rem;text-decoration:none;font-weight:500;">
                    View Invoice
                </a>
                <a href="{{ route('order.invoice.download', $order->order_number) }}"
                    style="flex:1;text-align:center;background:#2563eb;color:white;padding:0.625rem 1rem;border-radius:0.375rem;text-decoration:none;font-weight:500;">
                    Download Invoice (PDF)
                </a>
            </div>
        </div>
    @endif

    <div style="text-align:center;margin-top:1.5rem;">
        <a href="{{ route('shop.index') }}" style="display:inline-block;background:#2563eb;color:white;padding:0.625rem 1.5rem;border-radius:0.375rem;text-decoration:none;font-weight:500;">
            Continue Shopping
        </a>
    </div>
</div>
@endsection