@extends('layouts.shop')

@section('title', 'Order Success')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-center">
    <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-8 rounded-lg max-w-md mx-auto">
        <svg class="w-16 h-16 mx-auto text-green-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <h2 class="text-2xl font-bold mb-2"> Order Placed!</h2>
        <p class="text-gray-700">Your order has been placed successfully.</p>
        <p class="text-gray-600 text-sm mt-2">You will receive a confirmation email shortly.</p>
        <a href="{{ route('shop.index') }}" class="mt-6 inline-block bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
            Continue Shopping
        </a>
    </div>
</div>
@endsection