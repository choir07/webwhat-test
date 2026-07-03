<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\Cart;

class CheckoutController extends Controller
{
    public function index()
    {
        $items = Cart::getItems();
        $total = Cart::getTotal();
        $count = Cart::getCount();
        
        if ($count == 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }
        
        return view('checkout.index', compact('items', 'total', 'count'));
    }
    
    public function process(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string',
            'payment_method' => 'required|in:stripe,paypal,midtrans',
        ]);
        
        // 1. Create an order record
        // 2. Process payment
        // 3. Clear the cart
        // 4. coming soon
        
        // For now, just redirect to success
        Cart::clear();
        
        return redirect()->route('order.success')->with('success', 'Order placed successfully!');
    }
    
    public function success()
    {
        return view('order.success');
    }
}