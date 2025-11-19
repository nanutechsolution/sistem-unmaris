<x-layouts.public title="Kabar Kampus & Artikel">

    {{-- HEADER SECTION --}}
    <section class="bg-unmaris-blue text-white pt-28 pb-16 relative overflow-hidden">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-unmaris-yellow/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 rounded-full bg-white/10 blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4 tracking-tight">Kabar Kampus</h1>
            <p class="text-blue-100 text-lg max-w-2xl mx-auto">
                Informasi terkini, prestasi mahasiswa, dan artikel akademik dari civitas akademika UNMARIS.
            </p>

            {{-- Search Bar --}}
            <div class="mt-8 max-w-md mx-auto relative">
                <form action="{{ route('posts.index') }}" method="GET">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari berita atau artikel..." class="w-full py-3 pl-5 pr-12 rounded-full bg-white/10 border border-white/20 text-white placeholder-blue-200 focus:bg-white/20 focus:outline-none focus:ring-2 focus:ring-unmaris-yellow transition">
                    <button type="submit" class="absolute right-2 top-1.5 p-1.5 bg-unmaris-yellow text-unmaris-blue rounded-full w-9 h-9 flex items-center justify-center hover:bg-white transition">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-6 py-12">

        {{-- HEADLINE NEWS (Jika tidak sedang search) --}}
        @if(!request('q') && $posts->onFirstPage() && $headline)
        <div class="mb-16">
            <div class="group relative rounded-3xl overflow-hidden shadow-2xl aspect-video md:aspect-[21/9]">
                {{-- Image --}}
                <img src="{{ $headline->featured_image ? Storage::url($headline->featured_image) : 'https://placehold.co/1200x600/003366/FFFFFF/png?text=UNMARIS+Headline' }}" class="absolute inset-0 w-full h-full object-cover transition duration-700 group-hover:scale-105">

                {{-- Overlay Gradient --}}
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent"></div>

                {{-- Content --}}
                <div class="absolute bottom-0 left-0 p-6 md:p-10 w-full md:w-2/3">
                    @if($headline->category)
                    <span class="inline-block px-3 py-1 rounded-md bg-unmaris-yellow text-unmaris-blue text-xs font-bold uppercase tracking-wider mb-3">
                        {{ $headline->category->name }}
                    </span>
                    @endif
                    <h2 class="text-3xl md:text-4xl font-extrabold text-white leading-tight mb-4 group-hover:text-unmaris-yellow transition">
                        <a href="{{ route('public.posts.show', $headline->slug) }}">
                            {{ $headline->title }}
                        </a>
                    </h2>
                    <p class="text-gray-300 text-sm md:text-base mb-6 line-clamp-2 hidden md:block">
                        {!! Str::limit(strip_tags($headline->content), 150) !!}
                    </p>

                    <div class="flex items-center text-white/70 text-sm space-x-4">
                        <span class="flex items-center"><i class="far fa-user mr-2"></i> {{ $headline->user->name ?? 'Admin' }}</span>
                        <span class="flex items-center"><i class="far fa-clock mr-2"></i> {{ $headline->published_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- MAIN GRID & SIDEBAR --}}
        <div class="grid lg:grid-cols-4 gap-10">

            {{-- KONTEN BERITA (3 Kolom) --}}
            <div class="lg:col-span-3">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-800">
                        @if(request('q'))
                        Hasil Pencarian: "{{ request('q') }}"
                        @else
                        Berita Terbaru
                        @endif
                    </h3>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($posts as $post)
                    {{-- Skip headline jika di halaman pertama --}}
                    @if(!request('q') && $posts->onFirstPage() && $post->id === $headline->id) @continue @endif

                    <article class="flex flex-col h-full bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition duration-300 group">
                        {{-- Thumbnail --}}
                        <a href="{{ route('public.posts.show', $post->slug) }}" class="relative h-48 overflow-hidden">
                            <img src="{{ $post->featured_image ? Storage::url($post->featured_image) : 'https://placehold.co/600x400/003366/FFFFFF/png?text=UNMARIS' }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                            @if($post->category)
                            <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-md text-xs font-bold text-unmaris-blue uppercase">
                                {{ $post->category->name }}
                            </div>
                            @endif
                        </a>

                        {{-- Body --}}
                        <div class="p-5 flex flex-col flex-grow">
                            <div class="flex items-center text-xs text-gray-500 mb-3 space-x-2">
                                <i class="far fa-calendar-alt"></i>
                                <span>{{ optional($post->published_at)->format('d M Y') }}</span>
                            </div>

                            <h4 class="text-lg font-bold text-gray-900 mb-3 leading-snug group-hover:text-unmaris-blue transition line-clamp-2">
                                <a href="{{ route('public.posts.show', $post->slug) }}">
                                    {{ $post->title }}
                                </a>
                            </h4>

                            <p class="text-gray-600 text-sm line-clamp-3 mb-4 flex-grow">
                                {!! Str::limit(strip_tags($post->content), 100) !!}
                            </p>
                            <a href="{{ route('public.posts.show', $post->slug) }}" class="inline-flex items-center text-sm font-bold text-unmaris-blue hover:text-unmaris-yellow transition mt-auto">
                                Baca Selengkapnya <i class="fas fa-arrow-right ml-2 text-xs"></i>
                            </a>
                        </div>
                    </article>
                    @empty
                    <div class="col-span-full text-center py-12 bg-gray-50 rounded-2xl">
                        <i class="far fa-newspaper text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">Tidak ada berita yang ditemukan.</p>
                    </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                <div class="mt-12">
                    {{ $posts->links('pagination::tailwind') }}
                </div>
            </div>

            {{-- SIDEBAR FILTER (1 Kolom) --}}
            <aside class="lg:col-span-1 space-y-8">

                {{-- Kategori Widget --}}
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100">
                    <h4 class="text-lg font-bold text-unmaris-blue mb-4 pb-2 border-b border-gray-100">
                        Kategori
                    </h4>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('public.posts.index') }}" class="flex justify-between items-center text-sm text-gray-600 hover:text-unmaris-blue hover:bg-blue-50 px-3 py-2 rounded-lg transition {{ !request('category') ? 'font-bold text-unmaris-blue bg-blue-50' : '' }}">
                                <span>Semua Berita</span>
                            </a>
                        </li>
                        @foreach($categories as $cat)
                        <li>
                            <a href="{{ route('public.posts.category', ['slug' => $cat->slug]) }}" class="flex justify-between items-center text-sm text-gray-600 hover:text-unmaris-blue hover:bg-blue-50 px-3 py-2 rounded-lg transition {{ request('category') == $cat->slug ? 'font-bold text-unmaris-blue bg-blue-50' : '' }}">
                                <span>{{ $cat->name }}</span>
                                <span class="bg-gray-100 text-gray-500 text-xs px-2 py-0.5 rounded-full">{{ $cat->posts_count }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Banner PMB Kecil --}}
                <div class="bg-unmaris-blue rounded-2xl p-6 text-center text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-unmaris-yellow/20 rounded-full blur-2xl -mr-10 -mt-10"></div>
                    <h4 class="text-xl font-bold mb-2 relative z-10">Daftar Sekarang!</h4>
                    <p class="text-sm text-blue-100 mb-4 relative z-10">Bergabunglah menjadi bagian dari generasi maritim unggul.</p>
                    <a href="/pmb" class="inline-block w-full py-2 bg-unmaris-yellow text-unmaris-blue font-bold rounded-lg hover:bg-white transition relative z-10">
                        Info PMB 2025
                    </a>
                </div>

            </aside>

        </div>
    </div>

</x-layouts.public>
