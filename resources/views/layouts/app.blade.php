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
    @livewireStyles
    @trixassets
</head>
<body class="font-sans antialiased">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-100">
        <aside class="fixed inset-y-0 left-0 z-30 w-64 bg-unmaris-blue text-white transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-auto flex flex-col" :class="{'translate-x-0': sidebarOpen}" x-cloak>
            <div class="p-4 flex-shrink-0">
                <a href="/">
                    <img src="{{ asset('logo.png') }}" alt="Logo UNMARIS" class="h-16 w-auto mx-auto">
                </a>
                <h2 class="text-center text-xl font-semibold text-unmaris-yellow mt-2">
                    SIAKAD UNMARIS
                </h2>
            </div>

            <nav class="flex-1 overflow-y-auto px-2 space-y-1 pb-4">

                <a href="{{ route('dashboard') }}" @class([ 'block py-2.5 px-4 rounded transition duration-200' , 'bg-unmaris-yellow text-unmaris-blue font-medium'=> request()->is('dashboard'),
                    'hover:bg-unmaris-yellow hover:text-unmaris-blue' => !request()->is('dashboard')
                    ])>
                    Dashboard
                </a>

                <p class="px-4 pt-4 pb-2 text-xs font-semibold text-unmaris-yellow/50 uppercase">
                    Manajemen
                </p>
                <a href="{{ route('fakultas.index') }}" @class([ 'block py-2.5 px-4 rounded transition duration-200' , 'bg-unmaris-yellow text-unmaris-blue font-medium'=> request()->is('manajemen/fakultas*'),
                    'hover:bg-unmaris-yellow hover:text-unmaris-blue' => !request()->is('manajemen/fakultas*')
                    ])>
                    Fakultas
                </a>
                <a href="{{ route('prodi.index') }}" @class([ 'block py-2.5 px-4 rounded transition duration-200' , 'bg-unmaris-yellow text-unmaris-blue font-medium'=> request()->is('manajemen/prodi*'),
                    'hover:bg-unmaris-yellow hover:text-unmaris-blue' => !request()->is('manajemen/prodi*')
                    ])>
                    Program Studi
                </a>
                <a href="{{ route('tahun-akademik.index') }}" @class([ 'block py-2.5 px-4 rounded transition duration-200' , 'bg-unmaris-yellow text-unmaris-blue font-medium'=> request()->is('manajemen/tahun-akademik*'),
                    'hover:bg-unmaris-yellow hover:text-unmaris-blue' => !request()->is('manajemen/tahun-akademik*')
                    ])>
                    Tahun Akademik
                </a>

                <a href="{{ route('pages.index') }}" @class([ 'block py-2.5 px-4 rounded transition duration-200' , 'bg-unmaris-yellow text-unmaris-blue font-medium'=> request()->is('manajemen/halaman*'),
                    'hover:bg-unmaris-yellow hover:text-unmaris-blue' => !request()->is('manajemen/halaman*')
                    ])>
                    Halaman Statis
                </a>
                <a href="{{ route('settings.index') }}" @class([ 'block py-2.5 px-4 rounded transition duration-200' , 'bg-unmaris-yellow text-unmaris-blue font-medium'=> request()->is('manajemen/pengaturan*'),
                    'hover:bg-unmaris-yellow hover:text-unmaris-blue' => !request()->is('manajemen/pengaturan*')
                    ])>
                    Pengaturan Website
                </a>
                <a href="{{ route('categories.index') }}" @class([ 'block py-2.5 px-4 rounded transition duration-200' , 'bg-unmaris-yellow text-unmaris-blue font-medium'=> request()->is('manajemen/kategori*'),
                    'hover:bg-unmaris-yellow hover:text-unmaris-blue' => !request()->is('manajemen/kategori*')
                    ])>
                    Kategori Berita
                </a>
                <a href="{{ route('posts.index') }}" @class([ 'block py-2.5 px-4 rounded transition duration-200' , 'bg-unmaris-yellow text-unmaris-blue font-medium'=> request()->is('manajemen/berita*'),
                    'hover:bg-unmaris-yellow hover:text-unmaris-blue' => !request()->is('manajemen/berita*')
                    ])>
                    Berita
                </a>
                <p class="px-4 pt-4 pb-2 text-xs font-semibold text-unmaris-yellow/50 uppercase">
                    Akademik
                </p>
                <a href="{{ route('mahasiswa.index') }}" @class([ 'block py-2.5 px-4 rounded transition duration-200' , 'bg-unmaris-yellow text-unmaris-blue font-medium'=> request()->is('akademik/mahasiswa*'),
                    'hover:bg-unmaris-yellow hover:text-unmaris-blue' => !request()->is('akademik/mahasiswa*')
                    ])>
                    Mahasiswa
                </a>
                <a href="{{ route('dosen.index') }}" @class([ 'block py-2.5 px-4 rounded transition duration-200' , 'bg-unmaris-yellow text-unmaris-blue font-medium'=> request()->is('akademik/dosen*'),
                    'hover:bg-unmaris-yellow hover:text-unmaris-blue' => !request()->is('akademik/dosen*')
                    ])>
                    Dosen
                </a>
                <a href="{{ route('matakuliah.index') }}" @class([ 'block py-2.5 px-4 rounded transition duration-200' , 'bg-unmaris-yellow text-unmaris-blue font-medium'=> request()->is('akademik/mata-kuliah*'),
                    'hover:bg-unmaris-yellow hover:text-unmaris-blue' => !request()->is('akademik/mata-kuliah*')
                    ])>
                    Mata Kuliah
                </a>

                <p class="px-4 pt-4 pb-2 text-xs font-semibold text-unmaris-yellow/50 uppercase">
                    Perkuliahan
                </p>
                <a href="{{ route('kelas.index') }}" @class([ 'block py-2.5 px-4 rounded transition duration-200' , 'bg-unmaris-yellow text-unmaris-blue font-medium'=> request()->is('perkuliahan/kelas*'),
                    'hover:bg-unmaris-yellow hover:text-unmaris-blue' => !request()->is('perkuliahan/kelas*')
                    ])>
                    Penawaran Kelas
                </a>
                <a href="{{ route('krs.index') }}" @class([ 'block py-2.5 px-4 rounded transition duration-200' , 'bg-unmaris-yellow text-unmaris-blue font-medium'=> request()->is('perkuliahan/krs*'),
                    'hover:bg-unmaris-yellow hover:text-unmaris-blue' => !request()->is('perkuliahan/krs*')
                    ])>
                    Pengisian KRS
                </a>
                <a href="{{ route('krs.validasi') }}" @class([ 'block py-2.5 px-4 rounded transition duration-200' , 'bg-unmaris-yellow text-unmaris-blue font-medium'=> request()->is('perkuliahan/validasi-krs*'),
                    'hover:bg-unmaris-yellow hover:text-unmaris-blue' => !request()->is('perkuliahan/validasi-krs*')
                    ])>
                    Validasi KRS
                </a>
                <a href="{{ route('nilai.input') }}" @class([ 'block py-2.5 px-4 rounded transition duration-200' , 'bg-unmaris-yellow text-unmaris-blue font-medium'=> request()->is('perkuliahan/input-nilai*'),
                    'hover:bg-unmaris-yellow hover:text-unmaris-blue' => !request()->is('perkuliahan/input-nilai*')
                    ])>
                    Input Nilai (Dosen)
                </a>
                <a href="{{ route('khs.index') }}" @class([ 'block py-2.5 px-4 rounded transition duration-200' , 'bg-unmaris-yellow text-unmaris-blue font-medium'=> request()->is('perkuliahan/khs*'),
                    'hover:bg-unmaris-yellow hover:text-unmaris-blue' => !request()->is('perkuliahan/khs*')
                    ])>
                    KHS (Mahasiswa)
                </a>
            </nav>
        </aside>
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-20 bg-black/50 lg:hidden" x-cloak></div>
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="flex justify-between items-center p-4 bg-white border-b">
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none lg:hidden mr-3">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 6H20M4 12H20M4 18H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </button>

                    <h1 class="text-2xl font-semibold text-gray-700">
                        {{ $header ?? 'Dashboard' }}
                    </h1>
                </div>

                <div class="relative" x-data="{ open: false }" @click.outside="open = false">

                    <button @click="open = !open" class="flex items-center text-sm font-semibold text-gray-700 hover:text-unmaris-blue transition duration-150 ease-in-out">
                        <div>{{ Auth::user()->name }}</div>

                        <div class="ms-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>

                    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute z-50 mt-2 w-48 rounded-md shadow-lg right-0" style="display: none;" @click="open = false" x-cloak>
                        <div class="rounded-md ring-1 ring-black ring-opacity-5 bg-white py-1">
                            <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
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

    @livewireScripts
</body>
</html>
