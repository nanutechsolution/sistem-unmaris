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
    {{-- navigation --}}
    <livewire:layout.navigation />
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
