<x-layouts.public :title="$ann->title">

    {{-- HEADER SECTION (Konsisten dengan Dokumen & Profil) --}}
    <section class="bg-unmaris-blue text-white pt-28 pb-24 relative overflow-hidden">
        {{-- Dekorasi Background --}}
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-unmaris-yellow/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 rounded-full bg-white/10 blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            {{-- Breadcrumb --}}
            <nav class="flex justify-center text-sm text-unmaris-yellow/80 mb-4 font-medium">
                <a href="{{ route('public.lpm.index') }}" class="hover:text-white transition">LPM</a>
                <span class="mx-2">/</span>
                <a href="{{ route('public.lpm.announcements.index') }}" class="hover:text-white transition">Pengumuman</a>
                <span class="mx-2">/</span>
                <span class="text-white">Detail</span>
            </nav>

            <h1 class="text-3xl md:text-5xl font-extrabold mb-4 tracking-tight leading-tight max-w-4xl mx-auto">
                {{ $ann->title }}
            </h1>
            
            {{-- Garis Dekoratif --}}
            <div class="w-24 h-1.5 bg-unmaris-yellow mx-auto rounded-full opacity-80"></div>
        </div>
    </section>

    {{-- MAIN CONTENT GRID (Overlapping Effect) --}}
    <div class="max-w-7xl mx-auto px-6 pb-16 grid lg:grid-cols-4 gap-10 -mt-12 relative z-20">

        {{-- LEFT COLUMN: Metadata (Sticky Sidebar) --}}
        <aside class="lg:col-span-1 order-2 lg:order-1">
            <div class="bg-white p-6 rounded-2xl shadow-xl border-t-4 border-unmaris-yellow lg:sticky lg:top-24">

                <h3 class="text-lg font-bold text-unmaris-blue mb-5 border-b border-gray-100 pb-3 flex items-center">
                    <i class="fas fa-info-circle text-unmaris-yellow mr-2"></i> Info Terbit
                </h3>

                <ul class="space-y-4 text-sm text-gray-600 border-b border-gray-100 pb-6 mb-6">
                    <li class="flex flex-col">
                        <span class="font-bold text-gray-800 mb-1 text-xs uppercase tracking-wide">Tanggal Publikasi</span>
                        <span class="flex items-center text-base">
                            <i class="far fa-calendar-alt text-unmaris-blue mr-2"></i>
                            {{ optional($ann->published_at)->format('d F Y') }}
                        </span>
                    </li>
                    <li class="flex flex-col">
                        <span class="font-bold text-gray-800 mb-1 text-xs uppercase tracking-wide">Diposting Oleh</span>
                        <span class="flex items-center text-base">
                            <i class="far fa-user text-unmaris-blue mr-2"></i>
                            {{ $ann->poster->name ?? 'Admin LPM' }}
                        </span>
                    </li>
                </ul>

                {{-- Back Button --}}
                <a href="{{ route('public.lpm.announcements.index') }}"
                   class="block w-full text-center py-3 px-4 bg-gray-50 border border-gray-200 rounded-xl text-gray-600 font-bold hover:bg-unmaris-blue hover:text-white transition shadow-sm">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Arsip
                </a>
            </div>
        </aside>

        {{-- RIGHT COLUMN: Content Body --}}
        <div class="lg:col-span-3 order-1 lg:order-2">
            <div class="bg-white p-8 md:p-12 rounded-2xl shadow-xl border border-gray-100 min-h-[400px] relative overflow-hidden">
                
                {{-- Dekorasi Latar Belakang Konten --}}
                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-bl-full opacity-50 -mr-10 -mt-10 z-0"></div>

                {{-- Content Area --}}
                <article class="prose prose-lg prose-blue max-w-none text-gray-700 leading-relaxed relative z-10">
                    {{-- Menggunakan raw HTML output karena biasanya pengumuman ditulis dengan editor teks --}}
                    {!! $ann->content !!}
                </article>

                {{-- Footer Meta --}}
                <div class="mt-12 pt-8 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center text-sm text-gray-500 relative z-10">
                    <div class="mb-4 md:mb-0 flex items-center bg-gray-50 px-4 py-2 rounded-full">
                        <i class="far fa-clock mr-2 text-unmaris-blue"></i>
                        <span>Diperbarui: <span class="font-semibold text-gray-700">{{ $ann->updated_at->diffForHumans() }}</span></span>
                    </div>
                    
                    <div class="flex space-x-3">
                        <button class="flex items-center px-4 py-2 rounded-lg border border-gray-200 hover:bg-gray-50 hover:text-unmaris-blue transition text-xs font-bold uppercase tracking-wide" title="Bagikan">
                            <i class="fas fa-share-alt mr-2"></i> Bagikan
                        </button>
                    </div>
                </div>

            </div>
        </div>

    </div>
</x-layouts.public>