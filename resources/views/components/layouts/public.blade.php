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

</head>

<body class="font-sans bg-gray-100 antialiased">

    <nav x-data="{
        open:false,
        profil:false,
        fakul:false
    }" class="bg-unmaris-blue sticky top-0 z-50 shadow-xl backdrop-blur-md bg-unmaris-blue/95">

        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center h-16">

            <!-- Logo -->
            <div class="flex items-center gap-3">
                <img src="{{ asset('logo.png') }}" class="h-12" />
                <span class="text-white font-bold text-xl tracking-wide">UNMARIS SUMBA</span>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-6">

                <a href="{{ route('public.home') }}" class="nav-link nav-link-active">
                    Beranda
                </a>

                <!-- Profil Desktop -->
                <div class="relative group">
                    <button class="nav-link flex items-center gap-1">
                        Profil
                    </button>

                    <div class="absolute left-0 top-full mt-2 bg-white rounded-lg shadow-lg w-56 py-3
                            opacity-0 invisible transition-all duration-200
                            group-hover:opacity-100 group-hover:visible">

                        <a class="block px-4 py-2 hover:bg-gray-100">Sejarah Kampus</a>
                        <a class="block px-4 py-2 hover:bg-gray-100">Struktur Organisasi</a>
                        <a class="block px-4 py-2 hover:bg-gray-100">Visi & Misi</a>
                        <a class="block px-4 py-2 hover:bg-gray-100">Fasilitas Kampus</a>
                    </div>
                </div>

                <a class="nav-link">Berita</a>

                <a class="px-4 py-2 bg-unmaris-yellow text-unmaris-blue font-bold rounded-md shadow hover:bg-yellow-400 transition">
                    PMB 2026
                </a>
            </div>

            <!-- Mobile Hamburger -->
            <button @click="open = !open" class="md:hidden text-white focus:outline-none">
                <svg class="w-8 h-8" fill="none" stroke="currentColor">
                    <path x-show="!open" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path x-show="open" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div x-cloak x-show="open" x-transition class="hidden md:hidden bg-unmaris-blue px-4 pb-4 space-y-2">

            <a class="mobile-link font-semibold text-unmaris-yellow">Beranda</a>

            <!-- Profil Mobile -->
            <button class="mobile-btn" @click="profil = !profil">
                Profil
            </button>
            <div x-show="profil" x-transition class="mobile-sub">
                <a class="mobile-sub-item">Sejarah Kampus</a>
                <a class="mobile-sub-item">Struktur Organisasi</a>
                <a class="mobile-sub-item">Visi & Misi</a>
                <a class="mobile-sub-item">Fasilitas Kampus</a>
            </div>

            <!-- Fakultas Mobile -->
            <button class="mobile-btn" @click="fakul = !fakul">
                Fakultas & Prodi
            </button>
            <div x-show="fakul" x-transition class="mobile-sub">
                <a class="mobile-sub-item">Teknik Informatika</a>
                <a class="mobile-sub-item">Sistem Informasi</a>
                <a class="mobile-sub-item">Teknik Sipil</a>
                <a class="mobile-sub-item">Hukum</a>
                <a class="mobile-sub-item">Manajemen</a>
            </div>

            <a class="mobile-link">Berita</a>
            <a class="mobile-link">PMB 2026</a>
        </div>

    </nav>



    <main>
        {{ $slot }}
    </main>
    <footer class="mt-20 border-t border-gray-200 dark:border-gray-700 bg-gradient-to-br from-unmaris-blue/90 via-gray-900 to-black text-gray-200">
        <div class="max-w-7xl mx-auto px-6 py-14 grid grid-cols-1 md:grid-cols-4 gap-10">

            <div>
                <h3 class="text-xl font-bold tracking-wide text-unmaris-yellow">UNMARIS</h3>
                <p class="mt-3 text-sm leading-relaxed text-gray-300">
                    Universitas Stella Maris Sumba — kampus teknologi dengan jiwa humanis.
                </p>
                <div class="flex space-x-4 mt-4">
                    <a href="#" class="hover:text-unmaris-yellow transition">
                        <x-heroicon-s-academic-cap class="w-6 h-6" />
                    </a>
                    <a href="#" class="hover:text-unmaris-yellow transition">
                        <x-heroicon-s-globe-alt class="w-6 h-6" />
                    </a>
                    <a href="#" class="hover:text-unmaris-yellow transition">
                        <x-heroicon-s-phone class="w-6 h-6" />
                    </a>
                </div>
            </div>


            <!-- Sitemap -->
            <div>
                <h4 class="text-lg font-semibold text-unmaris-yellow mb-3">Navigasi</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="hover:text-unmaris-yellow transition">Beranda</a></li>
                    <li><a href="#" class="hover:text-unmaris-yellow transition">Fakultas</a></li>
                    <li><a href="#" class="hover:text-unmaris-yellow transition">Pendaftaran</a></li>
                    <li><a href="#" class="hover:text-unmaris-yellow transition">Berita</a></li>
                </ul>
            </div>


            <!-- Akademik -->
            <div>
                <h4 class="text-lg font-semibold text-unmaris-yellow mb-3">Akademik</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="hover:text-unmaris-yellow transition">Program Studi</a></li>
                    <li><a href="#" class="hover:text-unmaris-yellow transition">SIAKAD</a></li>
                    <li><a href="#" class="hover:text-unmaris-yellow transition">Beasiswa</a></li>
                    <li><a href="#" class="hover:text-unmaris-yellow transition">Penelitian</a></li>
                </ul>
            </div>


            <!-- Kontak -->
            <div>
                <h4 class="text-lg font-semibold text-unmaris-yellow mb-3">Kontak</h4>
                <ul class="space-y-2 text-sm">
                    <li class="flex items-center space-x-2">
                        <x-heroicon-s-map-pin class="w-5 h-5" />
                        <span>Lolo Ole, Sumba Barat Daya</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <x-heroicon-s-envelope class="w-5 h-5" />
                        <span>info@unmaris.ac.id</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <x-heroicon-s-phone class="w-5 h-5" />
                        <span>+62 90-23-99000</span>
                    </li>
                </ul>
            </div>
        </div>


        <div class="text-center py-6 text-xs text-gray-400 border-t border-gray-700/50">
            © 2025 Universitas Stella Maris (UNMARIS). Semua Hak Dilindungi.
        </div>
    </footer>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 900
            , once: true
        });

    </script>

</body>
</html>
