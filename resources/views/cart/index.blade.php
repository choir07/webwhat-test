@extends('layouts.shop')  {{-- Changed from layouts.app --}}

@section('title', 'Shopping Cart')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Shopping Cart</h1>
    
    @if(empty($items))
        <div class="text-center py-12">
            <p class="text-gray-500 text-lg">Your cart is empty.</p>
            <a href="{{ route('shop.index') }}" class="mt-4 inline-block bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                Continue Shopping
            </a>
        </div>
    @else
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($items as $productId => $item)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @if(isset($item['image']) && $item['image'])
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-16 h-16 object-cover rounded mr-4">
                                @else
                                <div class="w-16 h-16 bg-gray-200 rounded mr-4 flex items-center justify-center text-gray-400">
                                    No Image
                                </div>
                                @endif
                                <span class="font-medium">{{ $item['name'] }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">${{ number_format($item['price'], 2) }}</td>
                        <td class="px-6 py-4">
                            <form action="{{ route('cart.update', $productId) }}" method="POST" class="flex items-center">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="w-16 border rounded px-2 py-1">
                                <button type="submit" class="ml-2 text-blue-600 hover:text-blue-800">Update</button>
                            </form>
                        </td>
                        <td class="px-6 py-4">${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                        <td class="px-6 py-4">
                            <form action="{{ route('cart.remove', $productId) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">Remove</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-right font-bold">Total:</td>
                        <td class="px-6 py-4 font-bold">${{ number_format($total, 2) }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <div class="mt-6 flex justify-between">
            <a href="{{ route('shop.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                Continue Shopping
            </a>
            <div>
                <form action="{{ route('cart.clear') }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-6 py-2 rounded hover:bg-red-600 mr-2">
                        Clear Cart
                    </button>
                </form>
                <a href="{{ route('checkout.index') }}" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">
                    Proceed to Checkout
                </a>
            </div>
        </div>
    @endif
</div>
@endsection