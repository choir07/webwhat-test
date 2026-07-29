{{--
Include once, in BOTH layouts, immediately BEFORE the
<script src="https://cdn.tailwindcss.com"></script> tag — the CDN script
reads window.tailwind.config at load time, so this must run first.

resources/views/layouts/app.blade.php
resources/views/layouts/shop.blade.php

The CDN build scans the live DOM for classes instead of a content[] file
list, so there's no `content` key here — that option only exists for the
npm/PostCSS build. `plugins` is also dropped: the CDN script can't load
npm plugin packages, only the config object itself.
--}}
<script>
    tailwind.config = {
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
