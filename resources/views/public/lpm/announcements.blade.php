<x-layouts.public title="Daftar Pengumuman Mutu">

    {{-- HEADER SECTION (Konsisten dengan Halaman LPM Lainnya) --}}
    <section class="bg-unmaris-blue text-white pt-28 pb-24 relative overflow-hidden">
        {{-- Dekorasi Background --}}
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-unmaris-yellow/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 rounded-full bg-white/10 blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <nav class="flex justify-center text-sm text-unmaris-yellow/80 mb-4 font-medium">
                <a href="{{ route('public.lpm.index') }}" class="hover:text-white transition">LPM</a>
                <span class="mx-2">/</span>
                <span class="text-white">Arsip Pengumuman</span>
            </nav>

            <h1 class="text-3xl md:text-5xl font-extrabold mb-4 tracking-tight">
                Pengumuman & Informasi
            </h1>

            <p class="text-blue-100 font-medium max-w-2xl mx-auto text-lg leading-relaxed">
                Pembaruan terkini mengenai kebijakan, audit mutu, dan kegiatan internal LPM UNMARIS.
            </p>
        </div>
    </section>

    {{-- MAIN CONTENT GRID (Overlapping Layout) --}}
    <div class="max-w-7xl mx-auto px-6 pb-16 grid lg:grid-cols-3 gap-10 -mt-12 relative z-20">

        {{-- LEFT SIDEBAR (Filter & Search) --}}
        <aside class="lg:col-span-1 space-y-8">

            {{-- Search Widget --}}
            <div class="bg-white p-6 rounded-2xl shadow-xl border-t-4 border-unmaris-blue lg:sticky lg:top-24">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-search text-unmaris-blue mr-2"></i> Cari Pengumuman
                </h3>

                {{-- Form Pencarian --}}
                <form action="{{ route('public.lpm.announcements.index') }}" method="GET">
                    <div class="relative mb-4">
                        <input type="text" name="q" value="{{ request('q') }}"
                            placeholder="Kata kunci judul..."
                            class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-unmaris-blue/20 focus:border-unmaris-blue transition text-sm text-gray-700">
                        <i class="fas fa-search absolute left-3.5 top-3.5 text-gray-400"></i>
                    </div>

                    <button type="submit"
                        class="w-full bg-unmaris-blue text-white font-bold py-2.5 rounded-xl hover:bg-unmaris-yellow hover:text-unmaris-blue transition shadow-md text-sm">
                        Terapkan Filter
                    </button>

                    @if (request('q'))
                        <a href="{{ route('public.lpm.announcements.index') }}"
                            class="block text-center mt-3 text-xs font-bold text-gray-500 hover:text-red-500">
                            <i class="fas fa-times mr-1"></i> Reset Pencarian
                        </a>
                    @endif
                </form>
            </div>

            {{-- Info Widget --}}
            <div class="bg-blue-50 p-6 rounded-2xl border border-blue-100 hidden lg:block">
                <h4 class="font-bold text-unmaris-blue mb-2 flex items-center">
                    <i class="fas fa-rss mr-2"></i> Info Terbaru
                </h4>
                <p class="text-sm text-gray-600 mb-4 leading-relaxed">
                    Pantau halaman ini secara berkala untuk mendapatkan informasi jadwal Audit Mutu Internal (AMI) dan
                    Rapat Tinjauan Manajemen (RTM).
                </p>
            </div>

        </aside>

        {{-- RIGHT CONTENT (Announcement List) --}}
        <div class="lg:col-span-2">
            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-xl border border-gray-100">

                <div class="flex justify-between items-center mb-8 border-b border-gray-100 pb-4">
                    <h2 class="text-2xl font-extrabold text-gray-800">
                        @if (request('q'))
                            Hasil Pencarian: "{{ request('q') }}"
                        @else
                            Daftar Pengumuman
                        @endif
                    </h2>
                    <span class="bg-gray-100 text-gray-600 text-xs font-bold px-3 py-1 rounded-full">
                        {{ $announcements->total() }} Item
                    </span>
                </div>

                <div class="space-y-6">
                    @forelse($announcements as $ann)
                        <div
                            class="group relative bg-white border border-gray-200 rounded-xl p-5 hover:shadow-lg hover:border-unmaris-blue/30 transition duration-300">
                            <div class="flex flex-col sm:flex-row gap-5">
                                {{-- Date Box Visual --}}
                                <div class="flex-shrink-0 sm:w-20 text-center">
                                    <div
                                        class="bg-blue-50 rounded-lg p-2 border border-blue-100 group-hover:bg-unmaris-blue group-hover:border-unmaris-blue transition duration-300">
                                        <span
                                            class="block text-2xl font-extrabold text-unmaris-blue group-hover:text-white transition leading-none mb-1">
                                            {{ optional($ann->published_at)->format('d') }}
                                        </span>
                                        <span
                                            class="block text-[10px] font-bold text-unmaris-blue/70 uppercase group-hover:text-white/80 transition">
                                            {{ optional($ann->published_at)->format('M Y') }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Content --}}
                                <div class="flex-grow">
                                    <h3
                                        class="text-lg font-bold text-gray-800 mb-2 group-hover:text-unmaris-blue transition leading-tight">
                                        <a href="{{ route('public.lpm.announcement.show', $ann->slug) }}">
                                            {{ $ann->title }}
                                        </a>
                                        {{-- New Badge jika kurang dari 7 hari --}}
                                        @if ($ann->published_at && $ann->published_at->diffInDays(now()) < 7)
                                            <span
                                                class="ml-2 inline-block bg-red-100 text-red-600 text-[10px] px-2 py-0.5 rounded font-bold align-middle animate-pulse">BARU</span>
                                        @endif
                                    </h3>

                                    <div class="text-sm text-gray-600 mb-4 line-clamp-2">
                                        {!! Str::limit(strip_tags($ann->content), 180) !!}
                                    </div>

                                    <div class="flex items-center justify-between mt-auto pt-3 border-t border-gray-50">
                                        <div class="flex items-center text-xs text-gray-400">
                                            <i class="far fa-user mr-1.5"></i> {{ $ann->poster->name ?? 'Admin LPM' }}
                                        </div>
                                        <a href="{{ route('public.lpm.announcement.show', $ann->slug) }}"
                                            class="text-sm font-bold text-unmaris-blue hover:text-unmaris-yellow transition flex items-center group-hover/link">
                                            Baca Detail <i
                                                class="fas fa-arrow-right ml-1.5 text-xs transform group-hover:translate-x-1 transition"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                            <div
                                class="bg-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm text-gray-300 text-3xl">
                                <i class="far fa-folder-open"></i>
                            </div>
                            <p class="text-gray-500 font-medium">Tidak ada pengumuman ditemukan.</p>
                            @if (request('q'))
                                <p class="text-sm text-gray-400 mt-1">Coba kata kunci lain atau reset pencarian.</p>
                            @endif
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                <div class="mt-10 pt-6 border-t border-gray-100">
                    {{ $announcements->onEachSide(1)->links('pagination::tailwind') }}
                </div>
            </div>
        </div>

    </div>
</x-layouts.public>
