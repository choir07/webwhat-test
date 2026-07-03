<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $items = Cart::getItems();
        $total = Cart::getTotal();
        $count = Cart::getCount();
        
        return view('cart.index', compact('items', 'total', 'count'));
    }
    
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1'
        ]);
        
        $product = Product::find($request->product_id);
        Cart::add($product, $request->quantity ?? 1);
        
        return redirect()->back()->with('success', 'Product added to cart!');
    }
    
    public function remove($productId)
    {
        Cart::remove($productId);
        return redirect()->back()->with('success', 'Item removed from cart.');
    }
    
    public function update(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);
        
        Cart::update($productId, $request->quantity);
        return redirect()->back()->with('success', 'Cart updated successfully.');
    }
    
    public function clear()
    {
        Cart::clear();
        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }
}