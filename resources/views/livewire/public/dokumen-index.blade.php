<div>
    {{-- 1. HEADER SECTION --}}
    <section class="bg-unmaris-blue text-white pt-48 pb-32 relative overflow-hidden">
        
        {{-- Background Pattern --}}
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-unmaris-yellow/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 rounded-full bg-white/10 blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <nav class="flex justify-center text-sm text-unmaris-yellow/80 mb-4 font-medium">
                <a href="/" class="hover:text-white transition">Home</a>
                <span class="mx-2">/</span>
                <span class="text-white">Dokumen Publik</span>
            </nav>

            <h1 class="text-3xl md:text-5xl font-extrabold mb-4 tracking-tight">
                Arsip Dokumen Digital
            </h1>

            <p class="text-blue-100 font-medium max-w-2xl mx-auto text-lg leading-relaxed">
                Pusat unduhan resmi untuk panduan akademik, formulir, keputusan rektor, dan dokumen publik Universitas Stella Maris Sumba.
            </p>
        </div>
    </section>

    {{-- 2. MAIN CONTENT GRID --}}
    {{-- PERBAIKAN: -mt-24 (naik ke atas header) dan items-start (agar sticky sidebar jalan) --}}
    <div class="max-w-7xl mx-auto px-6 pb-16 grid lg:grid-cols-12 gap-8 -mt-24 relative z-20 items-start">

        {{-- LEFT SIDEBAR: FILTER (Lebar 3 dari 12) --}}
        <aside class="lg:col-span-3 order-2 lg:order-1">
            <div class="bg-white p-6 rounded-2xl shadow-xl border-t-4 border-unmaris-blue lg:sticky lg:top-28">
                
                <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center">
                        <i class="fas fa-filter text-unmaris-blue mr-2"></i> Filter
                    </h3>
                    {{-- Tombol Reset --}}
                    @if ($search || $kategori_id || $fakultas_id || $program_studi_id)
                        <button wire:click="resetFilter" 
                                class="text-xs text-red-500 font-bold hover:text-red-700 transition flex items-center gap-1">
                            <i class="fas fa-times"></i> Reset
                        </button>
                    @endif
                </div>

                <div class="space-y-5">
                    
                    {{-- Search --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Pencarian</label>
                        <div class="relative">
                            <input type="text" wire:model.live.debounce.300ms="search"
                                placeholder="Judul dokumen..."
                                class="w-full pl-9 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-unmaris-blue/20 focus:border-unmaris-blue transition text-sm">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400 text-sm"></i>
                        </div>
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Kategori</label>
                        <select wire:model.live="kategori_id"
                            class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-unmaris-blue transition">
                            <option value="">Semua Kategori</option>
                            @foreach ($kategoris as $kat)
                                <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Fakultas --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Fakultas</label>
                        <select wire:model.live="fakultas_id"
                            class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-unmaris-blue transition">
                            <option value="">Semua Fakultas</option>
                            @foreach ($fakultas as $f)
                                <option value="{{ $f->id }}">{{ $f->nama_fakultas }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Prodi --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Program Studi</label>
                        <select wire:model.live="program_studi_id"
                            class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-unmaris-blue transition"
                            {{ $prodis->isEmpty() && $fakultas_id ? 'disabled' : '' }}>
                            <option value="">Semua Prodi</option>
                            @foreach ($prodis as $p)
                                <option value="{{ $p->id }}">{{ $p->nama_prodi }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Loading Indicator --}}
                    <div wire:loading class="w-full text-center py-2">
                        <span class="text-xs text-unmaris-blue font-bold animate-pulse">
                            <i class="fas fa-spinner animate-spin mr-1"></i> Memuat data...
                        </span>
                    </div>
                </div>
            </div>
        </aside>

        {{-- RIGHT CONTENT: LIST DOKUMEN (Lebar 9 dari 12) --}}
        <div class="lg:col-span-9 order-1 lg:order-2">
            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-xl border border-gray-100 min-h-[500px]">

                {{-- Header List --}}
                <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
                    <h2 class="text-xl font-extrabold text-gray-800">Daftar Dokumen</h2>
                    <span class="bg-blue-50 text-unmaris-blue text-xs font-bold px-3 py-1 rounded-full border border-blue-100">
                        {{ $dokumens->total() }} File Ditemukan
                    </span>
                </div>

                {{-- List Loop --}}
                <div class="space-y-4">
                    @forelse($dokumens as $doc)
                        <div class="group bg-white border border-gray-200 rounded-xl p-5 hover:shadow-lg hover:border-unmaris-blue/30 transition duration-300 flex flex-col sm:flex-row items-start gap-5 relative overflow-hidden">
                            
                            {{-- Dekorasi Hover --}}
                            <div class="absolute left-0 top-0 bottom-0 w-1 bg-unmaris-blue opacity-0 group-hover:opacity-100 transition duration-300"></div>

                            {{-- Icon File Type --}}
                            <div class="flex-shrink-0">
                                <div class="w-16 h-16 rounded-xl bg-gray-50 flex items-center justify-center text-3xl shadow-sm group-hover:scale-110 transition duration-300">
                                    @php
                                        $ext = strtolower($doc->file_type);
                                        $iconColor = match(true) {
                                            in_array($ext, ['pdf']) => 'text-red-500',
                                            in_array($ext, ['doc', 'docx']) => 'text-blue-600',
                                            in_array($ext, ['xls', 'xlsx']) => 'text-green-600',
                                            in_array($ext, ['ppt', 'pptx']) => 'text-orange-500',
                                            default => 'text-gray-400'
                                        };
                                        $iconClass = match(true) {
                                            in_array($ext, ['pdf']) => 'fas fa-file-pdf',
                                            in_array($ext, ['doc', 'docx']) => 'fas fa-file-word',
                                            in_array($ext, ['xls', 'xlsx']) => 'fas fa-file-excel',
                                            in_array($ext, ['ppt', 'pptx']) => 'fas fa-file-powerpoint',
                                            default => 'fas fa-file-alt'
                                        };
                                    @endphp
                                    <i class="{{ $iconClass }} {{ $iconColor }}"></i>
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="flex-grow min-w-0">
                                <div class="flex flex-wrap gap-2 mb-2">
                                    @if ($doc->kategori)
                                        <span class="inline-block px-2 py-0.5 rounded bg-gray-100 text-gray-600 text-[10px] font-bold uppercase tracking-wide border border-gray-200">
                                            {{ $doc->kategori->nama }}
                                        </span>
                                    @endif
                                    @if ($doc->fakultas)
                                        <span class="inline-block px-2 py-0.5 rounded bg-blue-50 text-blue-600 text-[10px] font-bold uppercase tracking-wide border border-blue-100">
                                            {{ $doc->fakultas->nama_fakultas }}
                                        </span>
                                    @endif
                                </div>

                                <h3 class="text-lg font-bold text-gray-800 mb-2 group-hover:text-unmaris-blue transition leading-tight">
                                    {{ $doc->judul }}
                                </h3>

                                <p class="text-sm text-gray-500 line-clamp-2 mb-3">
                                    {{ $doc->deskripsi ?? 'Tidak ada deskripsi.' }}
                                </p>

                                <div class="flex flex-wrap items-center text-xs text-gray-400 gap-4">
                                    <span class="flex items-center"><i class="far fa-calendar-alt mr-1.5"></i> {{ $doc->created_at->format('d M Y') }}</span>
                                    <span class="flex items-center"><i class="far fa-hdd mr-1.5"></i> {{ round($doc->file_size / 1024) }} KB</span>
                                    <span class="flex items-center text-unmaris-blue font-bold"><i class="fas fa-download mr-1.5"></i> {{ $doc->download_count }}x Unduh</span>
                                </div>
                            </div>

                            {{-- Download Button --}}
                            <div class="flex-shrink-0 mt-4 sm:mt-0 self-center">
                                <a href="{{ route('public.dokumen.download', $doc->id) }}" 
                                   class="inline-flex items-center justify-center px-5 py-2.5 bg-white border border-gray-200 text-gray-700 font-bold text-sm rounded-xl hover:bg-unmaris-blue hover:text-white hover:border-unmaris-blue transition shadow-sm group-hover:shadow-md">
                                    <i class="fas fa-download mr-2"></i> Unduh
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-16 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm text-gray-300 text-3xl">
                                <i class="far fa-folder-open"></i>
                            </div>
                            <p class="text-gray-500 font-medium mb-2">Tidak ada dokumen ditemukan.</p>
                            <p class="text-xs text-gray-400">Coba ubah kata kunci atau reset filter.</p>
                            
                            @if ($search || $kategori_id)
                                <button wire:click="resetFilter" class="mt-4 text-unmaris-blue text-sm font-bold hover:underline">
                                    Reset Filter
                                </button>
                            @endif
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                <div class="mt-8 pt-6 border-t border-gray-100">
                    {{ $dokumens->links() }} 
                </div>

            </div>
        </div>
    </div>
</div>