@extends('layouts.shop')

@section('title', 'Order Success')

@section('content')
<div style="max-width:28rem;margin:3rem auto;text-align:center;">
    <div style="background:#d1fae5;border:1px solid #86efac;color:#065f46;padding:2rem;border-radius:0.75rem;">
        <svg style="width:4rem;height:4rem;margin:0 auto 1rem;color:#16a34a;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <h2 style="font-size:1.5rem;font-weight:700;margin-bottom:0.5rem;"> Order Placed!</h2>
        <p style="color:#065f46;">Your order has been placed successfully.</p>
        <p style="color:#065f46;font-size:0.875rem;margin-top:0.5rem;">You will receive a confirmation email shortly.</p>
        <a href="{{ route('shop.index') }}" style="display:inline-block;margin-top:1.5rem;background:#2563eb;color:white;padding:0.625rem 1.5rem;border-radius:0.375rem;text-decoration:none;font-weight:500;">
            Continue Shopping
        </a>
    </div>
</div>
@endsection