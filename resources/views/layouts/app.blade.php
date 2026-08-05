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

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        :root {
            --bg-body: #f7f5f0;
            --bg-card: #ffffff;
            --bg-header: #ffffff;
            --text-primary: #201d18;
            --text-secondary: #4a453c;
            --text-muted: #7a7468;
            --border-color: #ece8df;
            --link-color: #0f6e56;
            --link-hover: #6366f1;
        }

        .dark {
            color-scheme: dark;
            --bg-body: #14120f;
            --bg-card: #1f2937;
            --bg-header: #1f2937;
            --text-primary: #f7f5f0;
            --text-secondary: #d1d5db;
            --text-muted: #9ca3af;
            --border-color: #374151;
            --link-color: #9fe1cb;
            --link-hover: #a5b4fc;
        }

        body {
            background: var(--bg-body);
            color: var(--text-secondary);
            transition: background 0.3s ease, color 0.3s ease;
        }

        h1, h2, h3, h4, h5, h6 {
            color: var(--text-primary);
            font-weight: 600;
        }

        a {
            color: var(--link-color);
            transition: color 0.3s ease;
        }

        a:hover {
            color: var(--link-hover);
        }

        .prose,
        .prose p {
            color: var(--text-secondary);
            line-height: 1.7;
        }

        .post-title {
            color: var(--text-primary);
            font-weight: 700;
        }

        .post-meta {
            color: var(--text-muted);
            font-weight: 400;
        }

        .description-text {
            color: var(--text-secondary);
            line-height: 1.6;
        }

        .blog-header,
        .blog-footer {
            background: var(--bg-header);
            transition: background 0.3s ease;
        }

        .blog-nav a {
            color: var(--text-secondary);
        }

        .blog-nav a:hover {
            color: var(--text-primary);
        }

        .blog-card {
            background: var(--bg-card);
            border-color: var(--border-color);
            transition: background 0.3s ease, border-color 0.3s ease;
        }

        .theme-toggle .icon-sun { display: inline-block; }
        .theme-toggle .icon-moon { display: none; }
        .dark .theme-toggle .icon-sun { display: none; }
        .dark .theme-toggle .icon-moon { display: inline-block; }
    </style>

    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
</head>

<body>
    <header class="blog-header shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a href="/" class="text-xl font-bold" style="color: var(--text-primary);">Powerful pOSTS</a>
                <img src="{{ asset('images/post-logo.webp') }}" alt="Logo" class="h-8 w-auto">
                <div class="blog-nav flex items-center space-x-4">
                    <a href="/blog">All Posts</a>
                    <a href="/admin">Admin</a>
                    <a href="/shop">Shop</a>
                    <button id="themeToggle" class="theme-toggle flex items-center gap-1 ml-4" aria-label="Toggle dark mode">
                        <span class="icon-sun">☀️</span>
                        <span class="icon-moon">🌙</span>
                        <span id="themeLabel" style="font-size:0.75rem;font-weight:500;">Light</span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="blog-footer mt-12 py-6">
        <div class="max-w-7xl mx-auto px-4 text-center" style="color: var(--text-muted);">
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

        document.addEventListener('DOMContentLoaded', function () {
            const toggle = document.getElementById('themeToggle');
            const label = document.getElementById('themeLabel');
            const html = document.documentElement;

            let theme = localStorage.getItem('blog_theme') || 'light';
            if (theme === 'dark') {
                html.classList.add('dark');
                label.textContent = 'Dark';
            } else {
                html.classList.remove('dark');
                label.textContent = 'Light';
            }

            toggle.addEventListener('click', function () {
                const isDark = html.classList.toggle('dark');
                theme = isDark ? 'dark' : 'light';
                localStorage.setItem('blog_theme', theme);
                label.textContent = isDark ? 'Dark' : 'Light';
            });
        });
    </script>
</body>

</html>