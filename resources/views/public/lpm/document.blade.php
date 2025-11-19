<x-layouts.public :title="$doc->title">
    <section class="bg-unmaris-blue text-white pt-24 pb-12 relative overflow-hidden">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-unmaris-yellow/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 rounded-full bg-white/10 blur-3xl"></div>
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            {{-- Breadcrumb --}}
            <p class="text-sm text-unmaris-yellow/80 mb-3 font-medium">
                <a href="{{ route('lpm.index') }}" class="hover:text-white transition">LPM</a>
                <span class="mx-2">/</span>
                <span class="text-white/90">Dokumen Mutu</span>
            </p>

            {{-- Judul Besar --}}
            <h1 class="text-3xl md:text-4xl font-extrabold leading-tight max-w-4xl">
                {{ $doc->title }}
            </h1>
        </div>
    </section>

    {{-- MAIN CONTENT & DOWNLOAD ACTION --}}
    <div class="max-w-7xl mx-auto px-6 py-12 grid lg:grid-cols-4 gap-10">

        {{-- LEFT COLUMN: Metadata dan File Action (Sticky on Desktop) --}}
        <aside class="lg:col-span-1">
            {{-- Added -mt-20 to create overlapping card effect (Modern UX) --}}
            <div class="bg-white p-6 rounded-2xl shadow-xl border-t-4 border-unmaris-yellow lg:sticky lg:top-24 z-20 relative lg:-mt-20">

                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-file-contract text-unmaris-yellow mr-2"></i>
                    Informasi Dokumen
                </h3>

                {{-- Metadata List --}}
                <ul class="space-y-3 text-sm text-gray-600 border-b border-gray-100 pb-4 mb-4">
                    <li class="flex flex-col">
                        <span class="font-medium text-gray-800 text-xs uppercase tracking-wider">Kode Dokumen</span>
                        <span class="font-bold text-unmaris-blue text-base">{{ $doc->kode ?? 'N/A' }}</span>
                    </li>
                    <li class="flex flex-col">
                        <span class="font-medium text-gray-800 text-xs uppercase tracking-wider">Kategori</span>
                        <span class="mt-1">
                            <span class="inline-block px-2 py-1 text-xs font-bold uppercase rounded bg-unmaris-blue/10 text-unmaris-blue">
                                {{ $doc->category }}
                            </span>
                        </span>
                    </li>
                    <li class="flex flex-col">
                        <span class="font-medium text-gray-800 text-xs uppercase tracking-wider">Tanggal Terbit</span>
                        <span class="font-semibold text-gray-700">{{ optional($doc->published_at)->format('d F Y') }}</span>
                    </li>
                </ul>

                {{-- PRIMARY ACTION BUTTON --}}
                <div class="mt-4 hidden lg:block">
                    <a href="{{ Storage::url($doc->file_path) }}" target="_blank"
                       class="w-full flex items-center justify-center space-x-2 px-5 py-3
                              bg-unmaris-blue text-white rounded-xl font-bold
                              hover:bg-unmaris-yellow hover:text-unmaris-blue transition duration-300 shadow-lg shadow-unmaris-blue/30 transform hover:-translate-y-0.5">
                        <i class="fas fa-download mr-2"></i>
                        <span>Unduh Dokumen</span>
                    </a>
                </div>
            </div>
        </aside>

        {{-- RIGHT COLUMN: Description and Content --}}
        <div class="lg:col-span-3">
            <div class="bg-white p-8 rounded-2xl shadow-xl border border-gray-100">

                <div class="flex items-center mb-6 border-b border-gray-100 pb-4">
                    <div class="w-10 h-10 rounded-full bg-unmaris-blue/10 flex items-center justify-center text-unmaris-blue mr-3">
                        <i class="fas fa-align-left"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">Deskripsi Dokumen</h2>
                </div>

                {{-- Deskripsi/Abstrak --}}
                <div class="prose prose-blue max-w-none text-gray-700 leading-relaxed mb-8">
                    {!! nl2br(e($doc->description)) !!}

                    @if (empty($doc->description))
                        <p class="italic text-gray-500 bg-gray-50 p-4 rounded-lg border border-gray-100">
                            Tidak ada deskripsi yang tersedia untuk dokumen ini.
                        </p>
                    @endif
                </div>

                {{-- Secondary Download Action (Mobile) --}}
                <div class="mt-8 pt-6 border-t border-gray-100 lg:hidden">
                    <a href="{{ Storage::url($doc->file_path) }}" target="_blank"
                       class="w-full flex items-center justify-center space-x-2 px-5 py-3
                              bg-unmaris-blue text-white rounded-xl font-bold
                              hover:bg-unmaris-yellow hover:text-unmaris-blue transition duration-300 shadow-lg shadow-unmaris-blue/30">
                        <i class="fas fa-download mr-2"></i>
                        <span>Unduh Dokumen Sekarang</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.public>
