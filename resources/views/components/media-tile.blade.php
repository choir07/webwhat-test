{{--
    Colored icon tile used wherever a real photo isn't consistent enough to sit
    next to the others (stock photos, phone photos, mixed aspect ratios).
    Pass an $image to use a real photo instead — the tile is the fallback, not a
    replacement for genuine product photography.

    Usage:
        <x-media-tile color="coral" height="h-24">
            <path d="..." />  {{-- inner SVG path(s) only, viewBox 0 0 24 24 --}}
        </x-media-tile>

        <x-media-tile :image="$product->image_url" height="h-24" />
--}}
@props([
    'color' => 'sand',
    'image' => null,
    'height' => 'h-24',
    'rounded' => 'rounded-t-card',
])

@php
    // Literal class strings — Tailwind's JIT scanner needs to see these as
    // exact substrings in the source, so string interpolation would silently
    // produce unstyled tiles in the production build.
    $colorClasses = [
        'coral' => ['bg-tile-coral', 'text-tile-coral-fg'],
        'sage' => ['bg-tile-sage', 'text-tile-sage-fg'],
        'sand' => ['bg-tile-sand', 'text-tile-sand-fg'],
        'sky' => ['bg-tile-sky', 'text-tile-sky-fg'],
        'plum' => ['bg-tile-plum', 'text-tile-plum-fg'],
    ];
    [$bg, $fg] = $colorClasses[$color] ?? $colorClasses['sand'];
@endphp

@if ($image)
    <img src="{{ $image }}" alt="" class="{{ $height }} {{ $rounded }} w-full object-cover">
@else
    <div class="{{ $height }} {{ $rounded }} {{ $bg }} flex items-center justify-center">
        <svg class="{{ $fg }} w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
            {{ $slot }}
        </svg>
    </div>
@endif
