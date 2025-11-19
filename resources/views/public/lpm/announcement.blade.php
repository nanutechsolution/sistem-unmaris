<x-layouts.public :title="$ann->title">

    {{-- HEADER SECTION (Breadcrumb & Title) --}}
    <section class="bg-gray-50 pt-8 pb-4 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-6">
            {{-- Breadcrumb --}}
            <p class="text-sm text-gray-500 mb-2">
                <a href="{{ route('lpm.index') }}" class="hover:underline">LPM</a> /
                <a href="{{ route('lpm.announcements.all') }}" class="hover:underline">Pengumuman</a> / Detail
            </p>
            {{-- Judul Besar --}}
            <h1 class="text-3xl md:text-4xl font-extrabold text-unmaris-blue leading-tight">
                {{ $ann->title }}
            </h1>
        </div>
    </section>

    {{-- MAIN CONTENT --}}
    <div class="max-w-7xl mx-auto px-6 py-12 grid lg:grid-cols-4 gap-10">

        {{-- LEFT COLUMN: Metadata (Sticky Sidebar) --}}
        <aside class="lg:col-span-1">
            <div class="bg-white p-6 rounded-2xl shadow-xl border-t-4 border-unmaris-yellow lg:sticky lg:top-8">

                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-unmaris-yellow mr-2"></i> Info Terbit
                </h3>

                <ul class="space-y-4 text-sm text-gray-600 border-b border-gray-100 pb-6 mb-6">
                    <li class="flex flex-col">
                        <span class="font-semibold text-gray-800 mb-1">Tanggal Publikasi:</span>
                        <span class="flex items-center">
                            <i class="far fa-calendar-alt text-unmaris-blue mr-2"></i>
                            {{ optional($ann->published_at)->format('d F Y') }}
                        </span>
                    </li>
                    <li class="flex flex-col">
                        <span class="font-semibold text-gray-800 mb-1">Diposting Oleh:</span>
                        <span class="flex items-center">
                            <i class="far fa-user text-unmaris-blue mr-2"></i>
                            {{ $ann->poster->name ?? 'Admin LPM' }}
                        </span>
                    </li>
                </ul>

                {{-- Back Button --}}
                <a href="{{ route('lpm.announcements.all') }}"
                   class="block w-full text-center py-2 px-4 border border-gray-300 rounded-lg text-gray-600 font-medium hover:bg-gray-50 hover:text-unmaris-blue transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Arsip
                </a>
            </div>
        </aside>

        {{-- RIGHT COLUMN: Content Body --}}
        <div class="lg:col-span-3">
            <div class="bg-white p-8 rounded-2xl shadow-xl min-h-[400px]">

                {{-- Content Area --}}
                <div class="prose max-w-none text-gray-700 leading-relaxed">
                    {{-- Menampilkan konten HTML (jika pakai editor) atau nl2br (jika textarea biasa) --}}
                    {{-- Menggunakan nl2br(e(...)) untuk keamanan jika input manual tanpa WYSIWYG --}}
                    {{-- Jika menggunakan WYSIWYG editor, gunakan {!! $ann->content !!} --}}

                    {!! $ann->content !!}

                </div>

                {{-- Footer Share/Tag (Optional) --}}
                <div class="mt-10 pt-6 border-t border-gray-100 flex justify-between items-center">
                    <span class="text-sm text-gray-400 italic">
                        Diperbarui: {{ $ann->updated_at->diffForHumans() }}
                    </span>
                    {{-- Share buttons placeholder --}}
                    <div class="flex space-x-3">
                        <button class="text-gray-400 hover:text-unmaris-blue transition" title="Bagikan">
                            <i class="fas fa-share-alt"></i>
                        </button>
                    </div>
                </div>

            </div>
        </div>

    </div>
</x-layouts.public>
