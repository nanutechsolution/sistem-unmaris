<x-layouts.public title="Perpustakaan Digital">

    {{-- 1. HERO SECTION --}}
    <section class="bg-unmaris-blue text-white pt-32 pb-24 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
        </div>
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-unmaris-yellow/10 blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4 tracking-tight">
                Pusat Sumber Belajar Digital
            </h1>
            <p class="text-blue-100 text-lg max-w-3xl mx-auto leading-relaxed">
                Akses tak terbatas ke jutaan sumber informasi akademik untuk mendukung penelitian dan studi Anda.
            </p>
        </div>
    </section>

    {{-- 2. STATS & CONTACT --}}
    <section class="py-16 bg-gray-50 -mt-12 relative z-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid lg:grid-cols-4 gap-8">

                {{-- Dynamic Stats Card --}}
                @foreach ($stats as $stat)
                    <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 flex items-center gap-4">
                        <div
                            class="w-12 h-12 bg-unmaris-yellow/20 text-unmaris-blue rounded-full flex items-center justify-center text-xl">
                            <i class="{{ $stat['icon'] }}"></i>
                        </div>
                        <div>
                            <span
                                class="block text-2xl font-extrabold text-gray-900 leading-none">{{ $stat['value'] }}</span>
                            <span
                                class="text-xs text-gray-500 uppercase tracking-widest mt-1">{{ $stat['label'] }}</span>
                        </div>
                    </div>
                @endforeach

                {{-- Contact Card --}}
                <div class="bg-unmaris-blue p-6 rounded-2xl shadow-xl text-white">
                    <h3 class="font-bold text-lg mb-2">Butuh Bantuan?</h3>
                    <p class="text-sm text-blue-100 mb-4">Hubungi Pustakawan via chat langsung.</p>
                    <a href="/kontak"
                        class="inline-block w-full py-2 bg-unmaris-yellow text-unmaris-blue font-bold rounded-lg hover:bg-white transition text-sm ">
                        Live Chat Support
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- 3. CORE COLLECTIONS --}}
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-3xl font-extrabold text-unmaris-blue mb-12 text-center">Layanan Akses Digital Utama</h2>

            <div class="grid md:grid-cols-2 gap-8">
                @foreach ($collections as $col)
                    <a href="{{ $col['link'] }}"
                        class="group block bg-gray-50 p-6 rounded-2xl border border-gray-200 hover:shadow-xl transition duration-300 hover:border-unmaris-blue/50">
                        <div class="flex items-start gap-5">
                            <div
                                class="w-16 h-16 rounded-xl bg-unmaris-blue text-white flex items-center justify-center text-3xl flex-shrink-0 shadow-lg group-hover:bg-unmaris-yellow group-hover:text-unmaris-blue transition">
                                <i class="{{ $col['icon'] }}"></i>
                            </div>
                            <div class="flex-grow">
                                <h3
                                    class="text-xl font-bold text-gray-800 mb-2 group-hover:text-unmaris-blue transition">
                                    {{ $col['title'] }}</h3>
                                <p class="text-gray-600 text-sm mb-3">{{ $col['description'] }}</p>
                                <span
                                    class="text-xs font-bold text-unmaris-blue uppercase tracking-wider bg-blue-50 px-2 py-1 rounded-full border border-blue-100">
                                    {{ $col['stats'] }}
                                </span>
                            </div>
                            <i
                                class="fas fa-arrow-right text-gray-400 mt-2 transition-transform group-hover:translate-x-1"></i>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 4. UTILITY LINKS & CONTACT INFO --}}
    <section class="py-20 bg-unmaris-blue/5 border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-3 gap-12">

            <div>
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-link text-unmaris-yellow mr-2"></i> Layanan Cepat
                </h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="text-gray-600 hover:text-unmaris-blue">Pengajuan Surat Bebas
                            Pustaka</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-unmaris-blue">Panduan Akses Jurnal</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-unmaris-blue">Pusat Bantuan Repository</a>
                    </li>
                </ul>
            </div>

            <div>
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-map-marker-alt text-unmaris-yellow mr-2"></i> Lokasi Fisik
                </h3>
                <p class="text-gray-600 text-sm">Gedung Rektorat Lt. 2, Kampus Utama UNMARIS, Waitabula, Sumba Barat
                    Daya.</p>
            </div>

            <div>
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-user-clock text-unmaris-yellow mr-2"></i> Jam Layanan
                </h3>
                <p class="text-gray-600 text-sm">Senin - Jumat: 08:00 - 17:00 WITA</p>
                <p class="text-gray-600 text-sm">Sabtu: 08:00 - 12:00 WITA</p>
            </div>
        </div>
    </section>

</x-layouts.public>
