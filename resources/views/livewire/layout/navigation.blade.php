<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;
use App\Models\Page;
use App\Models\Fakultas;
use App\Models\ProgramStudi;
use App\Models\DokumenKategori;

new class extends Component {
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

<div class="fixed w-full z-[999] transition-all duration-500" x-data="{ scrolled: false, mobileOpen: false }" x-init="window.addEventListener('scroll', () => { scrolled = (window.scrollY > 20) })">

    {{-- 1. TOP BAR (UTILITY) --}}
    <div class="bg-unmaris-blue/95 border-b border-white/10 text-white text-xs py-2 transition-all duration-300"
        :class="scrolled ? '-mt-10 opacity-0 pointer-events-none' : 'block'">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <div class="hidden md:flex gap-6 opacity-80">
                <span><i class="fas fa-phone-alt mr-2 text-unmaris-yellow"></i> +62 812-3456-7890</span>
                <span><i class="fas fa-envelope mr-2 text-unmaris-yellow"></i> info@unmaris.ac.id</span>
            </div>
            <div class="flex gap-4 ml-auto font-bold tracking-wide">
                <a href="https://siakad.unmaris.ac.id" target="_blank"
                    class="hover:text-unmaris-yellow transition flex items-center gap-1">
                    <i class="fas fa-user-graduate"></i> SIAKAD
                </a>
                <div class="w-px h-4 bg-white/20"></div>
                <a href="https://elearning.unmaris.ac.id" target="_blank"
                    class="hover:text-unmaris-yellow transition flex items-center gap-1">
                    <i class="fas fa-laptop-code"></i> E-Learning
                </a>
                <div class="w-px h-4 bg-white/20"></div>
                <a href="/admin/login" class="hover:text-unmaris-yellow transition flex items-center gap-1">
                    <i class="fas fa-lock"></i> Staff
                </a>
            </div>
        </div>
    </div>

    {{-- 2. MAIN NAVBAR --}}
    <nav :class="(scrolled || mobileOpen) ? 'bg-unmaris-blue/95 backdrop-blur-xl shadow-2xl py-2' : 'bg-transparent py-4'"
        class="transition-all duration-500 text-white border-b border-white/5 relative">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">

                {{-- LOGO --}}
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="flex items-center gap-3 group">
                        <img src="{{ asset('logo.png') }}" alt="Logo"
                            class="h-10 w-auto transition-transform group-hover:scale-110">
                        <div class="flex flex-col">
                            <span class="font-bold text-lg leading-none tracking-tight font-serif">UNMARIS</span>
                            <span class="text-[0.6rem] text-unmaris-yellow tracking-widest uppercase font-sans">Stella
                                Maris</span>
                        </div>
                    </a>
                </div>

                {{-- DESKTOP MENU --}}
                <div class="hidden lg:flex space-x-1 items-center font-medium text-sm">

                    {{-- 1. PROFIL --}}
                    <x-nav-dropdown title="Tentang Kami" active="page*">
                        <x-slot:content>
                            <div class="grid grid-cols-2 gap-2 w-[400px] p-4">
                                <div class="col-span-2 mb-2">
                                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Profil
                                        Kampus</span>
                                </div>
                                @foreach ($pages as $page)
                                    @if (!str_starts_with($page->slug, 'lpm-'))
                                        <a href="{{ url('page/' . $page->slug) }}"
                                            class="flex items-center p-2 rounded-lg hover:bg-blue-50 text-gray-600 hover:text-unmaris-blue transition">
                                            <i class="fas fa-chevron-right text-xs mr-2 text-unmaris-yellow"></i>
                                            {{ $page->title }}
                                        </a>
                                    @endif
                                @endforeach
                                <a href="/kontak"
                                    class="flex items-center p-2 rounded-lg hover:bg-blue-50 text-gray-600 hover:text-unmaris-blue transition">
                                    <i class="fas fa-map-marker-alt text-xs mr-2 text-unmaris-yellow"></i> Lokasi &
                                    Kontak
                                </a>
                            </div>
                        </x-slot:content>
                    </x-nav-dropdown>

                    {{-- 2. AKADEMIK --}}
                    <x-nav-dropdown title="Akademik" active="fakultas*">
                        <x-slot:content>
                            <div class="w-[500px] p-4 grid grid-cols-2 gap-4">
                                <div>
                                    <span
                                        class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-2">Fakultas</span>
                                    @foreach ($fakultas_list as $f)
                                        <a href="{{ route('public.fakultas.show', $f->id) }}"
                                            class="block py-1.5 text-gray-600 hover:text-unmaris-blue hover:pl-2 transition-all truncate">
                                            {{ $f->nama_fakultas }}
                                        </a>
                                    @endforeach
                                </div>
                                <div class="bg-gray-50 p-3 rounded-xl">
                                    <span
                                        class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-2">Jalan
                                        Pintas</span>
                                    <a href="/akreditasi/institusi"
                                        class="block py-1 text-sm text-gray-600 hover:text-unmaris-blue">Akreditasi</a>
                                    <a href="#"
                                        class="block py-1 text-sm text-gray-600 hover:text-unmaris-blue">Kalender
                                        Akademik</a>
                                    <a href="#"
                                        class="block py-1 text-sm text-gray-600 hover:text-unmaris-blue">Biaya
                                        Kuliah</a>
                                </div>
                            </div>
                        </x-slot:content>
                    </x-nav-dropdown>

                    {{-- 3. LEMBAGA --}}
                    <x-nav-dropdown title="Lembaga" active="lpm*|lppm*">
                        <x-slot:content>
                            <div class="w-64 p-2">
                                <a href="{{ route('public.lpm.index') }}"
                                    class="group flex items-center gap-3 p-3 rounded-lg hover:bg-blue-50 transition">
                                    <div
                                        class="w-8 h-8 rounded bg-blue-100 text-unmaris-blue flex items-center justify-center group-hover:bg-unmaris-blue group-hover:text-white transition">
                                        <i class="fas fa-shield-alt"></i>
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-800">LPM</div>
                                        <div class="text-[10px] text-gray-500">Penjaminan Mutu</div>
                                    </div>
                                </a>
                                <a href="{{ route('public.lppm.index') }}"
                                    class="group flex items-center gap-3 p-3 rounded-lg hover:bg-blue-50 transition mt-1">
                                    <div
                                        class="w-8 h-8 rounded bg-green-100 text-green-600 flex items-center justify-center group-hover:bg-green-600 group-hover:text-white transition">
                                        <i class="fas fa-microscope"></i>
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-800">LPPM</div>
                                        <div class="text-[10px] text-gray-500">Penelitian & Pengabdian</div>
                                    </div>
                                </a>
                            </div>
                        </x-slot:content>
                    </x-nav-dropdown>

                    {{-- 4. INFORMASI --}}
                    <x-nav-dropdown title="Informasi" active="berita*|dokumen*|kemahasiswaan*|prestasi*">
                        <x-slot:content>
                            <div class="w-48 p-2 space-y-1">
                                <a href="/berita"
                                    class="block px-3 py-2 rounded text-gray-600 hover:bg-blue-50 hover:text-unmaris-blue">Berita
                                    & Acara</a>
                                <a href="/pengumuman"
                                    class="block px-3 py-2 rounded text-gray-600 hover:bg-blue-50 hover:text-unmaris-blue">Pengumuman</a>
                                <a href="/dokumen"
                                    class="block px-3 py-2 rounded text-gray-600 hover:bg-blue-50 hover:text-unmaris-blue">Dokumen
                                    Publik</a>
                                <a href="/kemahasiswaan"
                                    class="block px-3 py-2 rounded text-gray-600 hover:bg-blue-50 hover:text-unmaris-blue">Kemahasiswaan</a>
                                <a href="/prestasi"
                                    class="block px-3 py-2 rounded text-gray-600 hover:bg-blue-50 hover:text-unmaris-blue">Prestasi</a>
                                <a href="/fasilitas"
                                    class="block px-3 py-2 rounded text-gray-600 hover:bg-blue-50 hover:text-unmaris-blue">Fasilitas</a>
                            </div>
                        </x-slot:content>
                    </x-nav-dropdown>

                    {{-- 5. CTA --}}
                    <div class="pl-4">
                        <a href="/pmb"
                            class="px-6 py-2.5 rounded-full bg-unmaris-yellow text-unmaris-blue font-bold hover:bg-white hover:scale-105 transition duration-300 shadow-lg shadow-yellow-500/20 flex items-center gap-2">
                            <i class="fas fa-user-plus text-xs"></i> Daftar PMB
                        </a>
                    </div>

                </div>

                {{-- MOBILE HAMBURGER --}}
                <div class="flex lg:hidden items-center">
                    <button @click="mobileOpen = !mobileOpen"
                        class="p-2 text-white hover:bg-white/10 rounded transition">
                        <i class="fas" :class="mobileOpen ? 'fa-times' : 'fa-bars'"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- MOBILE MENU (SAMA DENGAN DESKTOP) --}}
        <div x-show="mobileOpen" x-collapse
            class="lg:hidden bg-unmaris-blue border-t border-white/10 overflow-y-auto max-h-[80vh] shadow-inner">

            <div class="p-4 space-y-2">
                {{-- Home --}}
                <a href="/" class="block px-4 py-3 rounded-lg hover:bg-white/10 font-bold">Home</a>

                {{-- 1. Tentang Kami --}}
                <div x-data="{ open: false }">
                    <button @click="open = !open"
                        class="w-full flex justify-between items-center px-4 py-3 rounded-lg hover:bg-white/10 transition">
                        <span class="font-medium">Tentang Kami</span>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-300"
                            :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-collapse class="bg-black/20 rounded-lg mt-1 p-2 space-y-1">
                        <div class="px-2 py-1 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Profil
                            Kampus</div>
                        @foreach ($pages as $page)
                            @if (!str_starts_with($page->slug, 'lpm-'))
                                <a href="{{ url('page/' . $page->slug) }}"
                                    class="block px-4 py-2 text-sm text-blue-100 hover:text-white">{{ $page->title }}</a>
                            @endif
                        @endforeach
                        <a href="/kontak" class="block px-4 py-2 text-sm text-blue-100 hover:text-white">Lokasi &
                            Kontak</a>
                    </div>
                </div>

                {{-- 2. Akademik --}}
                <div x-data="{ open: false }">
                    <button @click="open = !open"
                        class="w-full flex justify-between items-center px-4 py-3 rounded-lg hover:bg-white/10 transition">
                        <span class="font-medium">Akademik</span>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-300"
                            :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-collapse class="bg-black/20 rounded-lg mt-1 p-2 space-y-1">
                        <div class="px-2 py-1 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Fakultas
                        </div>
                        @foreach ($fakultas_list as $f)
                            <a href="{{ route('public.fakultas.show', $f->id) }}"
                                class="block px-4 py-2 text-sm text-blue-100 hover:text-white">{{ $f->nama_fakultas }}</a>
                        @endforeach

                        <div class="mt-2 px-2 py-1 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Jalan
                            Pintas</div>
                        <a href="/akreditasi/institusi"
                            class="block px-4 py-2 text-sm text-blue-100 hover:text-white">Akreditasi</a>
                        <a href="#" class="block px-4 py-2 text-sm text-blue-100 hover:text-white">Kalender
                            Akademik</a>
                        <a href="#" class="block px-4 py-2 text-sm text-blue-100 hover:text-white">Biaya
                            Kuliah</a>
                    </div>
                </div>

                {{-- 3. Lembaga --}}
                <div x-data="{ open: false }">
                    <button @click="open = !open"
                        class="w-full flex justify-between items-center px-4 py-3 rounded-lg hover:bg-white/10 transition">
                        <span class="font-medium">Lembaga</span>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-300"
                            :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-collapse class="bg-black/20 rounded-lg mt-1 p-2 space-y-1">
                        <a href="{{ route('public.lpm.index') }}"
                            class="block px-4 py-2 text-sm text-blue-100 hover:text-white flex justify-between">
                            <span>LPM (Penjaminan Mutu)</span>
                        </a>
                        <a href="{{ route('public.lppm.index') }}"
                            class="block px-4 py-2 text-sm text-blue-100 hover:text-white flex justify-between">
                            <span>LPPM (Riset)</span>
                        </a>
                    </div>
                </div>

                {{-- 4. Informasi --}}
                <div x-data="{ open: false }">
                    <button @click="open = !open"
                        class="w-full flex justify-between items-center px-4 py-3 rounded-lg hover:bg-white/10 transition">
                        <span class="font-medium">Informasi</span>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-300"
                            :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-collapse class="bg-black/20 rounded-lg mt-1 p-2 space-y-1">
                        <a href="/berita" class="block px-4 py-2 text-sm text-blue-100 hover:text-white">Berita &
                            Acara</a>
                        <a href="/pengumuman"
                            class="block px-4 py-2 text-sm text-blue-100 hover:text-white">Pengumuman</a>
                        <a href="/dokumen" class="block px-4 py-2 text-sm text-blue-100 hover:text-white">Dokumen
                            Publik</a>
                        <a href="/kemahasiswaan"
                            class="block px-4 py-2 text-sm text-blue-100 hover:text-white">Kemahasiswaan</a>
                        <a href="/fasilitas"
                            class="block px-4 py-2 text-sm text-blue-100 hover:text-white">Fasilitas</a>
                    </div>
                </div>

                {{-- Mobile CTA --}}
                <div class="pt-4 border-t border-white/10 mt-4">
                    <a href="/pmb"
                        class="block text-center py-3 bg-unmaris-yellow text-unmaris-blue font-bold rounded-lg shadow-lg">
                        Daftar Mahasiswa Baru
                    </a>
                    <div class="grid grid-cols-2 gap-2 mt-4 text-center text-sm font-bold text-blue-200">
                        <a href="https://siakad.unmaris.ac.id"
                            class="bg-white/10 py-2 rounded hover:bg-white/20">SIAKAD</a>
                        <a href="https://elearning.unmaris.ac.id"
                            class="bg-white/10 py-2 rounded hover:bg-white/20">E-Learning</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</div>
