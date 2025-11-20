<x-layouts.public title="LPPM — Penelitian & Pengabdian">

    {{-- 1. HERO SECTION --}}
    <section class="bg-unmaris-blue text-white pt-32 pb-24 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/circuit.png')]"></div>
        <div class="absolute top-0 left-0 -ml-20 -mt-20 w-96 h-96 rounded-full bg-white/10 blur-3xl"></div>
        
        <div class="max-w-7xl mx-auto px-6 relative z-10 flex flex-col md:flex-row items-center gap-10">
            <div class="md:w-1/2">
                <span class="inline-block py-1 px-3 rounded-full bg-white/20 border border-white/30 text-unmaris-yellow text-xs font-bold tracking-widest uppercase mb-4">
                    Research & Community Service
                </span>
                <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight leading-tight mb-6">
                    Inovasi untuk <br> <span class="text-unmaris-yellow">Negeri</span>
                </h1>
                <p class="text-blue-100 text-lg leading-relaxed mb-8">
                    Lembaga Penelitian dan Pengabdian kepada Masyarakat (LPPM) UNMARIS berdedikasi mengembangkan ilmu pengetahuan yang berdampak nyata bagi masyarakat pesisir.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="#jurnal" class="px-8 py-3 bg-unmaris-yellow text-unmaris-blue font-bold rounded-full hover:bg-white transition shadow-lg">
                        Akses E-Journal
                    </a>
                    <a href="#kkn" class="px-8 py-3 border border-white/30 text-white font-bold rounded-full hover:bg-white/10 transition">
                        Info KKN
                    </a>
                </div>
            </div>
            
            {{-- Stats Grid (Floating) --}}
            <div class="md:w-1/2 grid grid-cols-2 gap-4">
                <div class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-white/20 text-center">
                    <span class="block text-4xl font-extrabold text-white mb-1">150+</span>
                    <span class="text-xs text-blue-200 uppercase tracking-wider">Judul Penelitian</span>
                </div>
                <div class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-white/20 text-center">
                    <span class="block text-4xl font-extrabold text-unmaris-yellow mb-1">45</span>
                    <span class="text-xs text-blue-200 uppercase tracking-wider">Desa Binaan</span>
                </div>
                <div class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-white/20 text-center">
                    <span class="block text-4xl font-extrabold text-white mb-1">20+</span>
                    <span class="text-xs text-blue-200 uppercase tracking-wider">HKI Terdaftar</span>
                </div>
                <div class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-white/20 text-center">
                    <span class="block text-4xl font-extrabold text-unmaris-yellow mb-1">5</span>
                    <span class="text-xs text-blue-200 uppercase tracking-wider">Jurnal Terakreditasi</span>
                </div>
            </div>
        </div>
    </section>

    {{-- 2. E-JOURNAL GATEWAY --}}
    <section id="jurnal" class="py-20 bg-gray-50 -mt-10 relative z-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900">Portal Jurnal Ilmiah (OJS)</h2>
                <p class="text-gray-500 mt-2">Publikasi hasil riset civitas akademika UNMARIS.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                @foreach($journals as $journal)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden group hover:-translate-y-2 transition duration-300 border border-gray-100">
                        <div class="h-32 {{ $journal['cover_color'] }} relative flex items-center justify-center overflow-hidden">
                            <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition"></div>
                            <i class="fas fa-book-open text-white text-5xl opacity-50 group-hover:scale-110 transition duration-500"></i>
                            <span class="absolute top-4 right-4 bg-white text-gray-900 text-xs font-bold px-2 py-1 rounded shadow-sm">
                                {{ $journal['akreditasi'] }}
                            </span>
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-2 group-hover:text-unmaris-blue transition">
                                {{ $journal['nama'] }}
                            </h3>
                            <p class="text-xs text-gray-500 mb-4 uppercase tracking-wide font-bold">
                                Bidang: {{ $journal['bidang'] }}
                            </p>
                            <a href="{{ $journal['link'] }}" class="block w-full py-2 border border-gray-200 text-gray-600 text-center rounded-lg text-sm font-bold hover:bg-unmaris-blue hover:text-white hover:border-unmaris-blue transition">
                                Kunjungi Website <i class="fas fa-external-link-alt ml-1"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 3. RISET TERBARU & AGENDA --}}
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-3 gap-12">
            
            {{-- Daftar Penelitian --}}
            <div class="lg:col-span-2">
                <h3 class="text-2xl font-extrabold text-unmaris-blue mb-6 flex items-center">
                    <i class="fas fa-microscope mr-3"></i> Penelitian Terbaru
                </h3>
                <div class="space-y-4">
                    @foreach($researches as $riset)
                        <div class="flex flex-col sm:flex-row gap-4 p-5 border border-gray-100 rounded-xl hover:shadow-md transition hover:border-unmaris-blue/30 bg-white">
                            <div class="flex-shrink-0">
                                <div class="w-16 h-16 bg-blue-50 text-unmaris-blue rounded-lg flex items-center justify-center text-2xl font-bold border border-blue-100">
                                    {{ $riset['tahun'] }}
                                </div>
                            </div>
                            <div>
                                <span class="text-[10px] font-bold bg-gray-100 text-gray-600 px-2 py-1 rounded uppercase tracking-wide">
                                    {{ $riset['skema'] }}
                                </span>
                                <h4 class="text-lg font-bold text-gray-900 mt-2 mb-1 leading-snug">
                                    {{ $riset['judul'] }}
                                </h4>
                                <p class="text-sm text-gray-500">
                                    <i class="far fa-user mr-1"></i> Ketua: {{ $riset['ketua'] }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6">
                    <a href="#" class="text-sm font-bold text-unmaris-blue hover:text-unmaris-yellow transition">
                        Lihat Semua Penelitian &raquo;
                    </a>
                </div>
            </div>

            {{-- Sidebar Info --}}
            <div>
                <div class="bg-unmaris-blue text-white p-8 rounded-3xl shadow-xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-unmaris-yellow/20 rounded-full blur-2xl -mr-10 -mt-10"></div>
                    
                    <h3 class="text-xl font-bold mb-4 relative z-10">Sentra HKI</h3>
                    <p class="text-sm text-blue-100 mb-6 relative z-10">
                        Fasilitasi pendaftaran Hak Kekayaan Intelektual (Hak Cipta, Paten, Merek) bagi dosen dan mahasiswa.
                    </p>
                    
                    <div class="space-y-3 relative z-10">
                        <div class="flex items-center bg-white/10 p-3 rounded-lg">
                            <i class="fas fa-check-circle text-unmaris-yellow mr-3"></i>
                            <span class="text-sm font-bold">Penyusunan Draft Paten</span>
                        </div>
                        <div class="flex items-center bg-white/10 p-3 rounded-lg">
                            <i class="fas fa-check-circle text-unmaris-yellow mr-3"></i>
                            <span class="text-sm font-bold">Pendampingan Hak Cipta</span>
                        </div>
                    </div>

                    <a href="#" class="block mt-8 text-center bg-unmaris-yellow text-unmaris-blue font-bold py-3 rounded-xl hover:bg-white transition relative z-10">
                        Ajukan HKI
                    </a>
                </div>
            </div>

        </div>
    </section>

    {{-- 4. KKN & PENGABDIAN --}}
    <section id="kkn" class="py-24 bg-gray-900 text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-30 bg-[url('https://www.transparenttextures.com/patterns/wood-pattern.png')]"></div>
        
        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <h2 class="text-3xl md:text-4xl font-extrabold mb-4">Kuliah Kerja Nyata (KKN)</h2>
            <p class="text-gray-400 max-w-2xl mx-auto mb-12">
                Membangun desa, memberdayakan masyarakat. Program pengabdian mahasiswa UNMARIS tersebar di seluruh pelosok Sumba.
            </p>

            <div class="grid md:grid-cols-4 gap-4">
                <div class="group relative overflow-hidden rounded-2xl h-64">
                    <img src="https://placehold.co/400x600/222/fff?text=KKN+Desa+A" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent flex flex-col justify-end p-6">
                        <span class="text-unmaris-yellow text-xs font-bold uppercase">Desa Wisata</span>
                        <h4 class="font-bold text-lg">Pengembangan Ekowisata Mangrove</h4>
                    </div>
                </div>
                <div class="group relative overflow-hidden rounded-2xl h-64 md:col-span-2">
                    <img src="https://placehold.co/800x600/333/fff?text=Penyuluhan+Kesehatan" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent flex flex-col justify-end p-6">
                        <span class="text-unmaris-yellow text-xs font-bold uppercase">Kesehatan</span>
                        <h4 class="font-bold text-lg">Penyuluhan Gizi & Stunting</h4>
                    </div>
                </div>
                <div class="group relative overflow-hidden rounded-2xl h-64">
                    <img src="https://placehold.co/400x600/444/fff?text=Literasi+Digital" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent flex flex-col justify-end p-6">
                        <span class="text-unmaris-yellow text-xs font-bold uppercase">Teknologi</span>
                        <h4 class="font-bold text-lg">Pelatihan Komputer Desa</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-layouts.public>