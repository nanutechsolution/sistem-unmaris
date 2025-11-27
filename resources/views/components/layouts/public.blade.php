<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? 'UNMARIS Sumba' }}</title>

    {{-- icon --}}
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/png">
    <!-- Figtree via Bunny -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    @trixassets
</head>

<body class="font-sans bg-gray-100 antialiased">
    {{-- WRAPPER STICKY: Membungkus Pengumuman & Navbar agar menempel bersamaan --}}
    <div class="sticky top-0 z-[100] w-full">
        {{-- LOGIC PENGUMUMAN URGENT --}}
        @php
            $urgent = \App\Models\Pengumuman::where('is_pinned', true)->where('status', 'Published')->latest()->first();
        @endphp
        @if ($urgent)
            <div x-data="{ open: true }" x-show="open" x-transition:leave="transition-all ease-in-out duration-300"
                x-transition:leave-start="opacity-100 max-h-20" x-transition:leave-end="opacity-0 max-h-0"
                class="bg-red-600 text-white relative shadow-md overflow-hidden"> {{-- overflow-hidden penting untuk animasi --}}

                <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
                    <div class="flex items-center gap-3 text-sm font-medium truncate pr-4">
                        <span
                            class="bg-white text-red-600 text-[10px] font-extrabold px-2 py-0.5 rounded uppercase tracking-wider shrink-0 animate-pulse">
                            PENTING
                        </span>
                        <a href="{{ route('public.pengumuman.show', $urgent->slug) }}" class="hover:underline truncate">
                            {{ $urgent->judul }}
                        </a>
                    </div>

                    <button @click="open = false"
                        class="text-white/80 hover:text-white hover:bg-red-700 rounded-full p-1 transition focus:outline-none shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        {{-- NAVIGATION BAR --}}
        {{-- Pastikan di dalam component navigation tidak ada class 'fixed top-0', ubah jadi relative atau biarkan default --}}
        <div class="w-full bg-unmaris-blue/90 backdrop-blur-md border-b border-white/10 shadow-lg">
            <livewire:layout.navigation />
        </div>

    </div>
    <main>
        {{ $slot }}
    </main>
    <footer class="bg-unmaris-blue text-white pt-20 pb-10 relative overflow-hidden border-t-8 border-unmaris-yellow">

        {{-- Decorative Background --}}
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none opacity-10">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-full h-64 bg-gradient-to-t from-black to-transparent"></div>
        </div>

        <div class="max-w-7xl mx-auto px-6 relative z-10">

            {{-- Top Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">

                {{-- Column 1: Brand & About --}}
                <div class="space-y-6">
                    <a href="/" class="flex items-center gap-3 group">
                        <div class="relative">
                            <div
                                class="absolute -inset-1 bg-unmaris-yellow rounded-full blur opacity-20 group-hover:opacity-40 transition duration-500">
                            </div>
                            @if (\App\Models\Setting::get('site_logo'))
                                <img src="{{ \App\Models\Setting::get('site_logo') }}" alt="Logo Kampus"
                                    class="h-12 w-auto relative">
                            @else
                                <img src="{{ asset('logo.png') }}" alt="Logo Default" class="h-12 w-auto relative">
                            @endif
                        </div>
                        <div class="flex flex-col">
                            <span
                                class="font-bold text-2xl leading-none tracking-tight text-white">{{ \App\Models\Setting::get('site_short_name', 'UNMARIS') }}</span>
                            {{-- <span
                                class="text-[0.65rem] text-unmaris-yellow tracking-[0.2em] uppercase font-medium">{{ \App\Models\Setting::get('site_slogan', 'UNMARIS') }}</span> --}}
                        </div>
                    </a>
                    <p class="text-blue-100 text-sm leading-relaxed">
                        {{ \App\Models\Setting::get('site_description', 'Deskripsi kampus belum diatur. Silakan atur di halaman admin.') }}
                    </p>
                    <div class="flex space-x-4">

                        @if (\App\Models\Setting::get('social_facebook'))
                            <a href="{{ \App\Models\Setting::get('social_facebook') }}" target="_blank"
                                class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-unmaris-yellow hover:text-unmaris-blue transition duration-300">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        @endif

                        @if (\App\Models\Setting::get('social_instagram'))
                            <a href="{{ \App\Models\Setting::get('social_instagram') }}" target="_blank"
                                class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-unmaris-yellow hover:text-unmaris-blue transition duration-300">
                                <i class="fab fa-instagram"></i>
                            </a>
                        @endif

                        @if (\App\Models\Setting::get('social_youtube'))
                            <a href="{{ \App\Models\Setting::get('social_youtube') }}" target="_blank"
                                class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-unmaris-yellow hover:text-unmaris-blue transition duration-300">
                                <i class="fab fa-youtube"></i>
                            </a>
                        @endif

                        @if (\App\Models\Setting::get('social_linkedin'))
                            <a href="{{ \App\Models\Setting::get('social_linkedin') }}" target="_blank"
                                class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-unmaris-yellow hover:text-unmaris-blue transition duration-300">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        @endif
                        @if (\App\Models\Setting::get('social_tiktok'))
                            <a href="{{ \App\Models\Setting::get('social_tiktok') }}" target="_blank"
                                class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-unmaris-yellow hover:text-unmaris-blue transition duration-300">
                                <i class="fab fa-tiktok"></i>
                            </a>
                        @endif

                    </div>
                </div>

                {{-- Column 2: Quick Links --}}
                <div>
                    <h3 class="text-lg font-bold text-white mb-6 border-l-4 border-unmaris-yellow pl-3">Jelajahi Kampus
                    </h3>
                    <ul class="space-y-3 text-sm">
                        <li>
                            <a href="/page/profil"
                                class="text-blue-100 hover:text-unmaris-yellow transition flex items-center group">
                                <i
                                    class="fas fa-chevron-right text-xs mr-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-unmaris-yellow"></i>
                                Profil & Sejarah
                            </a>
                        </li>
                        <li>
                            <a href="/pmb"
                                class="text-blue-100 hover:text-unmaris-yellow transition flex items-center group">
                                <i
                                    class="fas fa-chevron-right text-xs mr-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-unmaris-yellow"></i>
                                Pendaftaran Mahasiswa Baru
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('public.kemahasiswaan.index') }}"
                                class="text-blue-100 hover:text-unmaris-yellow transition flex items-center group">
                                <i
                                    class="fas fa-chevron-right text-xs mr-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-unmaris-yellow"></i>
                                Kemahasiswaan & Alumni
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('public.posts.index') }}"
                                class="text-blue-100 hover:text-unmaris-yellow transition flex items-center group">
                                <i
                                    class="fas fa-chevron-right text-xs mr-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-unmaris-yellow"></i>
                                Berita & Kegiatan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('public.dokumen.index') }}"
                                class="text-blue-100 hover:text-unmaris-yellow transition flex items-center group">
                                <i
                                    class="fas fa-chevron-right text-xs mr-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-unmaris-yellow"></i>
                                Download Dokumen
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Column 3: Akademik & Layanan --}}
                <div>
                    <h3 class="text-lg font-bold text-white mb-6 border-l-4 border-unmaris-yellow pl-3">Akademik & Riset
                    </h3>
                    <ul class="space-y-3 text-sm">
                        <li>
                            <a href="{{ route('public.lpm.index') }}"
                                class="text-blue-100 hover:text-unmaris-yellow transition flex items-center group">
                                <i
                                    class="fas fa-chevron-right text-xs mr-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-unmaris-yellow"></i>
                                Penjaminan Mutu (LPM)
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('public.lppm.index') }}"
                                class="text-blue-100 hover:text-unmaris-yellow transition flex items-center group">
                                <i
                                    class="fas fa-chevron-right text-xs mr-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-unmaris-yellow"></i>
                                Penelitian & Pengabdian (LPPM)
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="text-blue-100 hover:text-unmaris-yellow transition flex items-center group">
                                <i
                                    class="fas fa-chevron-right text-xs mr-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-unmaris-yellow"></i>
                                E-Journal / OJS
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="text-blue-100 hover:text-unmaris-yellow transition flex items-center group">
                                <i
                                    class="fas fa-chevron-right text-xs mr-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-unmaris-yellow"></i>
                                Perpustakaan Digital
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="text-blue-100 hover:text-unmaris-yellow transition flex items-center group">
                                <i
                                    class="fas fa-chevron-right text-xs mr-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-unmaris-yellow"></i>
                                SIAKAD (Portal Akademik)
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Column 4: Contact --}}
                <div>
                    <h3 class="text-lg font-bold text-white mb-6 border-l-4 border-unmaris-yellow pl-3">
                        Hubungi Kami
                    </h3>
                    <ul class="space-y-4 text-sm">
                        {{-- ALAMAT --}}
                        <li class="flex items-start space-x-3">
                            <i class="fas fa-map-marker-alt mt-1 text-unmaris-yellow"></i>
                            <span class="text-blue-100">
                                {!! nl2br(e(\App\Models\Setting::get('contact_address', 'Alamat kampus belum diatur.'))) !!}
                            </span>
                        </li>

                        {{-- TELEPON --}}
                        <li class="flex items-center space-x-3">
                            <i class="fas fa-phone-alt text-unmaris-yellow"></i>
                            <span class="text-blue-100">
                                {{ \App\Models\Setting::get('contact_phone', '+62...') }}
                            </span>
                        </li>

                        {{-- EMAIL --}}
                        <li class="flex items-center space-x-3">
                            <i class="fas fa-envelope text-unmaris-yellow"></i>
                            <span class="text-blue-100">
                                {{ \App\Models\Setting::get('contact_email', 'info@unmaris.ac.id') }}
                            </span>
                        </li>
                    </ul>

                    {{-- CTA Button Small --}}
                    <div class="mt-6">
                        {{-- Link bisa diarahkan ke halaman kontak atau WA --}}
                        <a href="/kontak"
                            class="inline-block px-6 py-2 border border-unmaris-yellow text-unmaris-yellow text-sm font-bold rounded-full hover:bg-unmaris-yellow hover:text-unmaris-blue transition duration-300">
                            Pusat Bantuan
                        </a>
                    </div>
                </div>

            </div>

            {{-- Bottom Bar --}}
            <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-xs text-blue-200 text-center md:text-left">
                    &copy; {{ date('Y') }} <span class="font-bold text-white">Universitas Stella Maris
                        Sumba</span>. All Rights Reserved.
                </p>
                <div class="flex space-x-6 text-xs text-blue-200">
                    <a href="#" class="hover:text-white transition">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-white transition">Syarat & Ketentuan</a>
                    <a href="#" class="hover:text-white transition">Peta Situs</a>
                </div>
            </div>

        </div>
    </footer>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 900,
            once: true
        });
    </script>
    @stack('scripts')
</body>

</html>
