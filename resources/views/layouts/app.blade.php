<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @include('blog.partials.toast')

     @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset( 'css/dark-mode.css') }}">

    <title>@yield('title', 'Powerful pOSTS')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/dark-mode.css') }}">

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

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            color: #6aae8d;
        }

        h1, h2, h3, h4, h5, h6 {
            color: #58947f;
            font-weight: 600;
        }

        a {
            color: #2ba927;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #6366f1;
        }

        .prose {
            color: #212167;
        }

        .prose p {
            color: #4a4a6a;
            line-height: 1.7;
        }

        .post-title {
            color: #0f0f1a;
            font-weight: 700;
        }

        .post-meta {
            color: #6b7280;
            font-weight: 400;
        }

        .description-text {
            color: #4a4a6a;
            line-height: 1.6;
        }

        .dark {
            color-scheme: dark;
        }

        .dark body{
            background-color: #111827;
            color: #e5e7eb
        }
        
    </style>

    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
</head>

<body class="bg-gray-100">
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a href="/" class="text-xl font-bold text-gray-800">Powerful pOSTS</a>
                <img src="{{ asset('images/post-logo.webp') }}" alt="Logo" class="h-8 w-auto">
                <div class="space-x-4">
                    <a href="/blog" class="text-gray-600 hover:text-gray-800">All Posts</a>
                    <a href="/admin" class="text-gray-600 hover:text-gray-800">Admin</a>
                    <button onclick="toggleTheme()" class="text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white ml-4">
                        <span class="dark:hidden">🌙 Dark</span>
                        <span class="hidden dark:inline">☀️ Light/🌙 Dark</span>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="bg-white mt-12 py-6">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-500">
            &copy; {{ date('Y') }} My Blog. All rights reserved.
        </div>
    </footer>

    <button id="backToTop"
        class="fixed bottom-6 right-6 bg-blue-600 text-white p-3 rounded-full shadow-lg hidden hover:bg-blue-700 transition z-50">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button>

    <script>
        const backToTop = document.getElementById('backToTop');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 500) {
                backToTop.classList.remove('hidden');
            } else {
                backToTop.classList.add('hidden');
            }
        });

        backToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    </script>
</body>
</html>