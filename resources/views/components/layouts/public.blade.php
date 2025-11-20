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
{{-- <script src="https://kit.fontawesome.com/58a084ce82.js" crossorigin="anonymous"></script> --}}
</head>

<body class="font-sans bg-gray-100 antialiased">
    {{-- navigation --}}
    <livewire:layout.navigation />
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
                        <div class="absolute -inset-1 bg-unmaris-yellow rounded-full blur opacity-20 group-hover:opacity-40 transition duration-500"></div>
                        <img src="{{ asset('logo.png') }}" alt="Logo UNMARIS" class="h-12 w-auto relative">
                    </div>
                    <div class="flex flex-col">
                        <span class="font-bold text-2xl leading-none tracking-tight text-white">UNMARIS</span>
                        <span class="text-[0.65rem] text-unmaris-yellow tracking-[0.2em] uppercase font-medium">Universitas Maritim</span>
                    </div>
                </a>
                <p class="text-blue-100 text-sm leading-relaxed">
                    Universitas Stella Maris Sumba (UNMARIS) adalah perguruan tinggi yang berdedikasi mencetak generasi unggul, beriman, dan berdaya saing global dengan fokus pada pengembangan potensi maritim dan teknologi.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-unmaris-yellow hover:text-unmaris-blue transition duration-300">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-unmaris-yellow hover:text-unmaris-blue transition duration-300">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-unmaris-yellow hover:text-unmaris-blue transition duration-300">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-unmaris-yellow hover:text-unmaris-blue transition duration-300">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>

            {{-- Column 2: Quick Links --}}
            <div>
                <h3 class="text-lg font-bold text-white mb-6 border-l-4 border-unmaris-yellow pl-3">Jelajahi Kampus</h3>
                <ul class="space-y-3 text-sm">
                    <li>
                        <a href="/profil" class="text-blue-100 hover:text-unmaris-yellow transition flex items-center group">
                            <i class="fas fa-chevron-right text-xs mr-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-unmaris-yellow"></i>
                            Profil & Sejarah
                        </a>
                    </li>
                    <li>
                        <a href="/pmb" class="text-blue-100 hover:text-unmaris-yellow transition flex items-center group">
                            <i class="fas fa-chevron-right text-xs mr-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-unmaris-yellow"></i>
                            Pendaftaran Mahasiswa Baru
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('kemahasiswaan.index') }}" class="text-blue-100 hover:text-unmaris-yellow transition flex items-center group">
                            <i class="fas fa-chevron-right text-xs mr-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-unmaris-yellow"></i>
                            Kemahasiswaan & Alumni
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('posts.index') }}" class="text-blue-100 hover:text-unmaris-yellow transition flex items-center group">
                            <i class="fas fa-chevron-right text-xs mr-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-unmaris-yellow"></i>
                            Berita & Kegiatan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dokumen.index') }}" class="text-blue-100 hover:text-unmaris-yellow transition flex items-center group">
                            <i class="fas fa-chevron-right text-xs mr-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-unmaris-yellow"></i>
                            Download Dokumen
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Column 3: Akademik & Layanan --}}
            <div>
                <h3 class="text-lg font-bold text-white mb-6 border-l-4 border-unmaris-yellow pl-3">Akademik & Riset</h3>
                <ul class="space-y-3 text-sm">
                    <li>
                        <a href="{{ route('lpm.index') }}" class="text-blue-100 hover:text-unmaris-yellow transition flex items-center group">
                            <i class="fas fa-chevron-right text-xs mr-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-unmaris-yellow"></i>
                            Penjaminan Mutu (LPM)
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('lppm.index') }}" class="text-blue-100 hover:text-unmaris-yellow transition flex items-center group">
                            <i class="fas fa-chevron-right text-xs mr-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-unmaris-yellow"></i>
                            Penelitian & Pengabdian (LPPM)
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-blue-100 hover:text-unmaris-yellow transition flex items-center group">
                            <i class="fas fa-chevron-right text-xs mr-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-unmaris-yellow"></i>
                            E-Journal / OJS
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-blue-100 hover:text-unmaris-yellow transition flex items-center group">
                            <i class="fas fa-chevron-right text-xs mr-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-unmaris-yellow"></i>
                            Perpustakaan Digital
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-blue-100 hover:text-unmaris-yellow transition flex items-center group">
                            <i class="fas fa-chevron-right text-xs mr-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-unmaris-yellow"></i>
                            SIAKAD (Portal Akademik)
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Column 4: Contact --}}
            <div>
                <h3 class="text-lg font-bold text-white mb-6 border-l-4 border-unmaris-yellow pl-3">Hubungi Kami</h3>
                <ul class="space-y-4 text-sm">
                    <li class="flex items-start space-x-3">
                        <i class="fas fa-map-marker-alt mt-1 text-unmaris-yellow"></i>
                        <span class="text-blue-100">
                            Jl. R. Suprapto No. 35, Waingapu,<br>
                            Sumba Timur, Nusa Tenggara Timur,<br>
                            Indonesia - 87113
                        </span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <i class="fas fa-phone-alt text-unmaris-yellow"></i>
                        <span class="text-blue-100">+62 812-3456-7890</span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <i class="fas fa-envelope text-unmaris-yellow"></i>
                        <span class="text-blue-100">info@unmaris.ac.id</span>
                    </li>
                </ul>
                
                {{-- CTA Button Small --}}
                <div class="mt-6">
                    <a href="{{ route('public.contact') }}" class="inline-block px-6 py-2 border border-unmaris-yellow text-unmaris-yellow text-sm font-bold rounded-full hover:bg-unmaris-yellow hover:text-unmaris-blue transition duration-300">
                        Pusat Bantuan
                    </a>
                </div>
            </div>

        </div>

        {{-- Bottom Bar --}}
        <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-xs text-blue-200 text-center md:text-left">
                &copy; {{ date('Y') }} <span class="font-bold text-white">Universitas Stella Maris Sumba</span>. All Rights Reserved.
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
            duration: 900
            , once: true
        });

    </script>

</body>
</html>
