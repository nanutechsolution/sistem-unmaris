<x-layouts.public title="Beranda — Universitas Stella Maris Sumba">

    {{-- 1. HERO SECTION (DYNAMIC SLIDER) --}}
    <section class="relative h-screen min-h-[600px] overflow-hidden bg-gray-900" x-data="heroSlider({{ $sliders->count() }})"
        x-init="initSlider()">

        {{-- LOOPING SLIDE --}}
        @foreach ($sliders as $index => $slide)
            <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
                x-show="active === {{ $index }}" x-transition:enter="transition ease-out duration-1000"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-1000" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0">

                {{-- A. MEDIA LAYER --}}
                <div class="absolute inset-0 z-0">
                    @if ($slide->type === 'video')
                        <video autoplay loop muted playsinline
                            poster="{{ $slide->poster_path ? Storage::url($slide->poster_path) : '' }}"
                            class="w-full h-full object-cover">
                            <source src="{{ $slide->media_url }}" type="video/mp4">
                        </video>
                    @else
                        <img src="{{ $slide->media_url }}" alt="{{ $slide->title }}" class="w-full h-full object-cover">
                    @endif

                    {{-- Overlay Gradient (Dipertebal di atas agar Navbar terbaca) --}}
                    <div
                        class="absolute inset-0 bg-gradient-to-b from-unmaris-blue/90 via-unmaris-blue/40 to-unmaris-blue/90">
                    </div>
                </div>

                {{-- B. CONTENT LAYER --}}
                {{-- PERBAIKAN: Tambah pt-20 agar konten turun sedikit, tidak ketabrak Navbar Fixed --}}
                <div class="relative z-10 flex h-full items-center justify-center text-center px-4 pt-20">
                    <div class="max-w-5xl mx-auto">

                        {{-- Badge --}}
                        <div x-show="active === {{ $index }}"
                            x-transition:enter="transition ease-out duration-700 delay-300"
                            x-transition:enter-start="opacity-0 -translate-y-4"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-unmaris-yellow text-sm font-bold tracking-wide mb-6">
                            <span class="relative flex h-3 w-3">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-unmaris-yellow opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-unmaris-yellow"></span>
                            </span>
                            UNMARIS UPDATE
                        </div>

                        {{-- Title --}}
                        <h1 x-show="active === {{ $index }}"
                            x-transition:enter="transition ease-out duration-700 delay-500"
                            x-transition:enter-start="opacity-0 translate-y-8"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="text-5xl md:text-7xl font-extrabold text-white tracking-tight leading-tight mb-6">
                            {!! $slide->title ?? 'Universitas Stella Maris' !!}
                        </h1>

                        {{-- Description --}}
                        <p x-show="active === {{ $index }}"
                            x-transition:enter="transition ease-out duration-700 delay-700"
                            x-transition:enter-start="opacity-0 translate-y-8"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="text-lg md:text-xl text-blue-100 max-w-2xl mx-auto mb-10 font-light">
                            {{ $slide->description }}
                        </p>

                        {{-- Button --}}
                        @if ($slide->button_text)
                            <div x-show="active === {{ $index }}"
                                x-transition:enter="transition ease-out duration-700 delay-900"
                                x-transition:enter-start="opacity-0 translate-y-8"
                                x-transition:enter-end="opacity-100 translate-y-0">
                                <a href="{{ $slide->button_url ?? '#' }}"
                                    class="px-8 py-4 bg-unmaris-yellow text-unmaris-blue font-bold text-lg rounded-full hover:bg-yellow-400 hover:scale-105 transition duration-300 shadow-lg shadow-yellow-500/20 inline-block">
                                    {{ $slide->button_text }}
                                </a>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        @endforeach

        {{-- NAVIGATION DOTS --}}
        @if ($sliders->count() > 1)
            <div class="absolute bottom-10 left-0 right-0 z-20 flex justify-center gap-3">
                @foreach ($sliders as $index => $slide)
                    <button @click="goToSlide({{ $index }})"
                        class="h-3 rounded-full transition-all duration-300"
                        :class="active === {{ $index }} ? 'bg-unmaris-yellow w-8' : 'bg-white/50 hover:bg-white w-3'">
                    </button>
                @endforeach
            </div>
        @endif
    </section>

    {{-- JANGAN LUPA: SCRIPT ALPINE HARUS ADA DI SINI ATAU DI LAYOUT --}}
    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('heroSlider', (totalSlides) => ({
                    active: 0,
                    total: totalSlides,
                    interval: null,
                    initSlider() {
                        if (this.total > 1) {
                            this.startInterval();
                        }
                    },
                    next() {
                        this.active = (this.active + 1) % this.total;
                    },
                    goToSlide(index) {
                        this.active = index;
                        this.resetInterval();
                    },
                    startInterval() {
                        this.interval = setInterval(() => {
                            this.next();
                        }, 7000);
                    },
                    resetInterval() {
                        clearInterval(this.interval);
                        this.startInterval();
                    }
                }))
            })
        </script>
    @endpush

    {{-- SCRIPT LOGIC SLIDER (Taruh di bawah section atau di stack scripts) --}}
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('heroSlider', (totalSlides) => ({
                active: 0,
                total: totalSlides,
                interval: null,

                initSlider() {
                    // Hanya auto-play jika slide lebih dari 1
                    if (this.total > 1) {
                        this.startInterval();
                    }
                },

                next() {
                    this.active = (this.active + 1) % this.total;
                },

                goToSlide(index) {
                    this.active = index;
                    this.resetInterval(); // Reset timer kalau user klik manual agar tidak bentrok
                },

                startInterval() {
                    this.interval = setInterval(() => {
                        this.next();
                    }, 7000); // Ganti slide setiap 7 Detik
                },

                resetInterval() {
                    clearInterval(this.interval);
                    this.startInterval();
                }
            }))
        })
    </script>

    {{-- 2. BENTO GRID STATS (Data Dinamis dari Controller) --}}
    <section class="py-24 bg-gray-50 relative">
        <div class="max-w-7xl mx-auto px-6">
            <div class="mb-12 text-center">
                <h2 class="text-unmaris-blue font-bold text-sm tracking-widest uppercase mb-2">Kenapa UNMARIS?</h2>
                <h3 class="text-3xl md:text-4xl font-extrabold text-gray-900">Keunggulan Kami dalam Angka</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 auto-rows-[180px]">

                {{-- Card 1: Akreditasi --}}
                <div
                    class="col-span-1 md:col-span-2 md:row-span-2 bg-unmaris-blue rounded-3xl p-6 sm:p-8 text-white flex flex-col justify-between relative overflow-hidden group hover:shadow-2xl transition duration-500">
                    <!-- Background Circle -->
                    <div
                        class="absolute top-0 right-0 w-64 h-64 sm:w-80 sm:h-80 bg-unmaris-yellow/10 rounded-full blur-3xl -mr-16 -mt-16 sm:-mr-20 sm:-mt-20 transition duration-700 group-hover:scale-110">
                    </div>

                    <!-- Content -->
                    <div class="relative z-10">
                        <div
                            class="bg-white/10 w-fit px-2 py-1 rounded-lg text-[10px] sm:text-xs font-bold mb-3 sm:mb-4 backdrop-blur-md border border-white/10">
                            INSTITUSI</div>
                        <h3 class="text-lg sm:text-xl opacity-90">Terakreditasi Nasional</h3>
                        <p class="text-3xl sm:text-5xl md:text-6xl font-extrabold mt-2 tracking-tight">
                            BAIK <br> <span class="text-unmaris-yellow">SEKALI</span>
                        </p>
                    </div>

                    <!-- Footer -->
                    <div
                        class="relative z-10 flex flex-col sm:flex-row justify-between items-start sm:items-end mt-4 sm:mt-0 gap-3 sm:gap-0">
                        <p class="text-xs sm:text-sm text-blue-200 max-w-full sm:max-w-xs">
                            Diakui oleh BAN-PT sebagai institusi pendidikan berkualitas tinggi.
                        </p>
                        <a href="{{ route('public.akreditasi.institusi') }}">
                            <div
                                class="w-10 h-10 sm:w-12 sm:h-12 bg-white/20 rounded-full flex items-center justify-center group-hover:bg-unmaris-yellow group-hover:text-unmaris-blue transition duration-300 self-end sm:self-auto">
                                <i
                                    class="fas fa-arrow-right transform -rotate-45 group-hover:rotate-0 transition duration-300"></i>
                            </div>
                        </a>
                    </div>
                </div>
                {{-- Card 2: Jumlah Prodi (DINAMIS) --}}
                <div
                    class="bg-white border border-gray-100 rounded-3xl p-6 flex flex-col justify-center items-center text-center hover:shadow-xl hover:-translate-y-1 transition duration-300">
                    {{-- Menggunakan variabel $totalProdi --}}
                    <span class="text-5xl font-extrabold text-unmaris-blue counter">{{ $totalProdi }}</span>
                    <span class="text-sm font-bold text-gray-500 mt-2 uppercase tracking-wider">Program Studi</span>
                </div>

                {{-- Card 3: Jumlah Fakultas (DINAMIS - Optional Layout) --}}
                <div
                    class="bg-gray-900 rounded-3xl p-6 flex flex-col justify-center items-center text-center hover:shadow-xl hover:-translate-y-1 transition duration-300 text-white">
                    <span class="text-5xl font-extrabold text-unmaris-yellow counter">{{ $totalFakultas }}</span>
                    <span class="text-sm font-bold text-gray-400 mt-2 uppercase tracking-wider">Fakultas</span>
                </div>

                {{-- Card 4: Lulusan --}}
                <div
                    class="bg-unmaris-yellow rounded-3xl p-6 flex flex-col justify-center items-center text-center hover:shadow-xl hover:-translate-y-1 transition duration-300 relative overflow-hidden">
                    <div class="absolute inset-0 bg-white/20 transform skew-x-12 -ml-10"></div>
                    <span class="text-5xl font-extrabold text-unmaris-blue relative z-10">90%</span>
                    <span
                        class="text-xs font-extrabold text-unmaris-blue/80 mt-2 uppercase tracking-wider relative z-10 max-w-[120px]">Lulusan
                        Bekerja < 6 Bulan</span>
                </div>

                {{-- Card 5: Quote --}}
                <div
                    class="md:col-span-2 bg-white border border-gray-100 rounded-3xl p-8 flex items-center gap-6 hover:shadow-xl transition duration-300">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 rounded-full bg-gray-200 overflow-hidden border-2 border-unmaris-yellow">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg"
                                class="w-full h-full object-cover">
                        </div>
                    </div>
                    <div>
                        <i class="fas fa-quote-left text-unmaris-yellow/50 text-2xl mb-2 block"></i>
                        <p class="text-gray-600 italic font-medium">"UNMARIS tidak hanya mengajarkan teori, tetapi
                            membentuk karakter kepemimpinan yang tangguh untuk dunia kerja."</p>
                        <p class="text-sm font-bold mt-3 text-unmaris-blue">— Andi Pratama, CEO Tech Sumba (Alumni 2018)
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 3. PROGRAM FINDER (IMPROVED UI) --}}
    <section class="py-24 bg-white relative overflow-hidden">
        {{-- Dekorasi Background Abstrak --}}
        <div
            class="absolute left-0 top-1/4 w-96 h-96 bg-blue-50/50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-pulse">
        </div>
        <div class="absolute right-0 bottom-1/4 w-96 h-96 bg-yellow-50/50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-pulse"
            style="animation-delay: 2s"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10">

            {{-- Header --}}
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-unmaris-blue font-bold text-sm tracking-widest uppercase mb-2">Akademik</h2>
                <h2 class="text-4xl font-extrabold text-gray-900 mb-4">
                    Temukan <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-unmaris-blue to-blue-600">Masa
                        Depanmu</span>
                </h2>
                <p class="text-gray-600 text-lg">
                    Pilih dari {{ $totalProdi ?? 'berbagai' }} Program Studi unggulan yang tersebar di
                    {{ $totalFakultas ?? 'beberapa' }} Fakultas kami.
                </p>
            </div>

            {{-- Grid Fakultas --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($faculties as $fakultas)
                    @php
                        // Logic Warna & Icon per Fakultas
                        $icon = 'fas fa-university';
                        $themeColor = 'text-unmaris-blue bg-blue-50 border-blue-100 group-hover:border-unmaris-blue';
                        $iconBg = 'bg-white text-unmaris-blue';

                        if (Str::contains($fakultas->nama_fakultas, 'Teknik', true)) {
                            $icon = 'fa-solid fa-laptop-code';
                            $themeColor = 'text-red-700 bg-red-50 border-red-100 group-hover:border-red-500';
                            $iconBg = 'bg-white text-red-600';
                        } elseif (Str::contains($fakultas->nama_fakultas, ['Ekonomi', 'Bisnis'], true)) {
                            $icon = 'fa-solid fa-chart-line';
                            $themeColor =
                                'text-yellow-800 bg-yellow-50 border-yellow-100 group-hover:border-unmaris-yellow';
                            $iconBg = 'bg-white text-yellow-600';
                        } elseif (Str::contains($fakultas->nama_fakultas, ['Kesehatan'], true)) {
                            $icon = 'fa-solid fa-hospital';
                            $themeColor = 'text-green-800 bg-green-50 border-green-100 group-hover:border-green-500';
                            $iconBg = 'bg-white text-green-600';
                        } elseif (Str::contains($fakultas->nama_fakultas, ['Guru', 'Pendidikan'], true)) {
                            $icon = 'fa-solid fa-graduation-cap';
                            $themeColor = 'text-blue-800 bg-blue-50 border-blue-100 group-hover:border-blue-500';
                            $iconBg = 'bg-white text-blue-600';
                        }
                    @endphp

                    <div
                        class="group relative flex flex-col bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-2xl transition-all duration-500 h-full overflow-hidden transform hover:-translate-y-2">

                        {{-- Watermark Icon (Background) --}}
                        <div
                            class="absolute -top-6 -right-6 opacity-[0.03] group-hover:opacity-[0.08] transition-opacity duration-500 transform rotate-12">
                            <i class="{{ $icon }} text-9xl"></i>
                        </div>

                        {{-- Card Body --}}
                        <div class="p-8 flex-1 flex flex-col relative">

                            {{-- Icon Header --}}
                            <div
                                class="w-16 h-16 {{ $themeColor }} border rounded-2xl flex items-center justify-center text-3xl mb-6 shadow-sm group-hover:scale-110 transition duration-500">
                                <i class="{{ $icon }}"></i>
                            </div>

                            <h3 class="text-2xl font-bold text-gray-900 mb-2 group-hover:text-unmaris-blue transition">
                                {{ $fakultas->nama_fakultas }}
                            </h3>

                            <div
                                class="w-12 h-1 bg-gray-200 rounded-full mb-6 group-hover:bg-unmaris-yellow transition duration-500">
                            </div>

                            {{-- List Prodi --}}
                            <div class="space-y-3 flex-1">
                                @forelse($fakultas->programStudis as $prodi)
                                    <a href="{{ route('public.fakultas.prodi.show', $prodi->id) }}"
                                        class="flex items-center group/item p-2 -mx-2 rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                        <div
                                            class="flex-shrink-0 w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-[10px] font-bold text-gray-500 group-hover/item:bg-unmaris-blue group-hover/item:text-white transition mr-3">
                                            {{ $prodi->jenjang }}
                                        </div>
                                        <span
                                            class="text-sm text-gray-600 font-medium group-hover/item:text-gray-900 group-hover/item:translate-x-1 transition-transform">
                                            {{ $prodi->nama_prodi }}
                                        </span>
                                    </a>
                                @empty
                                    <div
                                        class="text-sm text-gray-400 italic flex items-center bg-gray-50 p-3 rounded-lg">
                                        <i class="fas fa-info-circle mr-2"></i> Belum ada prodi terdaftar.
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        {{-- Footer Action --}}
                        <a href="{{ route('public.fakultas.show', $fakultas->id) }}"
                            class="block p-4 bg-gray-50 border-t border-gray-100 text-center text-sm font-bold text-gray-500 hover:bg-unmaris-blue hover:text-white transition duration-300 group/btn">
                            Jelajahi Fakultas
                            <i
                                class="fas fa-arrow-right ml-2 transform group-hover/btn:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                @endforeach
            </div>

        </div>
    </section>


    {{-- 5. BERITA TERBARU SECTION --}}
    <section class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-6">

            {{-- Header Section --}}
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-4">
                <div>
                    <h2 class="text-unmaris-blue font-bold text-sm tracking-widest uppercase mb-2">Kabar Kampus</h2>
                    <h3 class="text-3xl md:text-4xl font-extrabold text-gray-900">Berita & Artikel Terbaru</h3>
                </div>
                <a href="{{ route('public.posts.index') }}"
                    class="group inline-flex items-center font-bold text-unmaris-blue hover:text-unmaris-yellow transition">
                    Lihat Semua Berita
                    <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>

            {{-- Grid Berita --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($berita_terbaru as $post)
                    <article
                        class="group flex flex-col h-full bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden hover:-translate-y-1">

                        {{-- Thumbnail --}}
                        <a href="{{ route('public.posts.show', $post->slug) }}"
                            class="relative h-48 overflow-hidden block">
                            @if ($post->featured_image)
                                <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}"
                                    class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700">
                            @else
                                <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400">
                                    <i class="far fa-image text-4xl"></i>
                                </div>
                            @endif

                            {{-- Badge Kategori --}}
                            @if ($post->category)
                                <span
                                    class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-lg text-xs font-bold text-unmaris-blue uppercase shadow-sm">
                                    {{ $post->category->name }}
                                </span>
                            @endif
                        </a>

                        {{-- Content --}}
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="flex items-center text-xs text-gray-500 mb-3 space-x-3">
                                <span class="flex items-center"><i
                                        class="far fa-calendar-alt mr-1.5 text-unmaris-yellow"></i>
                                    {{ $post->published_at->format('d M Y') }}</span>
                                @if ($post->author)
                                    <span class="flex items-center"><i
                                            class="far fa-user mr-1.5 text-unmaris-yellow"></i>
                                        {{ $post->author->name }}</span>
                                @endif
                            </div>

                            <h3
                                class="text-xl font-bold text-gray-900 mb-3 leading-tight group-hover:text-unmaris-blue transition line-clamp-2">
                                <a href="{{ route('public.posts.show', $post->slug) }}">
                                    {{ $post->title }}
                                </a>
                            </h3>

                            <p class="text-gray-600 text-sm line-clamp-3 mb-4 flex-grow leading-relaxed">
                                {{ Str::limit(strip_tags($post->content), 120) }}
                            </p>

                            <div class="pt-4 border-t border-gray-50 mt-auto">
                                <a href="{{ route('public.posts.show', $post->slug) }}"
                                    class="inline-flex items-center text-sm font-bold text-unmaris-blue hover:text-unmaris-yellow transition">
                                    Baca Selengkapnya <i class="fas fa-long-arrow-alt-right ml-2"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div
                        class="col-span-full text-center py-16 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                        <i class="far fa-newspaper text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500">Belum ada berita terbaru.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </section>


    {{-- 6. PENGUMUMAN & CTA (INFO PENTING) --}}
    <section class="py-24 bg-unmaris-blue text-white relative overflow-hidden">
        {{-- Pattern Background --}}
        <div class="absolute top-0 left-0 w-full h-full opacity-10"
            style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>

        <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-16 items-center relative z-10">

            {{-- KOLOM KIRI: CTA PMB (Ajakan Bertindak) --}}
            <div>
                <div
                    class="inline-block px-3 py-1 rounded-full bg-unmaris-yellow/20 border border-unmaris-yellow/30 text-unmaris-yellow text-xs font-bold uppercase tracking-wider mb-4">
                    Penerimaan Mahasiswa Baru
                </div>
                <h2 class="text-4xl font-extrabold mb-6 leading-tight">
                    Masa Depan Gemilang <br> <span class="text-unmaris-yellow">Dimulai Di Sini.</span>
                </h2>
                <p class="text-blue-100 text-lg mb-8 leading-relaxed">
                    Bergabunglah dengan komunitas akademis yang dinamis. Dapatkan beasiswa prestasi hingga 100% untuk
                    pendaftar gelombang pertama.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="https://pmb.unmarissumba.ac.id" target="_blank" rel="noopener noreferrer"
                        class="px-8 py-3 bg-unmaris-yellow text-unmaris-blue font-bold rounded-full hover:bg-white hover:scale-105 transition duration-300 shadow-lg shadow-yellow-500/20 flex items-center gap-2">
                        <i class="fas fa-user-plus"></i> Daftar Sekarang
                    </a>
                    <a href="/kontak"
                        class="px-8 py-3 bg-transparent border border-white/30 text-white font-bold rounded-full hover:bg-white/10 transition">
                        Hubungi Kami
                    </a>
                </div>
            </div>

            {{-- KOLOM KANAN: WIDGET PENGUMUMAN TERBARU --}}
            <div class="relative">
                {{-- Hiasan Background Miring --}}
                <div
                    class="absolute top-4 -right-4 w-full h-full bg-unmaris-yellow rounded-2xl transform rotate-2 opacity-20 pointer-events-none">
                </div>

                <div class="bg-white text-gray-800 rounded-2xl p-8 shadow-2xl relative">

                    {{-- Header Widget --}}
                    <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
                        <h3 class="font-bold text-lg text-unmaris-blue flex items-center">
                            <i class="fas fa-bullhorn mr-2"></i> Papan Pengumuman
                        </h3>
                        <a href="{{ route('public.pengumuman.index') }}"
                            class="text-xs font-bold text-unmaris-yellow hover:text-unmaris-blue transition">
                            LIHAT SEMUA
                        </a>
                    </div>

                    {{-- List Pengumuman --}}
                    {{-- Pastikan controller mengirim variabel $pengumuman_terbaru --}}
                    <div class="space-y-4">
                        @if (isset($pengumuman_terbaru) && count($pengumuman_terbaru) > 0)
                            @foreach ($pengumuman_terbaru as $item)
                                <a href="{{ route('public.pengumuman.show', $item->slug) }}"
                                    class="flex gap-4 group items-start relative p-3 rounded-xl hover:bg-gray-50 transition border border-transparent hover:border-gray-100">

                                    {{-- Tanggal (Kotak Kecil) --}}
                                    <div
                                        class="flex-shrink-0 w-16 h-16 bg-blue-50 rounded-lg flex flex-col items-center justify-center text-unmaris-blue border border-blue-100 group-hover:bg-unmaris-blue group-hover:text-white transition duration-300">
                                        <span
                                            class="text-xl font-bold leading-none">{{ $item->published_at->format('d') }}</span>
                                        <span
                                            class="text-[10px] uppercase font-bold">{{ $item->published_at->format('M') }}</span>
                                    </div>

                                    {{-- Info --}}
                                    <div class="flex-1 min-w-0 pt-1">
                                        <div class="flex justify-between items-start">
                                            <span
                                                class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-1 block">
                                                {{ $item->kategori }}
                                            </span>

                                            @if ($item->is_pinned)
                                                <i class="fas fa-thumbtack text-red-500 text-xs transform rotate-45"
                                                    title="Penting/Disematkan"></i>
                                            @endif
                                        </div>

                                        <h4
                                            class="font-bold text-sm text-gray-800 group-hover:text-unmaris-blue transition leading-snug line-clamp-2">
                                            {{ $item->judul }}
                                        </h4>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            <div class="text-center py-8">
                                <i class="far fa-bell-slash text-gray-300 text-4xl mb-2 block"></i>
                                <p class="text-gray-500 text-sm italic">Belum ada pengumuman baru.</p>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </section>

</x-layouts.public>
