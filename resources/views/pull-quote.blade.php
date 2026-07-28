{{--
    Drop into a post body wherever there's a sentence worth pulling out. Don't
    use this for every post — reserve it for the one line that earns it.

    Usage:
        <x-pull-quote>
            Selepas 22 tahun menunggu, Arsenal akhirnya berpesta.
        </x-pull-quote>
--}}
<blockquote class="border-l-2 border-accent-400 pl-5 my-6">
    <p class="font-display italic text-lg leading-snug text-ink-900">
        {{ $slot }}
    </p>
</blockquote>
