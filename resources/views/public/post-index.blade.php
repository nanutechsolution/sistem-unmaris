<x-layouts.public title="Berita Kampus">

    {{-- HERO PREMIUM --}}
    <section class="bg-gradient-to-br from-unmaris-blue to-blue-900 text-white py-20 shadow-inner">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-4">
                Berita & Informasi Kampus
            </h1>
            <p class="text-lg md:text-xl text-white/80 max-w-2xl mx-auto leading-relaxed">
                Update resmi seputar kegiatan, event, dan pengumuman akademik Universitas Marisi Sumba.
            </p>
        </div>
    </section>

    {{-- CONTENT AREA --}}
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-4 gap-12">

            {{-- MAIN CONTENT --}}
            <div class="lg:col-span-3">

                {{-- FILTER --}}
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-10 gap-4">
                    <h2 class="text-2xl font-bold text-gray-800">Semua Berita</h2>

                    <form method="GET" class="flex items-center gap-3">
                        <select name="category" class="border-gray-300 rounded-lg focus:ring-unmaris-blue">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $cat)
                            <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                            @endforeach
                        </select>

                        <button class="px-4 py-2 bg-unmaris-blue text-white rounded-lg shadow hover:bg-blue-900 transition">
                            Filter
                        </button>
                    </form>
                </div>

                {{-- GRID BERITA --}}
                <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-10">
                    @forelse ($posts as $post)
                    <a href="{{ route('public.posts.show', $post->slug) }}" class="group bg-white rounded-2xl shadow hover:shadow-xl transition overflow-hidden border border-gray-100">

                        {{-- IMAGE --}}
                        <div class="h-48 overflow-hidden">
                            <img src="{{ $post->featured_image ? Storage::url($post->featured_image) : asset('images/default-news.jpg') }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </div>

                        <div class="p-6">
                            {{-- CATEGORY --}}
                            <span class="inline-block text-xs font-semibold bg-unmaris-yellow/20 text-unmaris-blue px-3 py-1 rounded-full mb-4">
                                {{ $post->category?->name ?? 'Umum' }}
                            </span>

                            {{-- TITLE --}}
                            <h3 class="text-lg font-bold text-gray-800 group-hover:text-unmaris-blue transition line-clamp-2 leading-tight">
                                {{ $post->title }}
                            </h3>

                            {{-- DATE --}}
                            <p class="text-gray-500 text-xs mt-2">
                                {{ $post->published_at->format('d F Y') }}
                            </p>

                            {{-- EXCERPT --}}
                            <p class="text-gray-600 text-sm mt-3 line-clamp-3">
                                {!! Str::limit(strip_tags($post->content), 140) !!}
                            </p>

                            {{-- READ MORE --}}
                            <p class="mt-5 text-unmaris-blue font-semibold group-hover:underline">
                                Baca Selengkapnya →
                            </p>
                        </div>
                    </a>
                    @empty
                    <p class="text-gray-500">Belum ada berita.</p>
                    @endforelse
                </div>

                {{-- PAGINATION --}}
                <div class="mt-12">
                    {{ $posts->links() }}
                </div>

            </div>

            {{-- SIDEBAR --}}
            <aside class="space-y-10">

                {{-- BOX: BERITA TERPOPULER --}}
                <div class="bg-white shadow rounded-xl p-6 border border-gray-100">
                    <h3 class="text-xl font-bold text-unmaris-blue mb-4">Berita Terbaru</h3>

                    <div class="space-y-5">
                        @foreach ($latestPosts as $item)
                        <a href="{{ route('public.posts.show', $item->slug) }}" class="flex gap-4 group">
                            {{-- Thumbnail kecil --}}
                            <div class="w-20 h-16 rounded-lg overflow-hidden">
                                <img src="{{ $item->featured_image ? Storage::url($item->featured_image) : asset('images/default-news.jpg') }}" class="w-full h-full object-cover group-hover:scale-110 transition">
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800 group-hover:text-unmaris-blue line-clamp-2 text-sm">
                                    {{ $item->title }}
                                </p>
                                <p class="text-gray-500 text-xs mt-1">
                                    {{ $item->published_at->format('d M Y') }}
                                </p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>

            </aside>

        </div>
    </section>

</x-layouts.public>
