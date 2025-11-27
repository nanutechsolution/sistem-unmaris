<x-layouts.public :title="$page->title . ' - LPM UNMARIS'">

    {{-- HEADER SECTION --}}
    <section class="bg-unmaris-blue text-white pt-48 pb-20 relative overflow-hidden">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-unmaris-yellow/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 rounded-full bg-white/10 blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <nav class="flex justify-center text-sm text-unmaris-yellow/80 mb-4 font-medium">
                <a href="{{ route('public.lpm.index') }}" class="hover:text-white transition">LPM</a>
                <span class="mx-2">/</span>
                <span class="text-white">{{ $page->title }}</span>
            </nav>

            <h1 class="text-4xl md:text-5xl font-extrabold mb-4 tracking-tight">
                {{ $page->title }}
            </h1>

            <p class="text-blue-100 font-medium max-w-2xl mx-auto text-lg leading-relaxed">
                Lembaga Penjaminan Mutu Universitas Stella Maris Sumba
            </p>
        </div>
    </section>

    {{-- MAIN CONTENT GRID --}}
    <div class="max-w-7xl mx-auto px-6 py-16 grid lg:grid-cols-12 gap-12 -mt-12 relative z-20">

        {{-- LEFT COLUMN: Sidebar Navigasi --}}
        <aside class="lg:col-span-4 space-y-8 order-2 lg:order-1">

            {{-- Widget: Menu LPM --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden sticky top-24">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                    <h4 class="text-sm font-bold text-unmaris-blue uppercase tracking-wider">
                        <i class="fas fa-bars mr-2"></i> Menu LPM
                    </h4>
                </div>

                <nav class="flex flex-col p-2">
                    {{-- Link ke Halaman LPM Lainnya (Dinamis dari Controller) --}}
                    @foreach ($sidebarPages as $item)
                        <a href="{{ route('public.lpm.profile', $item->slug) }}"
                            class="group flex items-center justify-between px-4 py-3 rounded-xl transition duration-200 {{ $page->id == $item->id ? 'bg-unmaris-blue text-white font-bold shadow-md' : 'text-gray-600 hover:bg-blue-50 hover:text-unmaris-blue' }}">
                            <span>{{ $item->title }}</span>
                            @if ($page->id == $item->id)
                                <i class="fas fa-chevron-right text-xs"></i>
                            @endif
                        </a>
                    @endforeach

                    {{-- Link Balik ke Dashboard LPM --}}
                    <a href="{{ route('public.lpm.index') }}"
                        class="flex items-center px-4 py-3 text-gray-500 hover:text-unmaris-blue hover:bg-gray-50 rounded-xl transition mt-2 border-t border-gray-100">
                        <i class="fas fa-arrow-left mr-2 text-xs"></i> Kembali ke Beranda LPM
                    </a>
                </nav>
            </div>

            {{-- Widget: Download (Opsional, Pemanis) --}}
            <div class="bg-unmaris-yellow/10 rounded-2xl p-6 border border-unmaris-yellow/20">
                <h4 class="font-bold text-unmaris-blue mb-2">Butuh Dokumen Mutu?</h4>
                <p class="text-sm text-gray-600 mb-4">Unduh standar dan manual mutu terbaru.</p>
                <a href="{{ route('public.lpm.index') }}"
                    class="inline-block w-full text-center py-2 bg-unmaris-blue text-white rounded-lg font-bold text-sm hover:bg-blue-800 transition">
                    Ke Arsip Dokumen
                </a>
            </div>

        </aside>

        {{-- RIGHT COLUMN: Konten Halaman --}}
        <div class="lg:col-span-8 order-1 lg:order-2">
            <div class="bg-white p-8 md:p-12 rounded-2xl shadow-xl border-t-4 border-unmaris-yellow">

                {{-- Judul di dalam konten --}}
                <div class="flex items-center mb-8 pb-6 border-b border-gray-100">
                    <div
                        class="w-12 h-12 rounded-full bg-unmaris-blue/10 flex items-center justify-center mr-4 shrink-0">
                        <i class="fas fa-book-open text-unmaris-blue text-xl"></i>
                    </div>
                    <h2 class="text-3xl font-extrabold text-gray-800">{{ $page->title }}</h2>
                </div>

                {{-- RENDER KONTEN HTML DARI DATABASE --}}
                {{-- Class 'prose' dari Tailwind Typography Plugin sangat penting disini --}}
                <article class="prose prose-lg prose-blue max-w-none text-gray-600 leading-relaxed">
                    {!! $page->content !!}
                </article>

                {{-- Footer Konten --}}
                <div
                    class="mt-10 pt-6 border-t border-gray-100 flex items-center justify-between text-sm text-gray-400">
                    <span>Terakhir diperbarui: {{ $page->updated_at->format('d F Y') }}</span>
                    <div class="flex gap-3">
                        <button onclick="window.print()" class="hover:text-unmaris-blue transition"
                            title="Cetak Halaman">
                            <i class="fas fa-print"></i>
                        </button>
                        <button onclick="navigator.clipboard.writeText(window.location.href); alert('Link disalin!')"
                            class="hover:text-unmaris-blue transition" title="Salin Link">
                            <i class="fas fa-link"></i>
                        </button>
                    </div>
                </div>

            </div>
        </div>

    </div>
</x-layouts.public>
