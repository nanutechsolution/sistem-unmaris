<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'SIAKAD UNMARIS' }}</title>
    {{-- icon --}}
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/png">

    {{-- fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    @trixassets
</head>

<body class="font-sans antialiased">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-100">
        @php
            // Definisi struktur menu
            $menuItems = [
                [
                    'title' => 'Dashboard',
                    'route' => 'dashboard',
                    'icon' => 'fas fa-tachometer-alt',
                    'active_check' => 'dashboard',
                ],
                [
                    'title' => 'Manajemen Website & Data',
                    'heading' => true,
                ],
                [
                    'title' => 'Data Dasar',
                    'icon' => 'fas fa-database',
                    'active_check' =>
                        'manajemen/fakultas*|manajemen/prodi*|manajemen/tahun-akademik*|admin/kaprodi*|admin/dekan*|',
                    'submenu' => [
                        ['title' => 'Fakultas', 'route' => 'fakultas.index', 'active_check' => 'manajemen/fakultas*'],
                        ['title' => 'Program Studi', 'route' => 'prodi.index', 'active_check' => 'manajemen/prodi*'],
                        [
                            'title' => 'Tahun Akademik',
                            'route' => 'tahun-akademik.index',
                            'active_check' => 'manajemen/tahun-akademik*',
                        ],
                        ['title' => 'Dekan ', 'route' => 'admin.dekan', 'active_check' => 'admin/dekan*'],
                        ['title' => 'Kaprodi', 'route' => 'admin.kaprodi', 'active_check' => 'admin/kaprodi*'],
                    ],
                ],
                [
                    'title' => 'Website',
                    'icon' => 'fas fa-cogs',
                    'active_check' =>
                        'manajemen/halaman*|manajemen/pengaturan*|manajemen/kategori*|manajemen/berita*|manajemen/slider*|manajemen/pmb-gelombang*baca/berita*|admin/pengumuman*',
                    'submenu' => [
                        ['title' => 'Banner Depan', 'route' => 'sliders.index', 'active_check' => 'manajemen/slider*'],
                        ['title' => 'Halaman Statis', 'route' => 'pages.index', 'active_check' => 'manajemen/halaman*'],
                        [
                            'title' => 'Pengaturan Website',
                            'route' => 'settings.index',
                            'active_check' => 'manajemen/pengaturan*',
                        ],
                        [
                            'title' => 'Kategori Berita',
                            'route' => 'categories.index',
                            'active_check' => 'manajemen/kategori*',
                        ],
                        [
                            'title' => 'Berita',
                            'route' => 'posts.index',
                            'active_check' => 'manajemen/berita*|baca/berita*',
                        ],
                        ['title' => 'Pengumuman', 'route' => 'admin.pengumuman', 'active_check' => 'admin/pengumuman*'],
                        [
                            'title' => 'Gelombang PMB',
                            'route' => 'pmb-gelombang.index',
                            'active_check' => 'manajemen/pmb-gelombang*',
                        ],
                    ],
                ],
                [
                    'title' => 'LPM',
                    'icon' => 'fas fa-certificate',
                    'active_check' => 'manajemen/quality-documents*|manajemen/quality-announcements*',
                    'submenu' => [
                        [
                            'title' => 'Quality Documents',
                            'route' => 'quality-documents.index',
                            'active_check' => 'manajemen/quality-documents*',
                        ],
                        [
                            'title' => 'Quality Announcements',
                            'route' => 'quality-announcements.index',
                            'active_check' => 'manajemen/quality-announcements*',
                        ],
                    ],
                ],
                [
                    'title' => 'Akademik & User',
                    'heading' => true,
                ],
                [
                    'title' => 'Data User',
                    'icon' => 'fas fa-users',
                    'active_check' => 'akademik/mahasiswa*|akademik/dosen*|admin/penugasan-dosen*',
                    'submenu' => [
                        ['title' => 'Mahasiswa', 'route' => 'mahasiswa.index', 'active_check' => 'akademik/mahasiswa*'],
                        ['title' => 'Dosen', 'route' => 'dosen.index', 'active_check' => 'akademik/dosen*'],
                        [
                            'title' => 'Penugasa Dosen',
                            'route' => 'admin.penugasan',
                            'active_check' => 'admin/penugasan-dosen*',
                        ],
                    ],
                ],
                [
                    'title' => 'Kurikulum & Matkul',
                    'icon' => 'fas fa-book',
                    'active_check' => 'akademik/mata-kuliah*|manajemen/kurikulum*',
                    'submenu' => [
                        [
                            'title' => 'Kurikulum',
                            'route' => 'kurikulum.index',
                            'active_check' => 'manajemen/kurikulum*',
                        ],
                        [
                            'title' => 'Mata Kuliah',
                            'route' => 'matakuliah.index',
                            'active_check' => 'akademik/mata-kuliah*',
                        ],
                    ],
                ],
                [
                    'title' => 'Perkuliahan',
                    'heading' => true,
                ],
                [
                    'title' => 'Proses Belajar Mengajar',
                    'icon' => 'fas fa-chalkboard-teacher',
                    'active_check' =>
                        'perkuliahan/kelas*|perkuliahan/krs*|perkuliahan/validasi-krs*|perkuliahan/input-nilai*|perkuliahan/khs*',
                    'submenu' => [
                        [
                            'title' => 'Penawaran Kelas',
                            'route' => 'kelas.index',
                            'active_check' => 'perkuliahan/kelas*',
                        ],
                        ['title' => 'Pengisian KRS', 'route' => 'krs.index', 'active_check' => 'perkuliahan/krs*'],
                        [
                            'title' => 'Validasi KRS',
                            'route' => 'krs.validasi',
                            'active_check' => 'perkuliahan/validasi-krs*',
                        ],
                        [
                            'title' => 'Input Nilai (Dosen)',
                            'route' => 'nilai.input',
                            'active_check' => 'perkuliahan/input-nilai*',
                        ],
                        ['title' => 'KHS (Mahasiswa)', 'route' => 'khs.index', 'active_check' => 'perkuliahan/khs*'],
                    ],
                ],
            ];
        @endphp
        <aside
            class="fixed inset-y-0 left-0 z-30 w-64 bg-unmaris-blue text-white transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-auto flex flex-col"
            :class="{ 'translate-x-0': sidebarOpen }" x-cloak>
            {{-- Header Logo & Title --}}
            <div class="p-4 flex-shrink-0">
                <a href="{{ route('dashboard') }}" class="flex flex-col items-center">
                    <img src="{{ asset('logo.png') }}" alt="Logo UNMARIS" class="h-16 w-auto">
                    <h2 class="text-center text-xl font-bold text-unmaris-yellow mt-2">
                        SIAKAD UNMARIS
                    </h2>
                </a>
            </div>

            {{-- Menu Items PHP Array --}}
            @php
                // ----------------------------------------------------------------------------------------------------------------------
                // ** MENU DATA STRUCTURE (DEFINE MENU HIERARCHY HERE) **
                // ----------------------------------------------------------------------------------------------------------------------
                $menuItems = [
                    [
                        'title' => 'Dashboard',
                        'route' => 'dashboard',
                        'icon' => 'fas fa-tachometer-alt',
                        'active_check' => 'dashboard',
                    ],
                    [
                        'title' => 'Manajemen Website & Data',
                        'heading' => true,
                    ],
                    [
                        'title' => 'Data Dasar',
                        'icon' => 'fas fa-database',
                        'active_check' =>
                            'manajemen/fakultas*|manajemen/prodi*|manajemen/tahun-akademik*|admin/kaprodi*|admin/dekan*',
                        'submenu' => [
                            [
                                'title' => 'Fakultas',
                                'route' => 'fakultas.index',
                                'active_check' => 'manajemen/fakultas*',
                            ],
                            [
                                'title' => 'Program Studi',
                                'route' => 'prodi.index',
                                'active_check' => 'manajemen/prodi*',
                            ],
                            [
                                'title' => 'Tahun Akademik',
                                'route' => 'tahun-akademik.index',
                                'active_check' => 'manajemen/tahun-akademik*',
                            ],
                            ['title' => 'Dekan', 'route' => 'admin.dekan', 'active_check' => 'admin/dekan*'],
                            ['title' => 'Kaprodi', 'route' => 'admin.kaprodi', 'active_check' => 'admin/kaprodi*'],
                        ],
                    ],
                    [
                        'title' => 'Website',
                        'icon' => 'fas fa-cogs',
                        'active_check' =>
                            'manajemen/halaman*|manajemen/pengaturan*|manajemen/kategori*|manajemen/berita*|manajemen/slider*|manajemen/pmb-gelombang*|baca/berita*|admin/pengumuman*',
                        'submenu' => [
                            [
                                'title' => 'Banner Depan',
                                'route' => 'sliders.index',
                                'active_check' => 'manajemen/slider*',
                            ],
                            [
                                'title' => 'Halaman Statis',
                                'route' => 'pages.index',
                                'active_check' => 'manajemen/halaman*',
                            ],
                            [
                                'title' => 'Pengaturan Website',
                                'route' => 'settings.index',
                                'active_check' => 'manajemen/pengaturan*',
                            ],
                            [
                                'title' => 'Kategori Berita',
                                'route' => 'categories.index',
                                'active_check' => 'manajemen/kategori*',
                            ],
                            [
                                'title' => 'Berita',
                                'route' => 'posts.index',
                                'active_check' => 'manajemen/berita*|baca/berita*',
                            ],
                            [
                                'title' => 'Pengumuman',
                                'route' => 'admin.pengumuman',
                                'active_check' => 'admin/pengumuman*',
                            ],
                            [
                                'title' => 'Gelombang PMB',
                                'route' => 'pmb-gelombang.index',
                                'active_check' => 'manajemen/pmb-gelombang*',
                            ],
                        ],
                    ],
                    [
                        'title' => 'LPM',
                        'icon' => 'fas fa-certificate',
                        // Pastikan rute di Livewire Component (yang Anda buat sebelumnya) sudah terdaftar
                        'active_check' => 'manajemen/quality-documents*|manajemen/quality-announcements*',
                        'submenu' => [
                            [
                                'title' => 'Quality Documents',
                                'route' => 'quality-documents.index',
                                'active_check' => 'manajemen/quality-documents*',
                            ],
                            [
                                'title' => 'Quality Announcements',
                                'route' => 'quality-announcements.index',
                                'active_check' => 'manajemen/quality-announcements*',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Akademik & User',
                        'heading' => true,
                    ],
                    [
                        'title' => 'Data User',
                        'icon' => 'fas fa-users',
                        'active_check' => 'akademik/mahasiswa*|akademik/dosen*|admin/penugasan-dosen*',
                        'submenu' => [
                            [
                                'title' => 'Mahasiswa',
                                'route' => 'mahasiswa.index',
                                'active_check' => 'akademik/mahasiswa*',
                            ],
                            ['title' => 'Dosen', 'route' => 'dosen.index', 'active_check' => 'akademik/dosen*'],
                            [
                                'title' => 'Penugasa Dosen',
                                'route' => 'admin.penugasan',
                                'active_check' => 'admin/penugasan-dosen*',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Kurikulum',
                        'icon' => 'fas fa-book',
                        'active_check' => 'akademik/mata-kuliah*|manajemen/kurikulum*',
                        'submenu' => [
                            [
                                'title' => 'Kurikulum',
                                'route' => 'kurikulum.index',
                                'active_check' => 'manajemen/kurikulum*',
                            ],
                            [
                                'title' => 'Mata Kuliah',
                                'route' => 'matakuliah.index',
                                'active_check' => 'akademik/mata-kuliah*',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Perkuliahan',
                        'heading' => true,
                    ],
                    [
                        'title' => 'Proses B-M',
                        'icon' => 'fas fa-chalkboard-teacher',
                        'active_check' =>
                            'perkuliahan/kelas*|perkuliahan/krs*|perkuliahan/validasi-krs*|perkuliahan/input-nilai*|perkuliahan/khs*',
                        'submenu' => [
                            [
                                'title' => 'Penawaran Kelas',
                                'route' => 'kelas.index',
                                'active_check' => 'perkuliahan/kelas*',
                            ],
                            ['title' => 'Pengisian KRS', 'route' => 'krs.index', 'active_check' => 'perkuliahan/krs*'],
                            [
                                'title' => 'Validasi KRS',
                                'route' => 'krs.validasi',
                                'active_check' => 'perkuliahan/validasi-krs*',
                            ],
                            [
                                'title' => 'Input Nilai (Dosen)',
                                'route' => 'nilai.input',
                                'active_check' => 'perkuliahan/input-nilai*',
                            ],
                            [
                                'title' => 'KHS (Mahasiswa)',
                                'route' => 'khs.index',
                                'active_check' => 'perkuliahan/khs*',
                            ],
                        ],
                    ],
                ];
                // Function untuk mengecek status aktif
                $isActive = function ($check) {
                    $checks = explode('|', $check);
                    foreach ($checks as $c) {
                        if (request()->is($c)) {
                            return true;
                        }
                    }
                    return false;
                };
            @endphp

            {{-- Navigasi Menu --}}
            <nav class="flex-1 overflow-y-auto px-2 space-y-1 pb-4">

                @foreach ($menuItems as $item)
                    @if (isset($item['heading']))
                        {{-- Kategori Utama (Heading) --}}
                        <p class="px-4 pt-4 pb-2 text-xs font-semibold text-unmaris-yellow/50 uppercase">
                            {{ $item['title'] }}
                        </p>
                    @elseif (isset($item['submenu']))
                        {{-- Menu dengan Submenu --}}
                        @php
                            $isParentActive = $isActive($item['active_check']);
                        @endphp
                        <div x-data="{ open: @json($isParentActive) }" class="transition duration-200">
                            <button @click="open = !open"
                                class="w-full flex justify-between items-center py-2.5 px-4 rounded transition duration-200
                        @if ($isParentActive) bg-unmaris-yellow text-unmaris-blue font-medium @else hover:bg-unmaris-yellow hover:text-unmaris-blue @endif">
                                <span>
                                    <i class="{{ $item['icon'] }} w-4 mr-2"></i>
                                    {{ $item['title'] }}
                                </span>
                                <i class="fas fa-chevron-down w-4 h-4 transition-transform"
                                    :class="{ 'transform rotate-180': open }"></i>
                            </button>

                            <div x-show="open" x-collapse.duration.300ms>
                                <ul class="pl-6 space-y-1 mt-1 border-l border-unmaris-yellow/50">
                                    @foreach ($item['submenu'] as $subitem)
                                        <a href="{{ route($subitem['route']) }}" wire:navigate
                                            class="block py-2 px-4 rounded transition duration-200 text-sm
                                    @if ($isActive($subitem['active_check'])) bg-unmaris-yellow/20 text-unmaris-yellow font-medium @else hover:bg-unmaris-yellow/10 @endif">
                                            {{ $subitem['title'] }}
                                        </a>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @else
                        {{-- Menu Tanpa Submenu (Single Link) --}}
                        @php
                            $isLinkActive = $isActive($item['active_check']);
                        @endphp
                        <a href="{{ route($item['route']) }}" wire:navigate
                            class="block py-2.5 px-4 rounded transition duration-200 flex items-center
                    @if ($isLinkActive) bg-unmaris-yellow text-unmaris-blue font-medium @else hover:bg-unmaris-yellow hover:text-unmaris-blue @endif">
                            <i class="{{ $item['icon'] ?? 'fas fa-link' }} w-4 mr-2"></i>
                            {{ $item['title'] }}
                        </a>
                    @endif
                @endforeach

            </nav>
        </aside>
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-20 bg-black/50 lg:hidden" x-cloak>
        </div>
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="flex justify-between items-center p-4 bg-white border-b">
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none lg:hidden mr-3">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 6H20M4 12H20M4 18H20" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </button>

                    <h1 class="text-2xl font-semibold text-gray-700">
                        {{ $header ?? 'Dashboard' }}
                    </h1>
                </div>

                <div class="relative" x-data="{ open: false }" @click.outside="open = false">

                    <button @click="open = !open"
                        class="flex items-center text-sm font-semibold text-gray-700 hover:text-unmaris-blue transition duration-150 ease-in-out">
                        <div>{{ Auth::user()->name }}</div>

                        <div class="ms-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>

                    <div x-show="open" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute z-50 mt-2 w-48 rounded-md shadow-lg right-0" style="display: none;"
                        @click="open = false" x-cloak>
                        <div class="rounded-md ring-1 ring-black ring-opacity-5 bg-white py-1">
                            <a href="{{ route('profile') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Profile
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>

</html>
