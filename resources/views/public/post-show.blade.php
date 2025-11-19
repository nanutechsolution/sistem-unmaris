<x-layouts.public title="{{ $post->title }}">
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-3 gap-12">

            {{-- MAIN CONTENT --}}
            <article class="lg:col-span-2 bg-white p-8 rounded-2xl shadow">

                {{-- TITLE --}}
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 leading-tight">
                    {{ $post->title }}
                </h1>

                {{-- META --}}
                <div class="flex items-center gap-3 text-gray-500 text-sm mt-4">
                    <span>Oleh <span class="text-unmaris-blue font-semibold">{{ $post->author?->name ?? 'Admin' }}</span></span>
                    <span>•</span>
                    <span>{{ $post->published_at->format('d F Y') }}</span>
                    <span>•</span>
                    <span class="text-unmaris-yellow font-semibold">{{ $post->category?->name ?? 'Umum' }}</span>
                </div>

                {{-- FEATURED IMAGE --}}
                @if ($post->featured_image)
                <img src="{{ Storage::url($post->featured_image) }}" class="rounded-xl w-full h-[420px] object-cover mt-8 shadow">
                @endif

                {{-- SHARE BUTTONS --}}
                <div class="flex gap-3 mt-8">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::url()) }}" target="_blank" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                        Share Facebook
                    </a>

                    <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title.' '.Request::url()) }}" target="_blank" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                        WhatsApp
                    </a>

                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(Request::url()) }}&text={{ urlencode($post->title) }}" target="_blank" class="px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800 transition">
                        X (Twitter)
                    </a>
                </div>

                {{-- CONTENT --}}
                <div class="prose prose-lg max-w-none mt-10">
                    {!! $post->content !!}
                </div>
            </article>

            {{-- SIDEBAR --}}
            <aside class="space-y-10">

                {{-- BERITA TERBARU --}}
                <div class="bg-white rounded-2xl shadow p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-6">Berita Terbaru</h3>

                    @foreach ($latestPosts as $latest)
                    <a href="{{ route('public.posts.show', $latest->slug) }}" class="flex gap-4 mb-5 group">
                        <img src="{{ $latest->featured_image ? Storage::url($latest->featured_image) : asset('images/default-news.jpg') }}" class="w-20 h-20 rounded-md object-cover shadow group-hover:scale-105 transition">
                        <div>
                            <p class="font-semibold text-gray-800 group-hover:text-unmaris-blue line-clamp-2">
                                {{ $latest->title }}
                            </p>
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $latest->published_at->format('d M Y') }}
                            </p>
                        </div>
                    </a>
                    @endforeach
                </div>

                {{-- KATEGORI --}}
                <div class="bg-white rounded-2xl shadow p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Kategori</h3>
                    <div class="space-y-3">
                        @foreach ($categories as $cat)
                        <a href="{{ route('public.posts.index', ['category' => $cat->slug]) }}" class="block text-gray-700 hover:text-unmaris-blue font-medium">
                            • {{ $cat->name }}
                        </a>
                        @endforeach
                    </div>
                </div>

            </aside>

        </div>
    </section>

</x-layouts.public>
