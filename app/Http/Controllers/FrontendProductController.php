<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class FrontendProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')  // Eager load category
            ->where('status', true);

        // Category filter
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Sort
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // ✅ CRITICAL: Use paginate, NOT get()
        $products = $query->paginate(12);

        $categories = Category::all();

        return view('shop.index', compact('products', 'categories'));
    }

    public function show($slug)
    {
        // ✅ Eager load category
        $product = Product::with('category')
            ->where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        $related = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', true)
            ->limit(4)
            ->get();

        return view('shop.show', compact('product', 'related'));
    }
}