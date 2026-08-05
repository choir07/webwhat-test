<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @include('blog.partials.toast')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/dark-mode.css') }}">

    <title>@yield('title', 'Powerful pOSTS')</title>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        // Display face: used only for h1/h2 and pull-quotes. Restraint
                        // matters — never apply this to body copy or UI chrome.
                        display: ['Fraunces', 'ui-serif', 'Georgia', 'serif'],
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        // One accent per surface, not five. Add a second only if you
                        // introduce a genuinely new semantic meaning (e.g. "sale" vs "new").
                        ink: {
                            950: '#14120f',
                            900: '#201d18',
                            700: '#4a453c',
                            500: '#7a7468',
                            300: '#b8b2a4',
                            100: '#ece8df',
                            50: '#f7f5f0',
                        },
                        accent: {
                            50: '#e1f5ee',
                            100: '#9fe1cb',
                            400: '#1d9e75',
                            600: '#0f6e56',
                            800: '#085041',
                        },
                        tile: {
                            // Backgrounds for the icon tiles that replace inconsistent
                            // stock photography — see components/media-tile.blade.php
                            coral: '#f5ded5',
                            'coral-fg': '#993c1d',
                            sage: '#dcebd2',
                            'sage-fg': '#3b6d11',
                            sand: '#f6e6c8',
                            'sand-fg': '#854f0b',
                            sky: '#d6e7f7',
                            'sky-fg': '#185fa5',
                            plum: '#e3ddf2',
                            'plum-fg': '#53468f',
                        },
                    },
                    borderRadius: {
                        card: '12px',
                    },
                },
            },
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/dark-mode.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600&family=Inter:wght@400;500&display=swap"
        rel="stylesheet">

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
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            color: #3f3a2e;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            color: #201d18;
            font-weight: 600;
        }

        a {
            color: #0f6e56;
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

        .dark body {
            background-color: #111827;
            color: #e5e7eb;
        }

        .dark h1,
        .dark h2,
        .dark h3,
        .dark h4,
        .dark h5,
        .dark h6 {
            color: #f3f4f6;
        }

        .dark a {
            color: #9fe1cb;
        }

        .dark .prose {
            color: #d1d5db;
        }

        .dark .prose p {
            color: #d1d5db;
        }

        .dark .post-title {
            color: #f7f5f0;
        }

        .dark .post-meta {
            color: #9ca3af;
        }

        .dark .description-text {
            color: #d1d5db;
        }
    </style>

    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
</head>

<body class="bg-gray-100 dark:bg-gray-900">
    <nav class="bg-white dark:bg-gray-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a href="/" class="text-xl font-bold text-gray-800 dark:text-gray-100">Powerful pOSTS</a>
                <img src="{{ asset('images/post-logo.webp') }}" alt="Logo" class="h-8 w-auto">
                <div class="space-x-4">
                    <a href="/blog" class="text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white">All Posts</a>
                    <a href="/admin" class="text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white">Admin</a>
                    <a href="/shop" class="text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white">Shop</a>
                    <button onclick="toggleTheme()"
                        class="text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white ml-4">
                        <span class="dark:hidden">🌙 Dark mode</span>
                        <span class="hidden dark:inline">☀️ Light mode</span>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="bg-white dark:bg-gray-800 mt-12 py-6">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-500 dark:text-gray-400">
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