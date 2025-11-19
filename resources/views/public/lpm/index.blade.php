<x-layouts.public title="LPM — Penjaminan Mutu">
    <section class="bg-unmaris-blue text-white pt-28 pb-24 relative overflow-hidden">
        {{-- Dekorasi Background Abstrak --}}
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-unmaris-yellow/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 rounded-full bg-white/10 blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            {{-- Badge Kecil --}}
            <span class="inline-block py-1 px-3 rounded-full bg-unmaris-yellow/20 text-unmaris-yellow text-xs font-bold tracking-widest uppercase mb-4 border border-unmaris-yellow/30">
                Quality Assurance
            </span>

            <h1 class="text-4xl md:text-5xl font-extrabold mb-4 tracking-tight">
                Lembaga Penjaminan Mutu
            </h1>

            <p class="text-blue-100 font-medium max-w-3xl mx-auto text-lg md:text-xl leading-relaxed">
                Mengawal dan menjamin kualitas akademik dan non-akademik di <span class="text-unmaris-yellow font-bold">Universitas Stella Maris Sumba</span> menuju standar unggul.
            </p>
        </div>
    </section>

    {{-- MAIN CONTENT AREA --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 pb-16 grid lg:grid-cols-3 gap-10 -mt-12 relative z-20">

        {{-- LEFT COLUMN: Announcements & Info --}}
        <aside class="lg:col-span-1 space-y-8">

            {{-- 1. Pengumuman LPM (Floating Card Effect) --}}
            <div class="bg-white p-6 rounded-2xl shadow-xl border-t-4 border-unmaris-yellow">
                <h3 class="text-xl font-extrabold text-unmaris-blue mb-5 border-b border-gray-100 pb-3 flex items-center">
                    <i class="fas fa-bullhorn text-unmaris-yellow mr-3"></i> Pengumuman Terbaru
                </h3>

                <div class="space-y-4">
                    @forelse($announcements as $a)
                    <a href="{{ route('lpm.announcement', $a->slug) }}" class="block group p-3 -mx-3 rounded-lg transition duration-200 hover:bg-blue-50 border-l-4 border-transparent hover:border-unmaris-blue">
                        <p class="font-bold text-gray-800 group-hover:text-unmaris-blue transition text-sm leading-snug">
                            {{ $a->title }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1 flex items-center">
                            <i class="far fa-calendar-alt mr-1.5"></i>
                            {{ optional($a->published_at)->format('d M Y') }}
                        </p>
                    </a>
                    @empty
                    <div class="text-center py-4">
                         <p class="text-gray-400 text-sm italic">Belum ada pengumuman terbaru.</p>
                    </div>
                    @endforelse
                </div>

                <div class="mt-6 pt-4 border-t border-gray-100 text-center">
                    <a href="{{ route('lpm.announcements.all') }}" class="inline-flex items-center text-sm font-bold text-unmaris-blue hover:text-unmaris-yellow transition">
                        Arsip Pengumuman <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>
            </div>

            {{-- 2. Sidebar Info (Tentang LPM - Blue Style) --}}
            <div class="bg-unmaris-blue p-6 rounded-2xl shadow-lg text-white relative overflow-hidden">
                {{-- Dekorasi --}}
                <div class="absolute top-0 right-0 -mr-10 -mt-10 w-32 h-32 rounded-full bg-white/10 blur-2xl"></div>

                <h3 class="text-lg font-bold mb-3 flex items-center relative z-10">
                    <i class="fas fa-info-circle text-unmaris-yellow mr-2"></i> Tentang LPM
                </h3>
                <p class="text-blue-100 text-sm leading-relaxed relative z-10 mb-4">
                    LPM berkomitmen mewujudkan budaya mutu melalui siklus penetapan, pelaksanaan, evaluasi, pengendalian, dan peningkatan (PPEPP) secara berkelanjutan.
                </p>
                <div class="relative z-10">
                    <a href="{{ route('lpm.profile') }}" class="inline-block px-4 py-2 rounded-lg bg-unmaris-yellow text-unmaris-blue text-xs font-bold hover:bg-white transition">
                        Lihat Visi & Misi
                    </a>
                </div>
            </div>

        </aside>

        {{-- RIGHT COLUMN: Quality Documents (Main Content) --}}
        <div class="lg:col-span-2">
            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-xl border border-gray-100">

                <div class="flex items-center justify-between mb-8 border-b-2 border-gray-100 pb-4">
                    <h2 class="text-2xl md:text-3xl font-extrabold text-unmaris-blue">
                        Arsip Dokumen Mutu
                    </h2>
                    <div class="hidden sm:block">
                         <span class="bg-blue-50 text-unmaris-blue text-xs font-bold px-3 py-1 rounded-full border border-blue-100">
                            {{ $documents->total() }} Dokumen
                         </span>
                    </div>
                </div>

                {{-- Dokumen List --}}
                <div class="grid sm:grid-cols-2 gap-6">
                    @forelse($documents as $doc)
                    <a href="{{ route('lpm.document', $doc->slug) }}" class="flex flex-col h-full border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg hover:border-unmaris-blue/30 transition duration-300 group bg-white">
                        <div class="p-5 flex-1 flex flex-col">
                            {{-- Header Kartu: Kategori & Ikon PDF --}}
                            <div class="flex justify-between items-start mb-3">
                                <span class="inline-block px-2 py-1 text-[10px] font-bold uppercase rounded-md tracking-wide
                                    @if($doc->category === 'SOP') bg-red-50 text-red-600 border border-red-100
                                    @elseif($doc->category === 'Kebijakan Mutu') bg-purple-50 text-purple-600 border border-purple-100
                                    @elseif($doc->category === 'Formulir') bg-green-50 text-green-600 border border-green-100
                                    @else bg-blue-50 text-blue-600 border border-blue-100 @endif">
                                    {{ $doc->category }}
                                </span>
                                <i class="fas fa-file-pdf text-gray-300 group-hover:text-red-500 transition text-lg"></i>
                            </div>

                            {{-- Judul --}}
                            <h3 class="text-lg font-bold text-gray-800 mb-3 group-hover:text-unmaris-blue transition line-clamp-2">
                                {{ $doc->title }}
                            </h3>

                            {{-- Metadata --}}
                            <div class="mt-auto space-y-1 pt-3 border-t border-gray-50">
                                <p class="text-xs text-gray-500 flex items-center">
                                    <i class="fas fa-hashtag w-4 text-center text-gray-300 mr-1"></i>
                                    <span class="font-mono">{{ $doc->kode ?? '-' }}</span>
                                </p>
                                <p class="text-xs text-gray-500 flex items-center">
                                    <i class="far fa-clock w-4 text-center text-gray-300 mr-1"></i>
                                    {{ optional($doc->published_at)->format('d M Y') }}
                                </p>
                            </div>
                        </div>

                        {{-- Footer Kartu (Hover Effect) --}}
                        <div class="bg-gray-50 px-5 py-2 border-t border-gray-100 text-xs font-bold text-gray-500 group-hover:bg-unmaris-blue group-hover:text-white transition flex justify-between items-center">
                            <span>Lihat Detail</span>
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>
                    @empty
                    <div class="col-span-2 py-12 text-center">
                        <div class="bg-gray-50 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                            <i class="far fa-folder-open text-gray-300 text-2xl"></i>
                        </div>
                        <p class="text-gray-500 font-medium">Belum ada dokumen mutu yang dipublikasikan.</p>
                    </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                <div class="mt-10 pt-6 border-t border-gray-100">
                    {{ $documents->onEachSide(1)->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layouts.public>
