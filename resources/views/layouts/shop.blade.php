<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Shop') - {{ config('app.name') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    
    <!-- ✅ CUSTOM CSS - No Tailwind needed -->
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #f9fafb;
            color: #111827;
            line-height: 1.6;
        }
        
        /* Layout */
        .shop-container { max-width: 1280px; margin: 0 auto; padding: 0 1rem; }
        
        /* Header */
        .shop-header {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 1rem 0;
            margin-bottom: 2rem;
        }
        .shop-header-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .shop-logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: #111827;
            text-decoration: none;
        }
        .shop-nav {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        .shop-nav a {
            color: #4b5563;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: color 0.2s;
        }
        .shop-nav a:hover { color: #111827; }
        
        /* Title */
        .shop-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 1.5rem;
        }
        
        /* Search */
        .shop-search {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .shop-search-input {
            border: 1px solid #d1d5db;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem 0 0 0.375rem;
            font-size: 0.875rem;
            outline: none;
        }
        .shop-search-input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
        .shop-search-btn {
            background: #111827;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0 0.375rem 0.375rem 0;
            font-size: 0.875rem;
            border: none;
            cursor: pointer;
            transition: background 0.2s;
        }
        .shop-search-btn:hover { background: #374151; }
        
        /* Categories */
        .shop-categories {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 2rem;
        }
        .category-pill {
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            text-decoration: none;
            transition: all 0.2s;
        }
        .category-pill.active {
            background: #111827;
            color: white;
        }
        .category-pill.inactive {
            background: #e5e7eb;
            color: #4b5563;
        }
        .category-pill.inactive:hover {
            background: #d1d5db;
        }
        
        /* Product Grid */
        .shop-grid {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 1.5rem;
        }
        @media (min-width: 640px) {
            .shop-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (min-width: 768px) {
            .shop-grid { grid-template-columns: repeat(3, 1fr); }
        }
        @media (min-width: 1024px) {
            .shop-grid { grid-template-columns: repeat(4, 1fr); }
        }
        
        /* Product Card */
        .product-card {
            background: white;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            transition: all 0.3s;
        }
        .product-card:hover {
            box-shadow: 0 10px 40px rgba(0,0,0,0.12);
            transform: translateY(-4px);
        }
        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            display: block;
        }
        .product-body {
            padding: 1rem;
        }
        .product-name {
            font-size: 1rem;
            font-weight: 600;
            color: #111827;
            text-decoration: none;
            display: block;
            margin-bottom: 0.25rem;
        }
        .product-name:hover { color: #2563eb; }
        .product-category {
            font-size: 0.75rem;
            color: #6b7280;
            margin-bottom: 0.5rem;
        }
        .product-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 0.5rem;
        }
        .product-price {
            font-size: 1.125rem;
            font-weight: 700;
            color: #111827;
        }
        .product-price.sale { color: #dc2626; }
        .product-price .original {
            font-size: 0.75rem;
            color: #9ca3af;
            text-decoration: line-through;
            font-weight: 400;
            margin-left: 0.5rem;
        }
        .btn-add-cart {
            background: #2563eb;
            color: white;
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-add-cart:hover { background: #1d4ed8; }
        
        /* Pagination */
        .shop-pagination {
            margin-top: 2rem;
            display: flex;
            justify-content: center;
        }
        
        /* Empty state */
        .no-products {
            text-align: center;
            padding: 3rem 0;
            color: #6b7280;
        }
        
        /* Footer */
        .shop-footer {
            background: white;
            border-top: 1px solid #e5e7eb;
            padding: 1.5rem 0;
            margin-top: 3rem;
            text-align: center;
            color: #6b7280;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="shop-header">
        <div class="shop-header-inner">
            <a href="{{ route('shop.index') }}" class="shop-logo">🛒 Powerful sHOPS</a>
            <nav class="shop-nav">
                <a href="{{ route('shop.index') }}">Shop</a>
                <a href="{{ url('/') }}">Blog</a>
                <a href="{{ route('cart.index') }}">Cart</a>
                <a href="{{ url('/admin/login') }}">Admin</a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="shop-container">
        @if(session('success'))
            <div style="background:#d1fae5;color:#065f46;padding:0.75rem 1rem;border-radius:0.5rem;margin-bottom:1rem;">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div style="background:#fee2e2;color:#991b1b;padding:0.75rem 1rem;border-radius:0.5rem;margin-bottom:1rem;">
                {{ session('error') }}
            </div>
        @endif
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="shop-footer">
        &copy; {{ date('Y') }} Powerful sHOPS. All rights reserved.
    </footer>
</body>
</html>