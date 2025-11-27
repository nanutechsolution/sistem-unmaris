<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'SIAKAD UNMARIS' }}</title>

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/png">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    {{-- Scripts --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @trixassets
    @livewireStyles
</head>

<body class="font-sans antialiased bg-gray-50 text-gray-900" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">

        {{-- 
            ========================================
            SIDEBAR NAVIGATION
            ========================================
        --}}
        <aside
            class="fixed inset-y-0 left-0 z-50 w-72 bg-unmaris-blue text-white transition-transform duration-300 ease-in-out transform lg:static lg:translate-x-0 flex flex-col shadow-2xl"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" x-cloak>

            {{-- Sidebar Header --}}
            <div class="flex items-center justify-center h-20 bg-blue-900/30 shadow-sm border-b border-white/5">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('logo.png') }}" alt="Logo"
                        class="h-10 w-auto transition group-hover:scale-110">
                    <div class="flex flex-col">
                        <span class="text-lg font-bold tracking-wide">SIAKAD</span>
                        <span class="text-[0.6rem] text-unmaris-yellow tracking-[0.2em] uppercase">Admin Panel</span>
                    </div>
                </a>
            </div>

            {{-- Sidebar Menu --}}
            <div class="flex-1 overflow-y-auto py-4 px-3 space-y-1 custom-scrollbar">

                @php
                    // Helper function untuk cek active state support wildcard (*) dan multiple paths (|)
                    $isActive = function ($patterns) {
                        foreach (explode('|', $patterns) as $pattern) {
                            if (request()->is($pattern)) {
                                return true;
                            }
                        }
                        return false;
                    };

                    $menuItems = [
                        [
                            'title' => 'Dashboard',
                            'route' => 'admin.dashboard',
                            'icon' => 'fas fa-tachometer-alt',
                            'active' => 'admin/dashboard',
                        ],
                        ['heading' => 'DATA MASTER (UNIVERSITAS)'],
                        [
                            'title' => 'Data Kampus',
                            'icon' => 'fas fa-university',
                            'active' =>
                                'admin/master/fakultas*|admin/master/prodi*|admin/master/tahun-akademik*|admin/master/kurikulum*',
                            'submenu' => [
                                [
                                    'title' => 'Fakultas',
                                    'route' => 'admin.master.fakultas.index',
                                    'active' => 'admin/master/fakultas*',
                                ],
                                [
                                    'title' => 'Program Studi',
                                    'route' => 'admin.master.prodi.index',
                                    'active' => 'admin/master/prodi*',
                                ],
                                [
                                    'title' => 'Tahun Akademik',
                                    'route' => 'admin.master.tahun-akademik.index',
                                    'active' => 'admin/master/tahun-akademik*',
                                ],
                                [
                                    'title' => 'Kurikulum',
                                    'route' => 'admin.master.kurikulum.index',
                                    'active' => 'admin/master/kurikulum*',
                                ],
                            ],
                        ],

                        ['heading' => 'CIVITAS & SDM'],
                        [
                            'title' => 'Data Pengguna',
                            'icon' => 'fas fa-users',
                            'active' => 'admin/civitas/mahasiswa*|admin/civitas/dosen*|admin/civitas/penugasan-dosen*',
                            'submenu' => [
                                [
                                    'title' => 'Mahasiswa',
                                    'route' => 'admin.civitas.mahasiswa.index',
                                    'active' => 'admin/civitas/mahasiswa*',
                                ],
                                [
                                    'title' => 'Dosen',
                                    'route' => 'admin.civitas.dosen.index',
                                    'active' => 'admin/civitas/dosen*',
                                ],
                                [
                                    'title' => 'Penugasan Dosen',
                                    'route' => 'admin.civitas.penugasan-dosen.index',
                                    'active' => 'admin/civitas/penugasan-dosen*',
                                ],
                            ],
                        ],
                        [
                            'title' => 'Pejabat Struktural',
                            'icon' => 'fas fa-user-tie',
                            'active' => 'admin/civitas/dekan*|admin/civitas/kaprodi*',
                            'submenu' => [
                                [
                                    'title' => 'Dekan',
                                    'route' => 'admin.civitas.dekan.index',
                                    'active' => 'admin/civitas/dekan*',
                                ],
                                [
                                    'title' => 'Kaprodi',
                                    'route' => 'admin.civitas.kaprodi.index',
                                    'active' => 'admin/civitas/kaprodi*',
                                ],
                            ],
                        ],

                        ['heading' => 'PERKULIAHAN'],
                        [
                            'title' => 'Akademik',
                            'icon' => 'fas fa-graduation-cap',
                            'active' => 'admin/akademik/mata-kuliah*|admin/akademik/kelas*',
                            'submenu' => [
                                [
                                    'title' => 'Mata Kuliah',
                                    'route' => 'admin.akademik.matakuliah.index',
                                    'active' => 'admin/akademik/mata-kuliah*',
                                ],
                                [
                                    'title' => 'Jadwal Kelas',
                                    'route' => 'admin.akademik.kelas.index',
                                    'active' => 'admin/akademik/kelas*',
                                ],
                            ],
                        ],
                        [
                            'title' => 'KRS & Nilai',
                            'icon' => 'fas fa-file-signature',
                            'active' => 'admin/akademik/krs*|admin/akademik/nilai*|admin/akademik/khs*',
                            'submenu' => [
                                [
                                    'title' => 'Data KRS',
                                    'route' => 'admin.akademik.krs.index',
                                    'active' => 'admin/akademik/krs',
                                ],
                                [
                                    'title' => 'Validasi KRS',
                                    'route' => 'admin.akademik.krs.validasi',
                                    'active' => 'admin/akademik/krs/validasi*',
                                ],
                                [
                                    'title' => 'Input Nilai',
                                    'route' => 'admin.akademik.nilai.index',
                                    'active' => 'admin/akademik/nilai*',
                                ],
                                [
                                    'title' => 'Cetak KHS',
                                    'route' => 'admin.akademik.khs.index',
                                    'active' => 'admin/akademik/khs*',
                                ],
                            ],
                        ],

                        ['heading' => 'WEBSITE (CMS)'],
                        [
                            'title' => 'Konten Web',
                            'icon' => 'fas fa-globe',
                            // UPDATE: Tambahkan admin/fasilitas* di sini
                            'active' =>
                                'admin/cms/berita*|admin/cms/pengumuman*|admin/cms/halaman*|admin/cms/slider*|admin/cms/dokumen*|admin/cms/pmb-gelombang*|admin/cms/kategori*|admin/fasilitas*',
                            'submenu' => [
                                [
                                    'title' => 'Berita & Artikel',
                                    'route' => 'admin.cms.posts.index',
                                    'active' => 'admin/cms/berita*',
                                ],
                                [
                                    'title' => 'Kategori Berita',
                                    'route' => 'admin.cms.categories.index',
                                    'active' => 'admin/cms/kategori*',
                                ],
                                [
                                    'title' => 'Pengumuman',
                                    'route' => 'admin.cms.pengumuman.index',
                                    'active' => 'admin/cms/pengumuman*',
                                ],
                                [
                                    'title' => 'Dokumen Publik',
                                    'route' => 'admin.cms.documents.index',
                                    'active' => 'admin/cms/dokumen*',
                                ],
                                // MENU BARU: FASILITAS KAMPUS
                                [
                                    'title' => 'Fasilitas Kampus',
                                    'route' => 'admin.fasilitas.index',
                                    'active' => 'admin/fasilitas*',
                                ],
                                [
                                    'title' => 'Halaman Statis',
                                    'route' => 'admin.cms.pages.index',
                                    'active' => 'admin/cms/halaman*',
                                ],
                                [
                                    'title' => 'Banner Slider',
                                    'route' => 'admin.cms.sliders.index',
                                    'active' => 'admin/cms/slider*',
                                ],
                                [
                                    'title' => 'PMB Gelombang',
                                    'route' => 'admin.cms.pmb-gelombang.index',
                                    'active' => 'admin/cms/pmb-gelombang*',
                                ],
                            ],
                        ],
                        [
                            'title' => 'Pengaturan Web',
                            'icon' => 'fas fa-cogs',
                            'route' => 'admin.cms.settings.index',
                            'active' => 'admin/cms/pengaturan*',
                        ],

                        ['heading' => 'PENJAMINAN MUTU (LPM)'],
                        [
                            'title' => 'LPM',
                            'icon' => 'fas fa-certificate',
                            'active' => 'admin/lpm/dokumen-mutu*|admin/lpm/info-mutu*',
                            'submenu' => [
                                [
                                    'title' => 'Dokumen Mutu',
                                    'route' => 'admin.lpm.documents.index',
                                    'active' => 'admin/lpm/dokumen-mutu*',
                                ],
                                [
                                    'title' => 'Info Mutu',
                                    'route' => 'admin.lpm.announcements.index',
                                    'active' => 'admin/lpm/info-mutu*',
                                ],
                            ],
                        ],

                        ['heading' => 'SISTEM'],
                        [
                            'title' => 'Lihat Website',
                            'route' => 'home',
                            'icon' => 'fas fa-external-link-alt',
                            'active' => '',
                            'target' => '_blank',
                        ],
                    ];
                @endphp

                @foreach ($menuItems as $item)
                    {{-- 1. HEADING --}}
                    @if (isset($item['heading']))
                        <div class="px-4 mt-6 mb-2 text-[10px] font-bold text-blue-200/60 uppercase tracking-wider">
                            {{ $item['heading'] }}
                        </div>

                        {{-- 2. MENU DENGAN SUBMENU --}}
                    @elseif (isset($item['submenu']))
                        @php $isParentActive = $isActive($item['active']); @endphp
                        <div x-data="{ open: {{ $isParentActive ? 'true' : 'false' }} }" class="mb-1">
                            <button @click="open = !open"
                                class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 group
                                {{ $isParentActive ? 'bg-white/10 text-white shadow-inner' : 'text-blue-100 hover:bg-white/5 hover:text-white' }}">
                                <div class="flex items-center gap-3">
                                    <i
                                        class="{{ $item['icon'] }} w-5 text-center {{ $isParentActive ? 'text-unmaris-yellow' : 'text-blue-300 group-hover:text-unmaris-yellow' }}"></i>
                                    <span>{{ $item['title'] }}</span>
                                </div>
                                <i class="fas fa-chevron-right text-xs transition-transform duration-200"
                                    :class="{ 'rotate-90': open, 'text-white': open, 'text-blue-400': !open }"></i>
                            </button>

                            <div x-show="open" x-collapse class="space-y-1 mt-1 ml-4 border-l border-white/10 pl-2">
                                @foreach ($item['submenu'] as $sub)
                                    @php $isSubActive = $isActive($sub['active']); @endphp
                                    <a href="{{ route($sub['route']) }}" wire:navigate
                                        class="block px-4 py-2 text-sm rounded-lg transition-colors duration-200
                                       {{ $isSubActive ? 'bg-unmaris-yellow text-unmaris-blue font-bold shadow-sm' : 'text-blue-200 hover:text-white hover:bg-white/5' }}">
                                        {{ $sub['title'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        {{-- 3. MENU TUNGGAL --}}
                    @else
                        @php $isLinkActive = $isActive($item['active']); @endphp
                        <a href="{{ route($item['route']) }}"
                            @if (isset($item['target'])) target="{{ $item['target'] }}" @else wire:navigate @endif
                            class="flex items-center gap-3 px-4 py-3 mb-1 text-sm font-medium rounded-xl transition-all duration-200 group
                           {{ $isLinkActive ? 'bg-unmaris-yellow text-unmaris-blue font-bold shadow-lg' : 'text-blue-100 hover:bg-white/5 hover:text-white' }}">
                            <i
                                class="{{ $item['icon'] }} w-5 text-center {{ $isLinkActive ? 'text-unmaris-blue' : 'text-blue-300 group-hover:text-unmaris-yellow' }}"></i>
                            <span>{{ $item['title'] }}</span>
                        </a>
                    @endif
                @endforeach

                {{-- Logout Button (Mobile) --}}
                <div class="lg:hidden mt-8 pt-4 border-t border-white/10">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-3 w-full px-4 py-3 text-sm font-medium text-red-300 hover:bg-red-500/10 hover:text-red-200 rounded-xl transition">
                            <i class="fas fa-sign-out-alt w-5 text-center"></i>
                            Logout
                        </button>
                    </form>
                </div>

            </div>
        </aside>

        {{-- Overlay untuk Mobile --}}
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
            x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black/50 z-40 lg:hidden" x-cloak></div>

        {{-- 
            ========================================
            MAIN CONTENT AREA
            ========================================
        --}}
        <div class="flex-1 flex flex-col overflow-hidden bg-gray-50">

            {{-- Top Header --}}
            <header
                class="flex items-center justify-between h-20 px-6 bg-white border-b border-gray-200 shadow-sm z-30">

                {{-- Left: Hamburger & Title --}}
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="p-2 text-gray-500 hover:text-unmaris-blue lg:hidden focus:outline-none rounded-lg hover:bg-gray-100">
                        <i class="fas fa-bars text-xl"></i>
                    </button>

                    {{-- Breadcrumb sederhana / Judul Halaman --}}
                    <h2 class="text-xl font-bold text-gray-800 tracking-tight hidden sm:block">
                        {{ $header ?? 'Dashboard' }}
                    </h2>
                </div>

                {{-- Right: User Profile Dropdown --}}
                <div class="flex items-center gap-4">

                    {{-- User Menu --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.outside="open = false"
                            class="flex items-center gap-3 focus:outline-none group">
                            <div class="text-right hidden md:block">
                                <p class="text-sm font-bold text-gray-700 group-hover:text-unmaris-blue transition">
                                    {{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                            </div>
                            <div
                                class="w-10 h-10 rounded-full bg-unmaris-blue text-white flex items-center justify-center font-bold text-lg shadow-md group-hover:ring-2 group-hover:ring-offset-2 group-hover:ring-unmaris-blue transition">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform duration-200"
                                :class="{ 'rotate-180': open }"></i>
                        </button>

                        {{-- Dropdown Content --}}
                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 mt-3 w-56 bg-white rounded-xl shadow-xl py-2 ring-1 ring-black ring-opacity-5 z-50 origin-top-right"
                            style="display: none;">

                            <div class="px-4 py-3 border-b border-gray-100 mb-1 md:hidden">
                                <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                            </div>

                            <a href="{{ route('admin.profile') }}"
                                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-unmaris-blue transition">
                                <i class="fas fa-user-circle w-5 mr-2"></i> Profil Saya
                            </a>

                            <div class="border-t border-gray-100 my-1"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="flex w-full items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition">
                                    <i class="fas fa-sign-out-alt w-5 mr-2"></i> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Main Content Slot --}}
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6 md:p-8">
                {{ $slot }}
            </main>

        </div>
    </div>

    @livewireScripts
</body>

</html>
