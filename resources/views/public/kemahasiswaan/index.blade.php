<x-layouts.public title="Kemahasiswaan & Alumni">

    {{-- 1. HERO SECTION --}}
    <section class="bg-unmaris-blue text-white pt-32 pb-24 relative overflow-hidden">
        {{-- Background Image Overlay --}}
        <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')]"></div>
        <div class="absolute right-0 bottom-0 w-1/2 h-full bg-gradient-to-l from-unmaris-yellow/20 to-transparent skew-x-12 transform translate-x-20"></div>
        
        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-white/10 border border-white/20 text-unmaris-yellow text-xs font-bold tracking-widest uppercase mb-4 backdrop-blur-md">
                Student Life
            </span>
            <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight leading-tight mb-6">
                Aktif, Kreatif, & <br> <span class="text-unmaris-yellow">Berprestasi.</span>
            </h1>
            <p class="text-blue-100 text-lg max-w-2xl mx-auto leading-relaxed">
                Kampus bukan hanya tempat belajar, tapi ruang untuk bertumbuh. Temukan komunitasmu dan kembangkan potensimu di sini.
            </p>
        </div>
    </section>

    {{-- 2. ORGANISASI MAHASISWA (UKM) --}}
    <section class="py-20 bg-gray-50 -mt-12 relative z-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-extrabold text-gray-900">Unit Kegiatan Mahasiswa (UKM)</h2>
                    <p class="text-gray-500 mt-2">Salurkan bakat dan minatmu melalui berbagai organisasi resmi kampus.</p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($ukms as $ukm)
                        <div class="group relative bg-white border border-gray-100 p-6 rounded-2xl hover:shadow-lg hover:-translate-y-1 transition duration-300 overflow-hidden">
                            {{-- Accent Bar (Gunakan kolom 'warna' dari database) --}}
                            <div class="absolute top-0 left-0 w-full h-1 {{ $ukm->warna }}"></div>
                            
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-xl {{ $ukm->warna }} text-white flex items-center justify-center text-xl shadow-md group-hover:scale-110 transition">
                                    <i class="{{ $ukm->icon }}"></i>
                                </div>
                                <div>
                                    <span class="text-[10px] font-bold uppercase tracking-wide text-gray-400">{{ $ukm->kategori }}</span>
                                    <h3 class="text-lg font-bold text-gray-800 mb-1 group-hover:text-unmaris-blue transition">{{ $ukm->nama }}</h3>
                                    <p class="text-sm text-gray-500 leading-relaxed line-clamp-2">
                                        {{ $ukm->deskripsi }}
                                    </p>
                                </div>
                            </div>
                            
                            <div class="mt-4 pt-4 border-t border-gray-50 flex justify-end">
                                <a href="#" class="text-xs font-bold text-gray-400 hover:text-unmaris-blue flex items-center">
                                    Gabung Sekarang <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-10 text-gray-400">
                            <i class="fas fa-users-slash text-4xl mb-2"></i>
                            <p>Belum ada data UKM.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    {{-- 3. WALL OF FAME (PRESTASI) --}}
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-4">
                <div>
                    <h2 class="text-3xl font-extrabold text-unmaris-blue mb-2">Wall of Fame</h2>
                    <p class="text-gray-500">Hall of Fame mahasiswa berprestasi terbaru.</p>
                </div>
                <a href="{{ route('public.prestasi.index') }}" class="px-6 py-2 border border-gray-300 rounded-full text-sm font-bold text-gray-600 hover:bg-unmaris-blue hover:text-white hover:border-unmaris-blue transition">
                    Lihat Arsip Prestasi
                </a>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                @forelse($prestasi as $p)
                    {{-- Gunakan Link ke Detail Prestasi --}}
                    <a href="{{ route('public.prestasi.show', $p->id) }}" class="group relative rounded-2xl overflow-hidden cursor-pointer block h-64">
                        {{-- Gambar (Gunakan Accessor Model Achievement) --}}
                        <img src="{{ $p->image_url }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent opacity-80 group-hover:opacity-90 transition"></div>
                        
                        <div class="absolute bottom-0 left-0 p-6 text-white translate-y-2 group-hover:translate-y-0 transition duration-300 w-full">
                            <div class="flex justify-between items-center mb-2">
                                <div class="bg-unmaris-yellow text-unmaris-blue text-[10px] font-bold px-2 py-1 rounded w-fit uppercase">
                                    {{ $p->medal == 'Participant' ? 'Sertifikat' : 'Juara' }}
                                </div>
                                <span class="text-[10px] bg-white/20 px-2 py-1 rounded backdrop-blur-sm">{{ $p->category }}</span>
                            </div>
                            
                            {{-- Judul Prestasi --}}
                            <h3 class="text-lg font-bold leading-tight mb-1 line-clamp-2 group-hover:text-unmaris-yellow transition">
                                {{ $p->title }}
                            </h3>
                            {{-- Nama Pemenang --}}
                            <p class="text-sm text-gray-300 truncate">{{ $p->winner_name }}</p>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-10 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                        <p class="text-gray-400">Belum ada data prestasi terbaru.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- 4. ALUMNI TRACER (CTA) --}}
    <section class="py-20 bg-unmaris-blue relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-unmaris-yellow/10 rounded-full blur-3xl -mr-10 -mt-10"></div>
        
        <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
            <i class="fas fa-user-graduate text-5xl text-unmaris-yellow mb-6"></i>
            <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-4">Alumni UNMARIS?</h2>
            <p class="text-blue-100 text-lg mb-8">
                Bantu kami meningkatkan kualitas pendidikan dengan mengisi Tracer Study. Kontribusi Anda sangat berarti bagi pengembangan kampus tercinta.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="#" class="px-8 py-3 bg-unmaris-yellow text-unmaris-blue font-bold rounded-full hover:bg-white transition shadow-lg">
                    Isi Tracer Study
                </a>
                <a href="#" class="px-8 py-3 border border-white/30 text-white font-bold rounded-full hover:bg-white/10 transition">
                    Info Karir & Loker
                </a>
            </div>
        </div>
    </section>

</x-layouts.public>