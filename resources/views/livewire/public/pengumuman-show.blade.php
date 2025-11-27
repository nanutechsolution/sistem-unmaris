        <div>
            <div class="relative h-[400px] md:h-[500px] bg-gray-900 w-full overflow-hidden">
                {{-- Background Image --}}
                @if ($pengumuman->thumbnail)
                    <img src="{{ asset('storage/' . $pengumuman->thumbnail) }}"
                        class="w-full h-full object-cover opacity-40 blur-sm scale-105 transform">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-unmaris-blue to-gray-900 opacity-90">
                        <div
                            class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-20">
                        </div>
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent"></div>
                <div class="absolute bottom-0 left-0 w-full p-6 md:p-12 max-w-7xl mx-auto z-10">
                    {{-- Breadcrumb --}}
                    <nav class="flex text-sm text-gray-300 mb-6 space-x-2 font-medium">
                        <a href="/" class="hover:text-unmaris-yellow transition">Home</a>
                        <span>/</span>
                        <a href="{{ route('public.pengumuman.index') }}"
                            class="hover:text-unmaris-yellow transition">Kabar
                            Kampus</a>
                        <span>/</span>
                        <span class="text-white truncate max-w-[150px] md:max-w-xs">{{ $pengumuman->judul }}</span>
                    </nav>

                    <span
                        class="bg-unmaris-yellow text-unmaris-blue px-3 py-1 rounded-md text-xs font-bold uppercase tracking-wide mb-4 inline-block shadow-lg">
                        {{ $pengumuman->kategori }}
                    </span>

                    <h1
                        class="text-3xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-6 drop-shadow-lg max-w-4xl">
                        {{ $pengumuman->judul }}
                    </h1>

                    <div
                        class="flex flex-wrap items-center gap-6 text-gray-300 text-sm font-medium border-t border-gray-700 pt-6">
                        <div class="flex items-center">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($pengumuman->penulis) }}&background=EBF4FF&color=003366"
                                class="w-8 h-8 rounded-full mr-3 border border-gray-500">
                            <span>{{ $pengumuman->penulis }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="far fa-calendar-alt mr-2 text-unmaris-yellow"></i>
                            {{ $pengumuman->published_at->translatedFormat('l, d F Y') }}
                        </div>
                        <div class="flex items-center">
                            <i class="far fa-eye mr-2 text-unmaris-yellow"></i>
                            {{ $pengumuman->views }}x Dibaca
                        </div>
                    </div>
                </div>
            </div>
            {{-- 2. MAIN CONTENT --}}
            <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 lg:grid-cols-12 gap-12 -mt-15  relative z-20">
                {{-- KOLOM KIRI: ARTIKEL (8 Kolom) --}}
                <div class="lg:col-span-8 bg-white rounded-2xl shadow-xl p-8 md:p-12">
                    {{-- Ringkasan (Lead Paragraph) --}}
                    @if ($pengumuman->ringkasan)
                        <div
                            class="bg-blue-50 border-l-4 border-unmaris-blue p-6 mb-8 rounded-r-lg italic text-gray-700 text-lg leading-relaxed">
                            "{{ $pengumuman->ringkasan }}"
                        </div>
                    @endif

                    {{-- Isi Konten --}}
                    <article class="prose prose-lg prose-blue max-w-none text-gray-700 leading-relaxed font-sans">
                        {!! $pengumuman->konten !!}
                    </article>

                    {{-- Lampiran PDF --}}
                    @if ($pengumuman->file_lampiran)
                        <div
                            class="mt-12 p-6 bg-gray-50 border border-gray-200 rounded-2xl flex flex-col md:flex-row items-center justify-between gap-4 group hover:border-unmaris-blue transition duration-300">
                            <div class="flex items-center gap-4 w-full">
                                <div
                                    class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center text-red-600 shrink-0 group-hover:scale-110 transition">
                                    <i class="fas fa-file-pdf text-2xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800 group-hover:text-unmaris-blue transition">Dokumen
                                        Lampiran</h4>
                                    <p class="text-xs text-gray-500">Unduh detail lengkap mengenai pengumuman ini.</p>
                                </div>
                            </div>
                            <a href="{{ asset('storage/' . $pengumuman->file_lampiran) }}" target="_blank"
                                class="w-full md:w-auto px-6 py-3 bg-white border border-gray-300 text-gray-700 rounded-xl font-bold text-sm hover:bg-unmaris-blue hover:text-white hover:border-unmaris-blue transition shadow-sm whitespace-nowrap flex items-center justify-center gap-2">
                                <i class="fas fa-download"></i> Download PDF
                            </a>
                        </div>
                    @endif

                    {{-- Share Buttons --}}
                    <div class="mt-12 pt-8 border-t border-gray-100">
                        <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Bagikan Informasi Ini
                        </h4>
                        <div class="flex gap-3">
                            <a href="https://wa.me/?text={{ urlencode($pengumuman->judul . ' ' . url()->current()) }}"
                                target="_blank"
                                class="flex-1 bg-[#25D366] text-white py-3 rounded-xl font-bold text-center hover:opacity-90 transition flex items-center justify-center gap-2">
                                <i class="fab fa-whatsapp text-lg"></i> <span class="hidden sm:inline">WhatsApp</span>
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                target="_blank"
                                class="flex-1 bg-[#1877F2] text-white py-3 rounded-xl font-bold text-center hover:opacity-90 transition flex items-center justify-center gap-2">
                                <i class="fab fa-facebook text-lg"></i> <span class="hidden sm:inline">Facebook</span>
                            </a>
                            <button
                                onclick="navigator.clipboard.writeText(window.location.href); alert('Link berhasil disalin!')"
                                class="flex-none bg-gray-100 text-gray-600 w-12 rounded-xl font-bold hover:bg-gray-200 transition flex items-center justify-center"
                                title="Salin Link">
                                <i class="fas fa-link"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: SIDEBAR (4 Kolom) --}}
                <div class="lg:col-span-4 space-y-8">

                    {{-- Widget: Penulis --}}
                    <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-16 h-16 bg-unmaris-blue/5 rounded-full flex items-center justify-center text-unmaris-blue text-2xl border-2 border-white shadow-md">
                                <i class="fas fa-user-shield"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase font-bold tracking-wider">Diposting Oleh</p>
                                <h4 class="font-bold text-gray-800 text-lg">{{ $pengumuman->penulis }}</h4>
                                <p class="text-xs text-unmaris-blue">Admin Universitas</p>
                            </div>
                        </div>
                    </div>

                    {{-- Widget: Berita Terkait (Sticky) --}}
                    <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 sticky top-28">
                        <h3 class="font-bold text-xl mb-6 flex items-center text-gray-800">
                            <span class="w-1 h-6 bg-unmaris-yellow rounded-full mr-3"></span>
                            Berita Terkait
                        </h3>

                        <div class="space-y-6">
                            @foreach ($terkaits as $item)
                                <a href="{{ route('public.pengumuman.show', $item->slug) }}"
                                    class="group flex gap-4 items-start">
                                    {{-- Thumbnail Mini --}}
                                    <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden shrink-0 relative">
                                        @if ($item->thumbnail)
                                            <img src="{{ asset('storage/' . $item->thumbnail) }}"
                                                class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                                        @else
                                            <div
                                                class="w-full h-full flex items-center justify-center text-gray-300 bg-gray-50">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        @endif
                                    </div>

                                    <div>
                                        <span
                                            class="text-[10px] font-bold text-unmaris-blue uppercase mb-1 block">{{ $item->kategori }}</span>
                                        <h4
                                            class="font-bold text-sm text-gray-800 group-hover:text-unmaris-blue transition line-clamp-2 leading-snug">
                                            {{ $item->judul }}
                                        </h4>
                                        <span class="text-xs text-gray-400 mt-1 block">
                                            {{ $item->published_at->format('d M Y') }}
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-100">
                            <a href="{{ route('public.pengumuman.index') }}"
                                class="block w-full py-3 bg-gray-50 text-gray-600 font-bold text-center rounded-xl hover:bg-unmaris-blue hover:text-white transition text-sm">
                                Lihat Semua Berita
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
