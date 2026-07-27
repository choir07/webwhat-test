<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Shop') - The Powerful Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/dark-mode.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600&family=Inter:wght@400;500&display=swap" rel="stylesheet">
    <script>
        function toggleTheme() {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        }
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <style>
        * { font-family: 'Fraunces', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900">

    <nav class="bg-white dark:bg-gray-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a href="/" class="text-xl font-bold text-gray-800 dark:text-white">
                    Powerful sHOPS
                </a>
                <div class="flex items-center space-x-4">
                    <a href="/shop" class="text-gray-600 dark:text-gray-300 hover:text-blue-600">Shop</a>
                    <a href="/blog" class="text-gray-600 dark:text-gray-300 hover:text-blue-600">Blog</a>
                    <a href="/cart" class="relative text-gray-600 dark:text-gray-300 hover:text-blue-600">
                        🛒 Cart
                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </a>
                    <a href="/admin" class="text-gray-600 dark:text-gray-300 hover:text-blue-600">Admin</a>
                    <button onclick="toggleTheme()" class="text-gray-600 dark:text-gray-300 ml-2">
                        <span class="dark:hidden">🌙</span>
                        <span class="hidden dark:inline">☀️</span>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="bg-white dark:bg-gray-800 mt-12 py-6 border-t dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-500 dark:text-gray-400">
            &copy; {{ date('Y') }} Powerful sHOPS. All rights reserved.
        </div>
    </footer>

    <button id="backToTop"
        class="fixed bottom-6 right-6 bg-blue-600 text-white p-3 rounded-full shadow-lg hidden hover:bg-blue-700 transition z-50">
        ↑
    </button>

    <script>
        const backToTop = document.getElementById('backToTop');
        window.addEventListener('scroll', () => {
            backToTop.classList.toggle('hidden', window.scrollY <= 500);
        });
        backToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    </script>

    @stack('scripts')
</body>
</html>