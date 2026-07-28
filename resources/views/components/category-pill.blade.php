{{--
    Usage:
        <x-category-pill>Web app</x-category-pill>
        <x-category-pill :active="true">All</x-category-pill>            {{-- filled --}}
        <x-category-pill href="/shop?cat=electronics">Electronics</x-category-pill>
--}}
@props([
    'active' => false,
    'href' => null,
])

@php
    $base = 'inline-block text-xs px-3.5 py-1.5 rounded-full transition-colors';
    $classes = $active
        ? "{$base} bg-ink-900 text-ink-50"
        : "{$base} border border-ink-300 text-ink-700 hover:border-ink-500";
@endphp

@if ($href)
    <a href="{{ $href }}" class="{{ $classes }}">{{ $slot }}</a>
@else
    <span class="{{ $classes }}">{{ $slot }}</span>
@endif
