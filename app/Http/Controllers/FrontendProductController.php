<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class FrontendProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['productImages.file', 'category'])
            ->where('status', 'published');  // ← fix: string not boolean

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products   = $query->paginate(12);
        $categories = Category::all();

        return view('shop.index', compact('products', 'categories'));
    }

    public function show(string $slug)
    {
        $product = Product::with(['productImages.file', 'category'])
            ->where('slug', $slug)
            ->where('status', 'published')  // ← fix
            ->firstOrFail();

        $related = Product::with(['productImages.file'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'published')  // ← fix
            ->limit(4)
            ->get();

        return view('shop.show', compact('product', 'related'));
    }
}