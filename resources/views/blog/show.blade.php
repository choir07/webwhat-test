@extends('layouts.app')

@section('title', $post->title . ' - The Powerful Posts')

@section('content')

    <!-- Table of Contents Sidebar (Desktop) -->
    @php
        $headings = [];
        if ($post->content) {
            preg_match_all('/<h2[^>]*>(.*?)<\/h2>/i', $post->content, $matches);
            $headings = $matches[1] ?? [];
        }
    @endphp

    @if(count($headings) > 0)
        <div class="hidden lg:block fixed right-8 top-1/3 w-64 bg-white dark:bg-gray-800 rounded-lg shadow-lg p-4">
            <h4 class="font-bold mb-3 text-sm"> Table of Contents</h4>
            <ul class="space-y-2 text-sm" id="toc-list">
                @foreach($headings as $index => $heading)
                    <li>
                        <a href="#heading-{{ $index }}" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 toc-link"
                            data-target="heading-{{ $index }}">
                            {{ Str::limit(strip_tags($heading), 40) }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <script>
            document.querySelectorAll('.toc-link').forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const targetId = link.dataset.target;
                    const targetElement = document.getElementById(targetId);
                    if (targetElement) {
                        targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            });

            document.addEventListener('DOMContentLoaded', () => {
                const contentDiv = document.querySelector('.prose');
                if (contentDiv) {
                    const headings = contentDiv.querySelectorAll('h2');
                    headings.forEach((heading, index) => {
                        heading.id = `heading-${index}`;
                        heading.classList.add('scroll-mt-20');
                    });
                }
            });
        </script>
    @endif

    <!-- Reading Progress Bar -->
    <div id="progressBar" class="fixed top-0 left-0 w-full h-1 bg-blue-500 z-50" style="width: 0%;"></div>

    <style>
        #progressBar {
            transition: width 0.3s ease;
        }
    </style>

    <script>
        window.addEventListener('scroll', () => {
            const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (winScroll / height) * 100;
            document.getElementById('progressBar').style.width = scrolled + '%';
        });
    </script>

    <div class="max-w-4xl mx-auto px-4 py-8">
        <article class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">

            <!-- Featured Image -->
            @php
                $imageUrl = null;
                if ($post->featured_image) {
                    $imageUrl = asset('storage/' . $post->featured_image);
                } elseif ($post->featured_image_id) {
                    $file = App\Models\File::find($post->featured_image_id);
                    if ($file) {
                        $imageUrl = $file->url;
                    }
                }
            @endphp

            @if($imageUrl)
                <img src="{{ $imageUrl }}" alt="{{ $post->title }}" class="w-full h-96 object-cover">
            @else
                <div class="w-full h-96 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                    <span class="text-gray-400">No image</span>
                </div>
            @endif

            <div class="p-8">
                @if($post->category)
                    <div class="text-sm text-blue-600 mb-2">{{ $post->category->name }}</div>
                @endif

                <h1 class="post-title text-4xl tracking-tight mb-4">{{ $post->title }}</h1>

                <div class="post-meta flex flex-wrap gap-4 text-sm mb-6 pb-4 border-b dark:border-gray-700">
                    <div>{{ $post->published_at ? $post->published_at->format('F j, Y') : 'Date not set' }}</div>
                    <div>By {{ $post->author->name ?? 'Unknown' }}</div>
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ $post->reading_time ?? ceil(str_word_count(strip_tags($post->content ?? $post->description)) / 200) }} min read
                    </div>
                    <div>{{ $post->views ?? 0 }} views</div>
                </div>

                @if($post->excerpt)
                    <div class="text-lg text-gray-600 dark:text-gray-300 italic mb-6 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        {{ $post->excerpt }}
                    </div>
                @endif

                <div class="prose max-w-none dark:prose-invert">
                    @if($post->description)
                        <p class="description-text text-lg leading-relaxed">{{ $post->description }}</p>
                    @elseif($post->content)
                        {!! $post->content !!}
                    @else
                        <p class="text-gray-500 italic">No description available.</p>
                    @endif
                </div>

                <div class="mt-6 pt-4 border-t dark:border-gray-700">
                    <button onclick="openShareModal()" class="flex items-center space-x-1 text-gray-500 hover:text-blue-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z">
                            </path>
                        </svg>
                        <span>Share</span>
                    </button>
                </div>
            </div>
        </article>

        @include('blog.partials.author-bio')

        @include('blog.partials.comments')

        @if(isset($relatedPosts) && $relatedPosts->count())
            <div class="mt-12">
                <h2 class="text-2xl font-bold mb-6">Related Posts</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedPosts as $related)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                            @php
                                $relatedImage = null;
                                if ($related->featured_image) {
                                    $relatedImage = asset('storage/' . $related->featured_image);
                                } elseif ($related->featured_image_id) {
                                    $file = App\Models\File::find($related->featured_image_id);
                                    if ($file)
                                        $relatedImage = $file->url;
                                }
                            @endphp
                            @if($relatedImage)
                                <img src="{{ $relatedImage }}" class="w-full h-40 object-cover">
                            @endif
                            <div class="p-4">
                                <h3 class="font-semibold">
                                    <a href="/blog/{{ $related->slug }}" class="hover:text-blue-600">
                                        {{ $related->title }}
                                    </a>
                                </h3>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    @include('blog.partials.share-modal')

@endsection