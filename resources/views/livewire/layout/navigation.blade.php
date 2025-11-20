<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;
use App\Models\Page;
use App\Models\Fakultas;
use App\Models\ProgramStudi;
use App\Models\DokumenKategori; 
new class extends Component
{
    public $pages;
    public $fakultas_list;
    public $doc_categories; 
    public $akreditasi_summary; 

    public function mount()
    {
        // Ambil data page
        $this->pages = Page::where('status', 'Published')->get();
        $this->fakultas_list = Fakultas::withCount('programStudis')->get();
        $this->doc_categories = DokumenKategori::all(); 
         $thisdi_list = ProgramStudi::select('nama_prodi', 'akreditasi')->get();
         $this->akreditasi_summary = [
            'institusi' => 'BAIK SEKALI',
            'prodi_count' => $thisdi_list->count(),
            'prodi_unggul' => $thisdi_list->where('akreditasi', 'Unggul')->count(),
            'prodi_baik_sekali' => $thisdi_list->where('akreditasi', 'Baik Sekali')->count(),
        ];
    }

    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false, profil: false, lpm: false, scrolled: false , akademik: false,  dokumen: false, lpm :false}"
     x-init="window.addEventListener('scroll', () => { scrolled = (window.scrollY > 10) })"
     :class="scrolled ? 'backdrop-blur-xl bg-unmaris-blue/90 shadow-2xl border-b border-white/10' : 'bg-transparent backdrop-blur-sm'"
     class="fixed w-full z-50 transition-all duration-500 text-white">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="/" class="flex items-center gap-3 group">
                    <div class="relative">
                        <div class="absolute -inset-1 bg-unmaris-yellow rounded-full blur opacity-25 group-hover:opacity-75 transition duration-500"></div>
                        <img src="{{ asset('logo.png') }}" alt="Logo" class="h-11 w-auto relative">
                    </div>
                    <div class="flex flex-col">
                        <span class="font-bold text-xl leading-none tracking-tight">UNMARIS</span>
                        <span class="text-[0.65rem] text-unmaris-yellow tracking-widest uppercase font-medium">Universitas Stella Maris Sumba</span>
                    </div>
                </a>
            </div>
            <!-- Desktop Menu -->
            <div class="hidden md:flex space-x-1 items-center font-medium text-sm">
                <div x-data="{ openSub: false }" class="relative group" @mouseleave="openSub = false">
                    <button @mouseover="openSub = true"
                            class="px-4 py-2 rounded-full hover:bg-white/10 transition duration-300 flex items-center gap-1 group-hover:text-unmaris-yellow {{ request()->is('page*') ? 'text-unmaris-yellow bg-white/10' : '' }}">
                        Profil
                        <svg class="h-3 w-3 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="openSub"
                    x-cloak style="display: none;"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-2"
                         class="absolute left-1/2 transform -translate-x-1/2 top-full pt-4 w-screen max-w-4xl px-4 sm:px-0 z-50">

                        <div class="overflow-hidden rounded-2xl shadow-2xl ring-1 ring-black ring-opacity-5 bg-white">
                            <div class="grid grid-cols-12 gap-0">
                                <!-- Left: Featured Section -->
                                <div class="col-span-4 bg-gray-50 p-6 flex flex-col justify-between relative overflow-hidden">
                                    <div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 rounded-full bg-unmaris-blue/5 blur-2xl"></div>
                                    <div class="relative z-10">
                                        <h3 class="text-lg font-bold text-unmaris-blue mb-2">Tentang UNMARIS</h3>
                                        <p class="text-xs text-gray-500 leading-relaxed mb-4">
                                            Kenali lebih dalam tentang sejarah, visi, misi, dan struktur organisasi kampus UNMARIS.
                                        </p>
                                        <img src="{{ asset('logo.png') }}" class="w-16 h-auto opacity-80 grayscale hover:grayscale-0 transition duration-500 mb-4">
                                    </div>
                                </div>

                                <!-- Right: Bento Grid Links -->
                                <div class="col-span-8 p-6 bg-white">
                                    <div class="grid grid-cols-2 gap-4">
                                        @if($pages && $pages->count() > 0)
                                            @foreach($pages as $page)
                                                <a href="{{ url('page/' . $page->slug) }}"
                                                   class="group/item flex items-start p-3 rounded-xl hover:bg-unmaris-blue/5 transition duration-200 border border-transparent hover:border-unmaris-blue/10">
                                                    <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-unmaris-blue/10 text-unmaris-blue flex items-center justify-center text-xs font-bold group-hover/item:bg-unmaris-blue group-hover/item:text-white transition duration-200">
                                                        {{ substr($page->title, 0, 2) }}
                                                    </div>
                                                    <div class="ml-3">
                                                        <p class="text-sm font-bold text-gray-800 group-hover/item:text-unmaris-blue transition">
                                                            {{ $page->title }}
                                                        </p>
                                                        <p class="text-[10px] text-gray-400 mt-0.5 group-hover/item:text-gray-500">
                                                            Klik untuk melihat detail
                                                        </p>
                                                    </div>
                                                </a>
                                            @endforeach
                                        @else
                                            <div class="col-span-2 text-center py-4 text-gray-400 text-sm italic">
                                                Belum ada halaman profil.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-6 py-3 border-t border-gray-100 flex justify-between items-center">
                                <span class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Navigasi Cepat</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div x-data="{ openAkademik: false }" class="relative group" @mouseleave="openAkademik = false">
                    <button @mouseover="openAkademik = true" 
                            class="px-4 py-2 rounded-full hover:bg-white/10 transition duration-300 flex items-center gap-1 group-hover:text-unmaris-yellow {{ request()->is('fakultas*') ? 'text-unmaris-yellow bg-white/10' : '' }}">
                        Akademik
                        <svg class="h-3 w-3 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="openAkademik" 
                          x-cloak style="display: none;"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-2"
                         class="absolute left-1/2 transform -translate-x-1/2 top-full pt-4 w-screen max-w-4xl px-4 sm:px-0 z-50">
                        
                        <div class="overflow-hidden rounded-2xl shadow-2xl ring-1 ring-black ring-opacity-5 bg-white">
                            <div class="grid grid-cols-12 gap-0">
                                <!-- Left: Featured Section -->
                                <div class="col-span-4 bg-unmaris-yellow/5 p-6 flex flex-col justify-between relative overflow-hidden">
                                    <div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 rounded-full bg-unmaris-yellow/20 blur-2xl"></div>
                                    <div class="relative z-10">
                                        <h3 class="text-lg font-bold text-unmaris-blue mb-2">Fakultas & Prodi</h3>
                                        <p class="text-xs text-gray-600 leading-relaxed mb-4">
                                            Temukan program studi yang sesuai dengan minat dan bakat Anda di berbagai fakultas unggulan kami.
                                        </p>
                                        <div class="flex items-center space-x-2 text-unmaris-yellow font-bold text-4xl opacity-20">
                                            <i class="fas fa-graduation-cap"></i>
                                        </div>
                                    </div>
                                    <a href="/pmb" class="inline-flex items-center text-xs font-bold text-unmaris-blue hover:text-unmaris-yellow transition group/link mt-4">
                                        Info Pendaftaran
                                        <svg class="ml-2 w-3 h-3 transition-transform group-hover/link:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    </a>
                                </div>

                                <!-- Right: Grid Fakultas -->
                                <div class="col-span-8 p-6 bg-white">
                                    <div class="grid grid-cols-2 gap-4">
                                        @foreach($fakultas_list as $f)
                                            @php
                                                $icon = 'fas fa-university';
                                                if(Str::contains($f->nama_fakultas, 'Teknik')) $icon = 'fas fa-laptop-code';
                                                elseif(Str::contains($f->nama_fakultas, ['Ekonomi', 'Bisnis'])) $icon = 'fas fa-chart-line';
                                                elseif(Str::contains($f->nama_fakultas, ['Guru', 'Pendidikan'])) $icon = 'fas fa-chalkboard-teacher';
                                                elseif(Str::contains($f->nama_fakultas, ['Pertanian', 'Sains'])) $icon = 'fas fa-leaf';
                                            @endphp
                                            <a href="{{ route('fakultas.show', $f->id) }}" 
                                               class="group/item flex items-start p-3 rounded-xl hover:bg-unmaris-blue/5 transition duration-200 border border-transparent hover:border-unmaris-blue/10">
                                                <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-unmaris-blue/10 text-unmaris-blue flex items-center justify-center text-xs font-bold group-hover/item:bg-unmaris-blue group-hover/item:text-white transition duration-200">
                                                    <i class="{{ $icon }}"></i>
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-sm font-bold text-gray-800 group-hover/item:text-unmaris-blue transition">{{ $f->nama_fakultas }}</p>
                                                    <p class="text-[10px] text-gray-400 mt-0.5">{{ $f->program_studis_count }} Program Studi</p>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div x-data="{ openAkreditasi: false }" class="relative group" @mouseleave="openAkreditasi = false">
                    <button @mouseover="openAkreditasi = true"
                            class="px-4 py-2 rounded-full hover:bg-white/10 transition duration-300 flex items-center gap-1 group-hover:text-unmaris-yellow {{ request()->is('akreditasi*') ? 'text-unmaris-yellow bg-white/10' : '' }}">
                        Akreditasi
                        <svg class="h-3 w-3 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="openAkreditasi"
                         x-cloak style="display: none;"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-2"
                         class="absolute left-1/2 transform -translate-x-1/2 top-full pt-4 w-screen max-w-4xl px-4 sm:px-0 z-50">
                        
                        <div class="overflow-hidden rounded-2xl shadow-2xl ring-1 ring-black ring-opacity-5 bg-white">
                            <div class="grid grid-cols-12 gap-0">
                                
                                <!-- Left: Summary Stats -->
                                <div class="col-span-4 bg-unmaris-blue/5 p-6 flex flex-col justify-between relative overflow-hidden">
                                    <div class="relative z-10">
                                        <h3 class="text-xl font-bold text-unmaris-blue mb-2">Akreditasi Institusi</h3>
                                        <div class="bg-unmaris-yellow/80 text-unmaris-blue p-3 rounded-lg text-center font-extrabold text-2xl mb-4 shadow-md">
                                            {{ $akreditasi_summary['institusi'] ?? 'BAIK SEKALI' }}
                                        </div>
                                        <p class="text-xs text-gray-600 leading-relaxed">
                                            Komitmen mutu diakui oleh BAN-PT. Lihat detail akreditasi program studi.
                                        </p>
                                    </div>
                                    <div class="mt-4 pt-4 border-t border-gray-200 space-y-2">
                                        <div class="text-sm font-bold text-gray-700">Total Prodi: <span class="text-unmaris-blue">{{ $akreditasi_summary['prodi_count'] }}</span></div>
                                    </div>
                                </div>

                                <!-- Right: Grid Links -->
                                <div class="col-span-8 p-6 bg-white">
                                    <div class="grid grid-cols-2 gap-4">
                                        <a href="/akreditasi/institusi" class="group/item flex items-start p-3 rounded-xl hover:bg-unmaris-blue/5 transition duration-200 border border-transparent hover:border-unmaris-blue/10">
                                            <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-unmaris-blue/10 text-unmaris-blue flex items-center justify-center text-xs font-bold group-hover/item:bg-unmaris-blue group-hover/item:text-white transition duration-200">
                                                <i class="fas fa-certificate"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-bold text-gray-800 group-hover/item:text-unmaris-blue transition">Akreditasi Institusi</p>
                                                <p class="text-[10px] text-gray-400 mt-0.5">Sertifikat & SK BAN-PT</p>
                                            </div>
                                        </a>

                                        <a href="/akreditasi/program-studi" class="group/item flex items-start p-3 rounded-xl hover:bg-unmaris-blue/5 transition duration-200 border border-transparent hover:border-unmaris-blue/10">
                                            <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-unmaris-blue/10 text-unmaris-blue flex items-center justify-center text-xs font-bold group-hover/item:bg-unmaris-blue group-hover/item:text-white transition duration-200">
                                                <i class="fas fa-list-ol"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-bold text-gray-800 group-hover/item:text-unmaris-blue transition">Daftar Akreditasi Prodi</p>
                                                <p class="text-[10px] text-gray-400 mt-0.5">Status Unggul, Baik Sekali, dst.</p>
                                            </div>
                                        </a>

                                        <a href="{{ route('lpm.index') }}" class="group/item flex items-start p-3 rounded-xl hover:bg-unmaris-blue/5 transition duration-200 border border-transparent hover:border-unmaris-blue/10">
                                            <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-unmaris-yellow/10 text-unmaris-yellow flex items-center justify-center text-xs font-bold group-hover/item:bg-unmaris-yellow group-hover/item:text-unmaris-blue transition duration-200">
                                                <i class="fas fa-cogs"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-bold text-gray-800 group-hover/item:text-unmaris-blue transition">Dokumen Mutu Internal</p>
                                                <p class="text-[10px] text-gray-400 mt-0.5">SOP & Manual LPM</p>
                                            </div>
                                        </a>

                                        <a href="/dokumen/pedoman-akreditasi" class="group/item flex items-start p-3 rounded-xl hover:bg-unmaris-blue/5 transition duration-200 border border-transparent hover:border-unmaris-blue/10">
                                            <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-red-100 text-red-600 flex items-center justify-center text-xs font-bold group-hover/item:bg-red-600 group-hover/item:text-white transition duration-200">
                                                <i class="fas fa-file-pdf"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-bold text-gray-800 group-hover/item:text-unmaris-blue transition">Pedoman Akreditasi</p>
                                                <p class="text-[10px] text-gray-400 mt-0.5">Panduan Penyusunan Laporan</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
                {{-- <div x-data="{ openLpm: false }" class="relative group" @mouseleave="openLpm = false">
                    <button @mouseover="openLpm = true"
                            class="px-4 py-2 rounded-full hover:bg-white/10 transition duration-300 flex items-center gap-1 group-hover:text-unmaris-yellow {{ request()->is('lpm*') ? 'text-unmaris-yellow bg-white/10' : '' }}">
                        LPM
                        <svg class="h-3 w-3 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="openLpm"
                        x-cloak style="display: none;"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-2"
                         class="absolute left-1/2 transform -translate-x-1/2 top-full pt-4 w-screen max-w-4xl px-4 sm:px-0 z-50">

                        <div class="overflow-hidden rounded-2xl shadow-2xl ring-1 ring-black ring-opacity-5 bg-white">
                            <div class="grid grid-cols-12 gap-0">

                                <!-- Left: Featured Section LPM -->
                                <div class="col-span-4 bg-unmaris-blue/5 p-6 flex flex-col justify-between relative overflow-hidden">
                                    <div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 rounded-full bg-unmaris-yellow/10 blur-2xl"></div>

                                    <div class="relative z-10">
                                        <h3 class="text-lg font-bold text-unmaris-blue mb-2">Penjaminan Mutu</h3>
                                        <p class="text-xs text-gray-500 leading-relaxed mb-4">
                                            Komitmen kami dalam menjaga dan meningkatkan standar mutu pendidikan melalui siklus PPEPP berkelanjutan.
                                        </p>
                                        <div class="flex items-center space-x-2 text-unmaris-blue font-bold text-4xl opacity-20">
                                            <i class="fas fa-certificate"></i>
                                        </div>
                                    </div>

                                    <a href="{{ route('lpm.index') }}" class="inline-flex items-center text-xs font-bold text-unmaris-blue hover:text-unmaris-yellow transition group/link mt-4">
                                        Kunjungi Portal LPM
                                        <svg class="ml-2 w-3 h-3 transition-transform group-hover/link:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    </a>
                                </div>

                                <!-- Right: Bento Grid Links LPM -->
                                <div class="col-span-8 p-6 bg-white">
                                    <div class="grid grid-cols-2 gap-4">

                                        <!-- Item 1: Beranda -->
                                        <a href="{{ route('lpm.index') }}" class="group/item flex items-start p-3 rounded-xl hover:bg-unmaris-blue/5 transition duration-200 border border-transparent hover:border-unmaris-blue/10">
                                            <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-unmaris-blue/10 text-unmaris-blue flex items-center justify-center group-hover/item:bg-unmaris-blue group-hover/item:text-white transition duration-200">
                                                <i class="fas fa-home text-xs"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-bold text-gray-800 group-hover/item:text-unmaris-blue transition">Beranda LPM</p>
                                                <p class="text-[10px] text-gray-400 mt-0.5">Halaman utama pusat mutu</p>
                                            </div>
                                        </a>

                                        <!-- Item 2: Profil -->
                                        <a href="{{ route('lpm.profile') }}" class="group/item flex items-start p-3 rounded-xl hover:bg-unmaris-blue/5 transition duration-200 border border-transparent hover:border-unmaris-blue/10">
                                            <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-unmaris-blue/10 text-unmaris-blue flex items-center justify-center group-hover/item:bg-unmaris-blue group-hover/item:text-white transition duration-200">
                                                <i class="fas fa-user-tie text-xs"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-bold text-gray-800 group-hover/item:text-unmaris-blue transition">Profil & Visi Misi</p>
                                                <p class="text-[10px] text-gray-400 mt-0.5">Struktur organisasi & tujuan</p>
                                            </div>
                                        </a>

                                        <!-- Item 3: Dokumen -->
                                        <a href="{{ route('lpm.index') }}" class="group/item flex items-start p-3 rounded-xl hover:bg-unmaris-blue/5 transition duration-200 border border-transparent hover:border-unmaris-blue/10">
                                            <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-unmaris-blue/10 text-unmaris-blue flex items-center justify-center group-hover/item:bg-unmaris-blue group-hover/item:text-white transition duration-200">
                                                <i class="fas fa-file-alt text-xs"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-bold text-gray-800 group-hover/item:text-unmaris-blue transition">Dokumen Mutu</p>
                                                <p class="text-[10px] text-gray-400 mt-0.5">Arsip SOP, Kebijakan, & Formulir</p>
                                            </div>
                                        </a>

                                        <!-- Item 4: Pengumuman -->
                                        <a href="{{ route('lpm.announcements.all') }}" class="group/item flex items-start p-3 rounded-xl hover:bg-unmaris-blue/5 transition duration-200 border border-transparent hover:border-unmaris-blue/10">
                                            <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-unmaris-blue/10 text-unmaris-blue flex items-center justify-center group-hover/item:bg-unmaris-blue group-hover/item:text-white transition duration-200">
                                                <i class="fas fa-bullhorn text-xs"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-bold text-gray-800 group-hover/item:text-unmaris-blue transition">Pengumuman</p>
                                                <p class="text-[10px] text-gray-400 mt-0.5">Berita terbaru terkait mutu</p>
                                            </div>
                                        </a>

                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-6 py-3 border-t border-gray-100 flex justify-between items-center">
                                <span class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">LPM UNMARIS</span>
                            </div>
                        </div>
                    </div>
                </div> --}}
                {{-- <div x-data="{ openDokumen: false }" class="relative group" @mouseleave="openDokumen = false">
                    <button @mouseover="openDokumen = true" 
                            class="px-4 py-2 rounded-full hover:bg-white/10 transition duration-300 flex items-center gap-1 group-hover:text-unmaris-yellow {{ request()->is('dokumen*') ? 'text-unmaris-yellow bg-white/10' : '' }}">
                        Dokumen
                        <svg class="h-3 w-3 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="openDokumen" 
                         x-cloak style="display: none;"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-2"
                         class="absolute left-1/2 transform -translate-x-1/2 top-full pt-4 w-screen max-w-4xl px-4 sm:px-0 z-50">
                        
                        <div class="overflow-hidden rounded-2xl shadow-2xl ring-1 ring-black ring-opacity-5 bg-white">
                            <div class="grid grid-cols-12 gap-0">
                                <div class="col-span-4 bg-gray-50 p-6 flex flex-col justify-between relative overflow-hidden">
                                    <div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 rounded-full bg-unmaris-blue/5 blur-2xl"></div>
                                    <div class="relative z-10">
                                        <h3 class="text-lg font-bold text-unmaris-blue mb-2">Arsip Digital</h3>
                                        <p class="text-xs text-gray-500 leading-relaxed mb-4">
                                            Unduh panduan akademik, formulir kemahasiswaan, SK Rektor, dan dokumen publik lainnya.
                                        </p>
                                        <div class="flex items-center space-x-2 text-unmaris-blue font-bold text-4xl opacity-20">
                                            <i class="fas fa-folder-open"></i>
                                        </div>
                                    </div>
                                    <a href="{{ route('dokumen.index') }}" class="inline-flex items-center text-xs font-bold text-unmaris-blue hover:text-unmaris-yellow transition group/link mt-4">
                                        Lihat Semua Dokumen
                                        <svg class="ml-2 w-3 h-3 transition-transform group-hover/link:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    </a>
                                </div>
                                <div class="col-span-8 p-6 bg-white">
                                    <div class="grid grid-cols-2 gap-4">
                                        @foreach($doc_categories as $cat)
                                            <a href="{{ route('dokumen.index', ['kategori_id' => $cat->id]) }}" 
                                               class="group/item flex items-start p-3 rounded-xl hover:bg-unmaris-blue/5 transition duration-200 border border-transparent hover:border-unmaris-blue/10">
                                                <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-unmaris-blue/10 text-unmaris-blue flex items-center justify-center text-xs font-bold group-hover/item:bg-unmaris-blue group-hover/item:text-white transition duration-200">
                                                    <i class="fas fa-file-alt"></i>
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-sm font-bold text-gray-800 group-hover/item:text-unmaris-blue transition">{{ $cat->nama }}</p>
                                                    <p class="text-[10px] text-gray-400 mt-0.5">Dokumen terkait {{ Str::lower($cat->nama) }}</p>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div x-data="{ openLife: false }" class="relative group" @mouseleave="openLife = false">
                    <button @mouseover="openLife = true"
                            class="px-4 py-2 rounded-full hover:bg-white/10 transition duration-300 flex items-center gap-1 group-hover:text-unmaris-yellow {{ request()->is('kemahasiswaan*') ? 'text-unmaris-yellow bg-white/10' : '' }}">
                        Kehidupan Kampus
                        <svg class="h-3 w-3 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="openLife"
                         x-cloak style="display: none;"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-2"
                         class="absolute left-1/2 transform -translate-x-1/2 top-full pt-4 w-screen max-w-4xl px-4 sm:px-0 z-50">

                        <div class="overflow-hidden rounded-2xl shadow-2xl ring-1 ring-black ring-opacity-5 bg-white">
                            <div class="grid grid-cols-12 gap-0">
                                <div class="col-span-4 bg-green-50 p-6 flex flex-col justify-between relative overflow-hidden">
                                    <div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 rounded-full bg-green-100 blur-2xl"></div>
                                    <div class="relative z-10">
                                        <h3 class="text-lg font-bold text-green-800 mb-2">Student Life</h3>
                                        <p class="text-xs text-gray-600 leading-relaxed mb-4">
                                            Temukan komunitas, kembangkan bakat, dan raih prestasi di luar ruang kelas.
                                        </p>
                                        <div class="flex items-center space-x-2 text-green-600 font-bold text-4xl opacity-20">
                                            <i class="fas fa-users"></i>
                                        </div>
                                    </div>
                                    <a href="{{ route('kemahasiswaan.index') }}" class="inline-flex items-center text-xs font-bold text-green-700 hover:text-green-900 transition group/link mt-4">
                                        Jelajahi Kegiatan
                                        <svg class="ml-2 w-3 h-3 transition-transform group-hover/link:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    </a>
                                </div>
                                <div class="col-span-8 p-6 bg-white">
                                    <div class="grid grid-cols-2 gap-4">
                                        <a href="{{ route('kemahasiswaan.index') }}" class="group/item flex items-start p-3 rounded-xl hover:bg-unmaris-blue/5 transition duration-200 border border-transparent hover:border-unmaris-blue/10">
                                            <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-green-100 text-green-600 flex items-center justify-center text-xs font-bold group-hover:bg-green-600 group-hover:text-white transition duration-200">
                                                <i class="fas fa-campground"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-bold text-gray-800 group-hover/item:text-unmaris-blue transition">Unit Kegiatan Mahasiswa</p>
                                                <p class="text-[10px] text-gray-400 mt-0.5">BEM, Mapala, Paduan Suara, dll</p>
                                            </div>
                                        </a>
                                        <a href="{{ route('kemahasiswaan.index') }}" class="group/item flex items-start p-3 rounded-xl hover:bg-unmaris-blue/5 transition duration-200 border border-transparent hover:border-unmaris-blue/10">
                                            <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-yellow-100 text-yellow-600 flex items-center justify-center text-xs font-bold group-hover:bg-yellow-500 group-hover:text-white transition duration-200">
                                                <i class="fas fa-trophy"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-bold text-gray-800 group-hover/item:text-unmaris-blue transition">Prestasi Mahasiswa</p>
                                                <p class="text-[10px] text-gray-400 mt-0.5">Hall of Fame Juara</p>
                                            </div>
                                        </a>
                                        <a href="{{ route('fasilitas.index') }}" class="group/item flex items-start p-3 rounded-xl hover:bg-unmaris-blue/5 transition duration-200 border border-transparent hover:border-unmaris-blue/10">
                                            <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-blue-100 text-unmaris-blue flex items-center justify-center text-xs font-bold group-hover:bg-unmaris-blue group-hover:text-white transition duration-200">
                                                <i class="fas fa-building"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-bold text-gray-800 group-hover/item:text-unmaris-blue transition">Fasilitas Kampus</p>
                                                <p class="text-[10px] text-gray-400 mt-0.5">Laboratorium & Sarana Olahraga</p>
                                            </div>
                                        </a>
                                        <a href="#" class="group/item flex items-start p-3 rounded-xl hover:bg-unmaris-blue/5 transition duration-200 border border-transparent hover:border-unmaris-blue/10">
                                            <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center text-xs font-bold group-hover:bg-purple-600 group-hover:text-white transition duration-200">
                                                <i class="fas fa-user-graduate"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-bold text-gray-800 group-hover/item:text-unmaris-blue transition">Alumni & Karir</p>
                                                <p class="text-[10px] text-gray-400 mt-0.5">Tracer study & Info Loker</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 <div x-data="{ openLayanan: false }" class="relative group" @mouseleave="openLayanan = false">
                    <button @mouseover="openLayanan = true"
                            class="px-4 py-2 rounded-full hover:bg-white/10 transition duration-300 flex items-center gap-1 group-hover:text-unmaris-yellow">
                        Layanan
                        <svg class="h-3 w-3 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="openLayanan"
                         x-cloak style="display: none;"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-2"
                         class="absolute left-1/2 transform -translate-x-1/2 top-full pt-4 w-screen max-w-4xl px-4 sm:px-0 z-50">

                        <div class="overflow-hidden rounded-2xl shadow-2xl ring-1 ring-black ring-opacity-5 bg-white">
                            <div class="grid grid-cols-12 gap-0">
                                <div class="col-span-4 bg-yellow-50 p-6 flex flex-col justify-between relative overflow-hidden">
                                    <div class="relative z-10">
                                        <h3 class="text-lg font-bold text-gray-800 mb-2">Pusat Layanan</h3>
                                        <p class="text-xs text-gray-600 leading-relaxed mb-4">
                                            Akses cepat ke portal akademik, perpustakaan digital, dan dukungan karir.
                                        </p>
                                        <div class="flex items-center space-x-2 text-yellow-600 font-bold text-4xl opacity-20">
                                            <i class="fas fa-handshake"></i>
                                        </div>
                                    </div>
                                    <a href="/portal/mahasiswa" class="inline-flex items-center text-xs font-bold text-unmaris-blue hover:text-unmaris-yellow transition group/link mt-4">
                                        Portal Mahasiswa
                                        <svg class="ml-2 w-3 h-3 transition-transform group-hover/link:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    </a>
                                </div>
                                <div class="col-span-8 p-6 bg-white">
                                    <div class="grid grid-cols-2 gap-4">
                                        
                                        <a href="{{route('library.index')}}" target="_blank" class="group/item flex items-start p-3 rounded-xl hover:bg-unmaris-blue/5 transition duration-200 border border-transparent hover:border-unmaris-blue/10">
                                            <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-red-100 text-red-600 flex items-center justify-center text-xs font-bold group-hover/item:bg-red-600 group-hover/item:text-white transition duration-200">
                                                <i class="fas fa-book-open"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-bold text-gray-800 group-hover/item:text-unmaris-blue transition">Perpustakaan Digital</p>
                                                <p class="text-[10px] text-gray-400 mt-0.5">Akses e-book dan jurnal</p>
                                            </div>
                                        </a>
                                        <a href="{{ route('lppm.index') }}" target="_blank" class="group/item flex items-start p-3 rounded-xl hover:bg-unmaris-blue/5 transition duration-200 border border-transparent hover:border-unmaris-blue/10">
                                            <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-cyan-100 text-cyan-600 flex items-center justify-center text-xs font-bold group-hover/item:bg-cyan-600 group-hover/item:text-white transition duration-200">
                                                <i class="fas fa-globe"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-bold text-gray-800 group-hover/item:text-unmaris-blue transition">E-Journal / OJS</p>
                                                <p class="text-[10px] text-gray-400 mt-0.5">Publikasi Riset Dosen</p>
                                            </div>
                                        </a>
                                        <a href="#" target="_blank" class="group/item flex items-start p-3 rounded-xl hover:bg-unmaris-blue/5 transition duration-200 border border-transparent hover:border-unmaris-blue/10">
                                            <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-green-100 text-green-600 flex items-center justify-center text-xs font-bold group-hover/item:bg-green-600 group-hover/item:text-white transition duration-200">
                                                <i class="fas fa-search-dollar"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-bold text-gray-800 group-hover/item:text-unmaris-blue transition">Tracer Study & Karir</p>
                                                <p class="text-[10px] text-gray-400 mt-0.5">Info loker & IKA</p>
                                            </div>
                                        </a>
                                        <a href="{{ route('dokumen.index') }}" class="group/item flex items-start p-3 rounded-xl hover:bg-unmaris-blue/5 transition duration-200 border border-transparent hover:border-unmaris-blue/10">
                                            <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center text-xs font-bold group-hover/item:bg-orange-600 group-hover/item:text-white transition duration-200">
                                                <i class="fas fa-file-download"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-bold text-gray-800 group-hover/item:text-unmaris-blue transition">Arsip Dokumen</p>
                                                <p class="text-[10px] text-gray-400 mt-0.5">Panduan & Formulir Publik</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="/berita" class="px-4 py-2 rounded-full hover:bg-white/10 transition duration-300 {{ request()->is('berita*') ||request()->is('baca/berita*')  ? 'text-unmaris-yellow bg-white/10' : '' }}">Berita</a>
                <a href="/lppm" class="px-4 py-2 rounded-full hover:bg-white/10 transition duration-300 {{ request()->is('lppm*') ? 'text-unmaris-yellow bg-white/10' : '' }}">LPPM</a>
                <div class="flex space-x-1 items-center font-medium text-sm">
                    <a href="/kontak" class="px-5 py-2 rounded-full text-white hover:bg-white/10 transition duration-300">Kontak</a>

                    <div class="h-6 w-px bg-white/20 mx-2"></div>

                    <!-- PORTAL LOGIN DROPDOWN -->
                    <div x-data="{ openPortal: false }" class="relative" @mouseleave="openPortal = false">
                        <button @mouseover="openPortal = true" class="flex items-center gap-2 px-5 py-2 bg-white text-unmaris-blue font-bold rounded-full hover:bg-unmaris-yellow transition duration-300 shadow-lg transform hover:-translate-y-0.5">
                            <i class="fas fa-lock text-xs"></i>
                            <span>Portal</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div x-show="openPortal"
                             x-cloak style="display: none;"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-2"
                             class="absolute right-0 top-full pt-4 w-64 z-50">
                            <div class="bg-white rounded-xl shadow-2xl ring-1 ring-black ring-opacity-5 overflow-hidden">
                                <div class="p-4 bg-unmaris-blue text-white">
                                    <h3 class="font-bold text-sm">Akses Civitas</h3>
                                    <p class="text-[10px] text-blue-200">Silakan login sesuai peran Anda</p>
                                </div>
                                <div class="py-2">
                                    <a href="/dashboard" class="flex items-center px-4 py-3 hover:bg-blue-50 transition group">
                                        <div class="w-8 h-8 rounded-lg bg-blue-100 text-unmaris-blue flex items-center justify-center mr-3 group-hover:bg-unmaris-blue group-hover:text-white transition">
                                            <i class="fas fa-user-graduate"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-800">SIAKAD</p>
                                            <p class="text-[10px] text-gray-500">Mahasiswa & Dosen</p>
                                        </div>
                                    </a>
                                    <a href="/e-learning" class="flex items-center px-4 py-3 hover:bg-orange-50 transition group">
                                        <div class="w-8 h-8 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center mr-3 group-hover:bg-orange-600 group-hover:text-white transition">
                                            <i class="fas fa-laptop-code"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-800">E-Learning</p>
                                            <p class="text-[10px] text-gray-500">Kuliah Daring</p>
                                        </div>
                                    </a>
                                    <a href="/admin/login" class="flex items-center px-4 py-3 hover:bg-gray-50 transition group">
                                        <div class="w-8 h-8 rounded-lg bg-gray-100 text-gray-600 flex items-center justify-center mr-3 group-hover:bg-gray-600 group-hover:text-white transition">
                                            <i class="fas fa-cog"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-800">Administrator</p>
                                            <p class="text-[10px] text-gray-500">Login Staff/Admin</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile Hamburger -->
            <div class="flex md:hidden items-center">
                <button @click="open = !open" class="p-2 rounded-md text-white hover:text-unmaris-yellow hover:bg-white/10 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden md:hidden bg-unmaris-blue border-t border-white/10 h-screen overflow-y-auto pb-20">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="/" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-white/10 hover:text-unmaris-yellow">Home</a>
            <div class="space-y-1">
                <button @click="profil = !profil" class="w-full flex justify-between items-center px-3 py-2 rounded-md text-base font-medium hover:bg-white/10 hover:text-unmaris-yellow focus:outline-none">
                    <span>Profil</span>
                    <svg class="h-4 w-4 transition-transform" :class="profil ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </button>
                <div x-show="profil" x-collapse class="pl-4 space-y-1">
                     @foreach($pages as $page)
                        <a href="{{ url('page/' . $page->slug) }}" class="block px-3 py-2 rounded-md text-sm text-gray-300 hover:text-white hover:bg-white/5">{{ $page->title }}</a>
                    @endforeach
                </div>
            </div>
            <div class="space-y-1">
                <button @click="akademik = !akademik" class="w-full flex justify-between items-center px-3 py-2 rounded-md text-base font-medium hover:bg-white/10 hover:text-unmaris-yellow focus:outline-none">
                    <span>Akademik</span>
                    <svg class="h-4 w-4 transition-transform" :class="akademik ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </button>
                <div x-show="akademik" x-collapse class="pl-4 space-y-1">
                     @foreach($fakultas_list as $f)
                        <a href="{{ route('fakultas.show', $f->id) }}" class="block px-3 py-2 rounded-md text-sm text-gray-300 hover:text-white hover:bg-white/5">{{ $f->nama_fakultas }}</a>
                    @endforeach
                </div>
            </div>

            <div class="space-y-1">
                <button @click="lpm = !lpm" class="w-full flex justify-between items-center px-3 py-2 rounded-md text-base font-medium hover:bg-white/10 hover:text-unmaris-yellow focus:outline-none">
                    <span>LPM</span>
                    <svg class="h-4 w-4 transition-transform" :class="lpm ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </button>
                <div x-show="lpm" x-collapse class="pl-4 space-y-1">
                     <a href="{{ route('lpm.index') }}" class="block px-3 py-2 rounded-md text-sm text-gray-300 hover:text-white hover:bg-white/5">Beranda LPM</a>
                     <a href="{{ route('lpm.profile') }}" class="block px-3 py-2 rounded-md text-sm text-gray-300 hover:text-white hover:bg-white/5">Profil LPM</a>
                     <a href="{{ route('lpm.index') }}" class="block px-3 py-2 rounded-md text-sm text-gray-300 hover:text-white hover:bg-white/5">Dokumen Mutu</a>
                     <a href="{{ route('lpm.announcements.all') }}" class="block px-3 py-2 rounded-md text-sm text-gray-300 hover:text-white hover:bg-white/5">Pengumuman</a>
                </div>
            </div>
            <div class="space-y-1">
                <button @click="dokumen = !dokumen" class="w-full flex justify-between items-center px-3 py-2 rounded-md text-base font-medium hover:bg-white/10 hover:text-unmaris-yellow focus:outline-none">
                    <span>Dokumen</span>
                    <svg class="h-4 w-4 transition-transform" :class="dokumen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </button>
                <div x-show="dokumen" x-collapse class="pl-4 space-y-1">
                     <a href="{{ route('dokumen.index') }}" class="block px-3 py-2 rounded-md text-sm text-gray-300 hover:text-white hover:bg-white/5 font-bold">Semua Dokumen</a>
                     @foreach($doc_categories as $cat)
                        <a href="{{ route('dokumen.index', ['kategori_id' => $cat->id]) }}" class="block px-3 py-2 rounded-md text-sm text-gray-300 hover:text-white hover:bg-white/5">{{ $cat->nama }}</a>
                    @endforeach
                </div>
            </div>
             <div class="space-y-1" x-data="{ life: false }">
                <button @click="life = !life" class="w-full flex justify-between items-center px-3 py-2 rounded-md text-base font-medium hover:bg-white/10 hover:text-unmaris-yellow focus:outline-none">
                    <span>Kehidupan Kampus</span>
                    <svg class="h-4 w-4 transition-transform" :class="life ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </button>
                <div x-show="life" x-collapse class="pl-4 space-y-1">
                     <a href="{{ route('kemahasiswaan.index') }}" class="block px-3 py-2 rounded-md text-sm text-gray-300 hover:text-white hover:bg-white/5">UKM & Prestasi</a>
                     <a href="{{ route('fasilitas.index') }}" class="block px-3 py-2 rounded-md text-sm text-gray-300 hover:text-white hover:bg-white/5">Fasilitas Kampus</a>
                </div>
            </div>
            <a href="/berita" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-white/10 hover:text-unmaris-yellow">Berita</a>
            <a href="/lppm" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-white/10 hover:text-unmaris-yellow">LPPM</a>
            <a href="/kontak" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-white/10 hover:text-unmaris-yellow">Kontak</a>
            <div class="border-t border-white/10 my-2 pt-2">
                <p class="px-3 text-xs font-bold text-unmaris-yellow uppercase tracking-wider mb-2">Akses Cepat</p>
                <a href="https://siakad.unmaris.ac.id" class="flex items-center px-3 py-2 rounded-md text-base font-medium hover:bg-white/10 hover:text-white">
                    <i class="fas fa-user-graduate w-6 text-center mr-2 opacity-70"></i> SIAKAD
                </a>
                <a href="https://elearning.unmaris.ac.id" class="flex items-center px-3 py-2 rounded-md text-base font-medium hover:bg-white/10 hover:text-white">
                    <i class="fas fa-laptop-code w-6 text-center mr-2 opacity-70"></i> E-Learning
                </a>
                 <a href="/admin/login" class="flex items-center px-3 py-2 rounded-md text-base font-medium hover:bg-white/10 hover:text-white">
                    <i class="fas fa-cog w-6 text-center mr-2 opacity-70"></i> Login Admin
                </a>
            </div>
        </div>
    </div>
</nav>
