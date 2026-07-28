{{--
    Deterministic colored initials avatar — same name always gets the same
    color, so it reads as a real identity rather than a random placeholder.

    Usage:
        <x-avatar-initials name="Rocks D. Xebec" size="11" />
--}}
@props([
    'name' => '?',
    'size' => '11',   // Tailwind spacing scale, e.g. 8, 9, 11
])

@php
    $initials = collect(explode(' ', trim($name)))
        ->filter()
        ->map(fn ($word) => mb_strtoupper(mb_substr($word, 0, 1)))
        ->take(2)
        ->implode('');

    // Literal class strings, not interpolated — Tailwind's JIT scanner only
    // picks up classes it can find as exact substrings in the source.
    $colorClasses = [
        'coral' => 'bg-tile-coral text-tile-coral-fg',
        'sage' => 'bg-tile-sage text-tile-sage-fg',
        'sand' => 'bg-tile-sand text-tile-sand-fg',
        'sky' => 'bg-tile-sky text-tile-sky-fg',
        'plum' => 'bg-tile-plum text-tile-plum-fg',
    ];
    $palette = array_keys($colorClasses);
    $color = $colorClasses[$palette[crc32($name) % count($palette)]];

    $sizeClasses = [
        '8' => 'w-8 h-8',
        '9' => 'w-9 h-9',
        '11' => 'w-11 h-11',
    ][$size] ?? 'w-9 h-9';
@endphp

<div
    class="{{ $sizeClasses }} rounded-full flex items-center justify-center flex-shrink-0 font-medium text-xs {{ $color }}"
    aria-hidden="true"
>
    {{ $initials ?: '?' }}
</div>
