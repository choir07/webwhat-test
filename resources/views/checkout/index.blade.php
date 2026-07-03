@extends('layouts.shop')

@section('title', 'Checkout')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Checkout</h1>

    @if(empty($items))
        <div class="text-center py-12">
            <p class="text-gray-500 text-lg">Your cart is empty.</p>
            <a href="{{ route('shop.index') }}" class="mt-4 inline-block bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                Continue Shopping
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Shipping Details -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Shipping Details</h2>
                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Full Name *</label>
                        <input type="text" name="name" required 
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Email *</label>
                        <input type="email" name="email" required 
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Shipping Address *</label>
                        <textarea name="address" required rows="3" 
                                  class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">City *</label>
                            <input type="text" name="city" required 
                                   class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Postal Code *</label>
                            <input type="text" name="postal_code" required 
                                   class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Payment Method</label>
                        <select name="payment_method" required 
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="stripe">Stripe</option>
                            <option value="paypal">PayPal</option>
                            <option value="midtrans">Midtrans</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="w-full bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 transition">
                        Place Order - ${{ number_format($total, 2) }}
                    </button>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
                <div class="space-y-3">
                    @foreach($items as $productId => $item)
                        <div class="flex justify-between py-2 border-b">
                            <div>
                                <span class="font-medium">{{ $item['name'] }}</span>
                                <span class="text-gray-500 text-sm ml-2">x {{ $item['quantity'] }}</span>
                            </div>
                            <span>${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                        </div>
                    @endforeach
                    <div class="flex justify-between py-2 font-bold text-lg">
                        <span>Total</span>
                        <span>${{ number_format($total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection