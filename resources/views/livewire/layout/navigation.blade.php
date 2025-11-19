<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;
use App\Models\Page;

new class extends Component
{
    public $pages;

    public function mount()
    {
        // Ambil data page
        $this->pages = Page::where('status', 'Published')->get();
    }

    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false, profil: false, lpm: false, scrolled: false }"
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
                        <span class="text-[0.65rem] text-unmaris-yellow tracking-widest uppercase font-medium">Universitas Maritim</span>
                    </div>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex space-x-1 items-center font-medium text-sm">
                <a href="/" class="px-4 py-2 rounded-full hover:bg-white/10 transition duration-300">Home</a>

                <!-- MEGA MENU PROFIL (MODERN 2025 STYLE) -->
                <div x-data="{ openSub: false }" class="relative group" @mouseleave="openSub = false">
                    <button @mouseover="openSub = true"
                            class="px-4 py-2 rounded-full hover:bg-white/10 transition duration-300 flex items-center gap-1 group-hover:text-unmaris-yellow {{ request()->is('page*') ? 'text-unmaris-yellow bg-white/10' : '' }}">
                        Profil
                        <svg class="h-3 w-3 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="openSub"
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

                <!-- MEGA MENU LPM (UPDATED TO MATCH PROFIL STYLE) -->
                <div x-data="{ openLpm: false }" class="relative group" @mouseleave="openLpm = false">
                    <button @mouseover="openLpm = true"
                            class="px-4 py-2 rounded-full hover:bg-white/10 transition duration-300 flex items-center gap-1 group-hover:text-unmaris-yellow {{ request()->is('lpm*') ? 'text-unmaris-yellow bg-white/10' : '' }}">
                        LPM
                        <svg class="h-3 w-3 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="openLpm"
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
                </div>

                <a href="/berita" class="px-4 py-2 rounded-full hover:bg-white/10 transition duration-300 {{ request()->is('berita*') ? 'text-unmaris-yellow bg-white/10' : '' }}">Berita</a>
                <a href="/kontak" class="px-5 py-2 rounded-full bg-unmaris-yellow text-unmaris-blue font-bold hover:bg-white hover:shadow-lg transition duration-300 transform hover:-translate-y-0.5">Kontak</a>
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

            <!-- Profil Accordion -->
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

            <!-- LPM Accordion -->
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

            <a href="/berita" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-white/10 hover:text-unmaris-yellow">Berita</a>
            <a href="/kontak" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-white/10 hover:text-unmaris-yellow">Kontak</a>
        </div>
    </div>
</nav>
