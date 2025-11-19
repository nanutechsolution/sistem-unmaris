<x-layouts.public title="Daftar Pengumuman Mutu">
    {{-- HEADER SECTION --}}
    <section class="bg-unmaris-blue text-white py-16">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h1 class="text-4xl font-extrabold mb-2">Semua Pengumuman Mutu</h1>
            <p class="text-unmaris-yellow/90 max-w-2xl mx-auto">Informasi dan kegiatan terbaru dari Lembaga Penjaminan Mutu (LPM) UNMARIS.</p>
        </div>
    </section>

    {{-- MAIN CONTENT: ANNOUNCEMENTS LIST --}}
    <div class="max-w-7xl mx-auto px-6 py-12">
        <div class="bg-white p-6 md:p-8 rounded-2xl shadow-xl">

            <h2 class="text-3xl font-bold text-unmaris-blue mb-8 border-b-2 border-unmaris-yellow/50 pb-3">
                Arsip Pengumuman
            </h2>

            <div class="space-y-6">
                @forelse($announcements as $ann)
                <a href="{{ route('lpm.announcement', $ann->slug) }}" class="block p-4 rounded-xl border border-gray-100 transition duration-200
                              hover:border-unmaris-blue hover:shadow-md group">
                    <div class="flex items-start space-x-4">
                        {{-- Icon --}}
                        <div class="flex-shrink-0 pt-1">
                            <i class="fas fa-calendar-alt text-2xl text-unmaris-yellow group-hover:text-unmaris-blue"></i>
                        </div>

                        {{-- Content --}}
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 group-hover:text-unmaris-blue transition">
                                {{ $ann->title }}
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ optional($ann->published_at)->format('d F Y') }}
                            </p>
                            <div class="text-base text-gray-700 mt-2 line-clamp-2">
                                {{-- Menampilkan potongan konten --}}
                                {!! Str::limit(strip_tags($ann->content), 200) !!}
                            </div>
                        </div>
                    </div>
                </a>
                @empty
                <div class="text-center py-10 bg-gray-50 rounded-lg">
                    <p class="text-gray-600 italic">Tidak ada pengumuman yang dapat ditampilkan saat ini.</p>
                </div>
                @endforelse
            </div>
            <div class="mt-10">
                {{ $announcements->links() }}
            </div>

        </div>
    </div>
</x-layouts.public>
