<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="@if(session('theme') === 'dark' || (!session('theme') && Cookie::get('theme') === 'dark')) dark @endif">

@php
    $isShopDomain = str_contains(request()->getHost(), 'shop.');
    $isBlogDomain = str_contains(request()->getHost(), 'blog.');
@endphp

<!-- Navigation -->
<nav class="shop-nav">
    @if($isShopDomain)
        <a href="{{ url('/') }}" class="active">Shop</a>
        <a href="{{ url('https://innovative-miracle-production-2200.up.railway.app/') }}">Blog</a>
    @else
        <a href="{{ url('https://pleasing-sparkle-production-7b89.up.railway.app') }}">Shop</a>
        <a href="{{ url('/') }}" class="active">Blog</a>
    @endif
    <a href="{{ route('cart.index') }}">Cart</a>
    <a href="{{ url('/admin/login') }}">Admin</a>
</nav>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Shop') - {{ config('app.name') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    
    <style>
        /* ===== BASE STYLES ===== */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        :root {
            --bg-body: #f9fafb;
            --bg-white: #ffffff;
            --bg-hover: #f3f4f6;
            --bg-header: #ffffff;
            --bg-card: #ffffff;
            --bg-input: #ffffff;
            --bg-table-header: #f9fafb;
            --bg-table-hover: #f9fafb;
            --text-primary: #111827;
            --text-secondary: #4b5563;
            --text-muted: #6b7280;
            --text-light: #9ca3af;
            --border-color: #e5e7eb;
            --border-light: #f3f4f6;
            --shadow-color: rgba(0,0,0,0.1);
            --shadow-hover: rgba(0,0,0,0.12);
            --btn-primary-bg: #2563eb;
            --btn-primary-hover: #1d4ed8;
            --btn-success-bg: #16a34a;
            --btn-success-hover: #15803d;
            --btn-danger-bg: #dc2626;
            --btn-danger-hover: #b91c1c;
            --btn-gray-bg: #6b7280;
            --btn-gray-hover: #4b5563;
        }
        
        .dark {
            --bg-body: #111827;
            --bg-white: #1f2937;
            --bg-hover: #374151;
            --bg-header: #1f2937;
            --bg-card: #1f2937;
            --bg-input: #374151;
            --bg-table-header: #1f2937;
            --bg-table-hover: #374151;
            --text-primary: #f9fafb;
            --text-secondary: #9ca3af;
            --text-muted: #9ca3af;
            --text-light: #6b7280;
            --border-color: #374151;
            --border-light: #374151;
            --shadow-color: rgba(0,0,0,0.3);
            --shadow-hover: rgba(0,0,0,0.4);
            --btn-primary-bg: #3b82f6;
            --btn-primary-hover: #2563eb;
            --btn-success-bg: #22c55e;
            --btn-success-hover: #16a34a;
            --btn-danger-bg: #ef4444;
            --btn-danger-hover: #dc2626;
            --btn-gray-bg: #6b7280;
            --btn-gray-hover: #9ca3af;
        }
        
        body { 
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg-body);
            color: var(--text-primary);
            line-height: 1.6;
            transition: background 0.3s ease, color 0.3s ease;
        }
        
        /* ===== LAYOUT ===== */
        .shop-container { max-width: 1280px; margin: 0 auto; padding: 0 1rem; }
        
        /* ===== HEADER ===== */
        .shop-header {
            background: var(--bg-header);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 0;
            margin-bottom: 2rem;
            transition: background 0.3s ease, border-color 0.3s ease;
        }
        .shop-header-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.75rem;
        }
        .shop-logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .shop-nav {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            flex-wrap: wrap;
        }
        .shop-nav a {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: color 0.2s;
        }
        .shop-nav a:hover { color: var(--text-primary); }
        
        /* ===== DARK MODE TOGGLE ===== */
        .theme-toggle {
            background: var(--bg-hover);
            border: 1px solid var(--border-color);
            border-radius: 9999px;
            padding: 0.375rem 0.625rem;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.3s ease;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }
        .theme-toggle:hover {
            background: var(--border-color);
        }
        .theme-toggle .icon-sun { display: inline-block; }
        .theme-toggle .icon-moon { display: none; }
        .dark .theme-toggle .icon-sun { display: none; }
        .dark .theme-toggle .icon-moon { display: inline-block; }
        
        /* ===== TITLE ===== */
        .shop-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
            transition: color 0.3s ease;
        }
        
        /* ===== SEARCH ===== */
        .shop-search {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .shop-search-input {
            background: var(--bg-input);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
            padding: 0.5rem 1rem;
            border-radius: 0.375rem 0 0 0.375rem;
            font-size: 0.875rem;
            outline: none;
            transition: all 0.3s ease;
        }
        .shop-search-input:focus {
            border-color: var(--btn-primary-bg);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
        .shop-search-input::placeholder {
            color: var(--text-muted);
        }
        .shop-search-btn {
            background: var(--text-primary);
            color: var(--bg-body);
            padding: 0.5rem 1rem;
            border-radius: 0 0.375rem 0.375rem 0;
            font-size: 0.875rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .shop-search-btn:hover { 
            background: var(--text-secondary);
            color: var(--bg-white);
        }
        
        /* ===== CATEGORIES ===== */
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
            transition: all 0.3s ease;
        }
        .category-pill.active {
            background: var(--text-primary);
            color: var(--bg-body);
        }
        .category-pill.inactive {
            background: var(--bg-hover);
            color: var(--text-secondary);
        }
        .category-pill.inactive:hover {
            background: var(--border-color);
            color: var(--text-primary);
        }
        
        /* ===== PRODUCT GRID ===== */
        .shop-grid {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 1.5rem;
        }
        @media (min-width: 640px) { .shop-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (min-width: 768px) { .shop-grid { grid-template-columns: repeat(3, 1fr); } }
        @media (min-width: 1024px) { .shop-grid { grid-template-columns: repeat(4, 1fr); } }
        
        /* ===== PRODUCT CARD ===== */
        .product-card {
            background: var(--bg-card);
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 1px 3px var(--shadow-color);
            transition: all 0.3s ease;
        }
        .product-card:hover {
            box-shadow: 0 10px 40px var(--shadow-hover);
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
            color: var(--text-primary);
            text-decoration: none;
            display: block;
            margin-bottom: 0.25rem;
            transition: color 0.2s;
        }
        .product-name:hover { color: var(--btn-primary-bg); }
        .product-category {
            font-size: 0.75rem;
            color: var(--text-muted);
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
            color: var(--text-primary);
        }
        .product-price.sale { color: #dc2626; }
        .dark .product-price.sale { color: #ef4444; }
        .product-price .original {
            font-size: 0.75rem;
            color: var(--text-light);
            text-decoration: line-through;
            font-weight: 400;
            margin-left: 0.5rem;
        }
        .btn-add-cart {
            background: var(--btn-primary-bg);
            color: white;
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-add-cart:hover { background: var(--btn-primary-hover); }
        
        /* ===== PAGINATION ===== */
        .shop-pagination {
            margin-top: 2rem;
            display: flex;
            justify-content: center;
        }
        .shop-pagination nav {
            display: flex;
            gap: 0.25rem;
        }
        .shop-pagination a, .shop-pagination span {
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.2s;
        }
        .shop-pagination a:hover {
            background: var(--bg-hover);
            color: var(--text-primary);
        }
        .shop-pagination .active {
            background: var(--text-primary);
            color: var(--bg-body);
        }
        
        /* ===== CART TABLE ===== */
        .cart-table {
            width: 100%;
            border-collapse: collapse;
            background: var(--bg-card);
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 1px 3px var(--shadow-color);
        }
        .cart-table thead {
            background: var(--bg-table-header);
            border-bottom: 1px solid var(--border-color);
        }
        .cart-table th {
            padding: 0.75rem 1rem;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--text-muted);
        }
        .cart-table td {
            padding: 1rem;
            color: var(--text-primary);
            border-bottom: 1px solid var(--border-light);
        }
        .cart-table tfoot {
            background: var(--bg-table-header);
        }
        .cart-table tfoot td {
            font-weight: 600;
            font-size: 1.125rem;
            color: var(--text-primary);
        }
        
        /* ===== EMPTY STATE ===== */
        .no-products {
            text-align: center;
            padding: 3rem 0;
            color: var(--text-muted);
        }
        
        /* ===== FOOTER ===== */
        .shop-footer {
            background: var(--bg-header);
            border-top: 1px solid var(--border-color);
            padding: 1.5rem 0;
            margin-top: 3rem;
            text-align: center;
            color: var(--text-muted);
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }
        
        /* ===== ALERTS ===== */
        .alert-success {
            background: #d1fae5;
            color: #065f46;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }
        .dark .alert-success {
            background: #065f46;
            color: #d1fae5;
        }
        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }
        .dark .alert-error {
            background: #991b1b;
            color: #fee2e2;
        }
        
        /* ===== CHECKOUT ===== */
        .checkout-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        @media (min-width: 1024px) {
            .checkout-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
        .checkout-card {
            background: var(--bg-card);
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px var(--shadow-color);
            transition: background 0.3s ease;
        }
        .checkout-card h2 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }
        .checkout-input {
            width: 100%;
            background: var(--bg-input);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            padding: 0.625rem;
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }
        .checkout-input:focus {
            border-color: var(--btn-primary-bg);
            outline: none;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
        .checkout-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-secondary);
            margin-bottom: 0.25rem;
        }
        .checkout-select {
            width: 100%;
            background: var(--bg-input);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            padding: 0.625rem;
            font-size: 0.875rem;
        }
        .btn-place-order {
            width: 100%;
            background: var(--btn-success-bg);
            color: white;
            padding: 0.75rem;
            border-radius: 0.375rem;
            border: none;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-place-order:hover {
            background: var(--btn-success-hover);
        }
        
        /* ===== SUCCESS PAGE ===== */
        .success-container {
            max-width: 28rem;
            margin: 3rem auto;
            text-align: center;
        }
        .success-card {
            background: #d1fae5;
            border: 1px solid #86efac;
            color: #065f46;
            padding: 2rem;
            border-radius: 0.75rem;
        }
        .dark .success-card {
            background: #065f46;
            border-color: #22c55e;
            color: #d1fae5;
        }
        .success-icon {
            width: 4rem;
            height: 4rem;
            margin: 0 auto 1rem;
            color: #16a34a;
        }
        .dark .success-icon {
            color: #22c55e;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="shop-header">
        <div class="shop-header-inner">
            <a href="{{ route('shop.index') }}" class="shop-logo"> Powerful sHOPS</a>
            <nav class="shop-nav">
                <a href="{{ route('shop.index') }}">Shop</a>
                <a href="{{ url('/') }}">Blog</a>
                <a href="{{ route('cart.index') }}">Cart</a>
                <a href="{{ url('/admin/login') }}">Admin</a>
                
                <!-- Dark Mode Toggle -->
                <button id="themeToggle" class="theme-toggle" aria-label="Toggle dark mode">
                    <span class="icon-sun">☀️</span>
                    <span class="icon-moon">🌙</span>
                    <span id="themeLabel" style="font-size:0.75rem;font-weight:500;">Light</span>
                </button>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="shop-container">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="shop-footer">
        &copy; {{ date('Y') }} Powerful sHOPS. All rights reserved.
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('themeToggle');
            const label = document.getElementById('themeLabel');
            const html = document.documentElement;
            
            // Check saved theme
            let theme = localStorage.getItem('shop_theme') || 'light';
            if (theme === 'dark') {
                html.classList.add('dark');
                label.textContent = 'Dark';
            } else {
                html.classList.remove('dark');
                label.textContent = 'Light';
            }
            
            toggle.addEventListener('click', function() {
                const isDark = html.classList.toggle('dark');
                theme = isDark ? 'dark' : 'light';
                localStorage.setItem('shop_theme', theme);
                label.textContent = isDark ? 'Dark' : 'Light';
                
                // Optionally save to session for server-side
                fetch('/set-theme', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ theme: theme })
                }).catch(() => {});
            });
        });
    </script>
</body>
</html>