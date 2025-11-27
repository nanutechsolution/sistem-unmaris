<x-layouts.public :title="$page->title">

    {{-- 1. HERO SECTION --}}
    {{-- PERBAIKAN: Ubah pt-28 menjadi pt-48 agar konten turun dan tidak tertutup Navbar Fixed --}}
    <section class="bg-unmaris-blue text-white pt-48 pb-24 relative overflow-hidden">
        
        {{-- Dekorasi Background --}}
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-unmaris-yellow/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 rounded-full bg-white/10 blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <nav class="flex justify-center text-sm text-unmaris-yellow/80 mb-4 font-medium">
                <a href="/" class="hover:text-white transition">Home</a>
                <span class="mx-2">/</span>
                <span class="text-white">Profil Kampus</span>
            </nav>

            <h1 class="text-3xl md:text-5xl font-extrabold mb-4 tracking-tight">
                {{ $page->title }}
            </h1>

            {{-- Garis Dekoratif --}}
            <div class="w-24 h-1.5 bg-unmaris-yellow mx-auto rounded-full opacity-80"></div>
        </div>
    </section>

    {{-- MAIN CONTENT GRID (Overlapping Effect) --}}
    <div class="max-w-7xl mx-auto px-6 pb-16 grid lg:grid-cols-4 gap-10 -mt-12 relative z-20">

        {{-- LEFT SIDEBAR (AKSES CEPAT) --}}
        <aside class="lg:col-span-1 order-2 lg:order-1">
            {{-- Sticky sidebar agar ikut turun saat discroll --}}
            <div class="bg-white p-6 rounded-2xl shadow-xl border-t-4 border-unmaris-yellow lg:sticky lg:top-32">

                <h3 class="text-lg font-bold text-unmaris-blue mb-5 border-b border-gray-100 pb-3 flex items-center">
                    <i class="fas fa-compass text-unmaris-yellow mr-3"></i> Akses Cepat
                </h3>

                <nav class="space-y-2">
                    @foreach($sidebarPages as $item)
                        <a href="{{ route('pages.show', $item->slug) }}"
                           class="block px-4 py-3 rounded-lg text-sm font-medium transition duration-200 flex items-center justify-between group border
                                  {{ $item->id === $page->id
                                     ? 'bg-unmaris-blue text-white border-unmaris-blue shadow-md transform scale-105'
                                     : 'bg-white text-gray-600 border-gray-100 hover:border-unmaris-blue/30 hover:text-unmaris-blue hover:bg-blue-50' }}">

                            <span>{{ $item->title }}</span>

                            @if($item->id === $page->id)
                                <i class="fas fa-check-circle text-unmaris-yellow"></i>
                            @else
                                <i class="fas fa-chevron-right text-xs opacity-0 group-hover:opacity-100 transition-opacity text-gray-400"></i>
                            @endif
                        </a>
                    @endforeach
                </nav>

                {{-- Banner Kontak Kecil --}}
                <div class="mt-8 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-5 border border-gray-200 text-center">
                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center mx-auto mb-3 shadow-sm text-unmaris-blue">
                        <i class="far fa-question-circle"></i>
                    </div>
                    <p class="text-xs font-bold text-gray-700 mb-1">Butuh Informasi Lain?</p>
                    <p class="text-[10px] text-gray-500 mb-3">Tim kami siap membantu Anda.</p>
                    <a href="/kontak" class="block w-full bg-unmaris-blue text-white py-2 rounded-lg text-xs font-bold hover:bg-unmaris-yellow hover:text-unmaris-blue transition shadow-sm">
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </aside>

        {{-- RIGHT CONTENT BODY --}}
        <div class="lg:col-span-3 order-1 lg:order-2">
            <div class="bg-white p-8 md:p-12 rounded-2xl shadow-xl border border-gray-100 relative overflow-hidden">

                {{-- Dekorasi Latar Belakang Konten --}}
                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-bl-full opacity-50 -mr-10 -mt-10 z-0"></div>

                <article class="prose prose-lg prose-blue max-w-none text-gray-700 leading-relaxed relative z-10">
                    {!! $page->content !!}
                </article>
                
                <div class="mt-12 pt-8 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center text-sm text-gray-500 relative z-10">
                    <div class="mb-4 md:mb-0 flex items-center bg-gray-50 px-4 py-2 rounded-full">
                        <i class="far fa-clock mr-2 text-unmaris-blue"></i>
                        <span>Diperbarui: <span class="font-semibold text-gray-700">{{ $page->updated_at->isoFormat('D MMMM Y') }}</span></span>
                    </div>
                    <div class="flex space-x-3">
                        <button class="flex items-center px-4 py-2 rounded-lg border border-gray-200 hover:bg-gray-50 hover:text-unmaris-blue transition text-xs font-bold uppercase tracking-wide" onclick="window.print()">
                            <i class="fas fa-print mr-2"></i> Cetak
                        </button>
                        <button class="flex items-center px-4 py-2 rounded-lg border border-gray-200 hover:bg-gray-50 hover:text-unmaris-blue transition text-xs font-bold uppercase tracking-wide" onclick="navigator.clipboard.writeText(window.location.href); alert('Link tersalin!')">
                            <i class="fas fa-share-alt mr-2"></i> Share
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.public>