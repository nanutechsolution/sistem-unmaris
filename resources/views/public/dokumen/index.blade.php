<x-layouts.public title="Arsip Dokumen Kampus">

    {{-- HEADER SECTION --}}
    <section class="bg-unmaris-blue text-white pt-48 pb-24 relative overflow-hidden">
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
                Pusat unduhan resmi untuk panduan akademik, formulir, keputusan rektor, dan dokumen publik Universitas
                Stella Maris Sumba.
            </p>
        </div>
    </section>

    {{-- MAIN CONTENT GRID --}}
    <div class="max-w-7xl mx-auto px-6 pb-16 grid lg:grid-cols-4 gap-10 -mt-12 relative z-20">

        {{-- LEFT SIDEBAR (FILTER) --}}
        <aside class="lg:col-span-1">
            <div class="bg-white p-6 rounded-2xl shadow-xl border-t-4 border-unmaris-blue lg:sticky lg:top-24">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center">
                        <i class="fas fa-filter text-unmaris-blue mr-2"></i> Filter
                    </h3>
                    @if (request()->hasAny(['kategori_id', 'fakultas_id', 'program_studi_id', 'search']))
                        <a href="{{ route('public.dokumen.index') }}"
                            class="text-xs text-red-500 font-bold hover:underline">Reset</a>
                    @endif
                </div>

                <form action="{{ route('public.dokumen.index') }}" method="GET" class="space-y-5">

                    {{-- Search --}}
                    <div>
                        <label
                            class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Pencarian</label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Judul dokumen..."
                                class="w-full pl-9 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-unmaris-blue/20 focus:border-unmaris-blue transition text-sm">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400 text-sm"></i>
                        </div>
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label
                            class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Kategori</label>
                        <select name="kategori_id"
                            class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-unmaris-blue transition">
                            <option value="">Semua Kategori</option>
                            @foreach ($kategoris as $kat)
                                <option value="{{ $kat->id }}"
                                    {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>{{ $kat->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Fakultas --}}
                    <div>
                        <label
                            class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Fakultas</label>
                        <select name="fakultas_id"
                            class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-unmaris-blue transition">
                            <option value="">Semua Fakultas</option>
                            @foreach ($fakultas as $f)
                                <option value="{{ $f->id }}"
                                    {{ request('fakultas_id') == $f->id ? 'selected' : '' }}>{{ $f->nama_fakultas }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Prodi --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Program
                            Studi</label>
                        <select name="program_studi_id"
                            class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-unmaris-blue transition">
                            <option value="">Semua Prodi</option>
                            @foreach ($prodis as $p)
                                <option value="{{ $p->id }}"
                                    {{ request('program_studi_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_prodi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit"
                        class="w-full bg-unmaris-blue text-white font-bold py-2.5 rounded-lg hover:bg-unmaris-yellow hover:text-unmaris-blue transition shadow-md text-sm flex justify-center items-center gap-2">
                        <i class="fas fa-search"></i> Terapkan Filter
                    </button>
                </form>
            </div>
        </aside>

        {{-- RIGHT CONTENT (LIST DOKUMEN) --}}
        <div class="lg:col-span-3">
            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-xl border border-gray-100 min-h-[500px]">

                <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
                    <h2 class="text-xl font-extrabold text-gray-800">Daftar Dokumen</h2>
                    <span class="bg-gray-100 text-gray-600 text-xs font-bold px-3 py-1 rounded-full">
                        {{ count($dokumens) }} File Ditemukan
                    </span>
                </div>

                <div class="space-y-4">
                    @forelse($dokumens as $doc)
                        <div
                            class="group bg-white border border-gray-200 rounded-xl p-5 hover:shadow-lg hover:border-unmaris-blue/30 transition duration-300 flex flex-col sm:flex-row items-start gap-4">

                            {{-- Icon File Type --}}
                            <div class="flex-shrink-0">
                                <div
                                    class="w-14 h-14 rounded-lg bg-blue-50 text-unmaris-blue flex items-center justify-center text-2xl group-hover:bg-unmaris-blue group-hover:text-white transition duration-300">
                                    @if (in_array(strtolower($doc->file_type), ['pdf']))
                                        <i class="fas fa-file-pdf text-red-500 group-hover:text-white"></i>
                                    @elseif(in_array(strtolower($doc->file_type), ['doc', 'docx']))
                                        <i class="fas fa-file-word text-blue-500 group-hover:text-white"></i>
                                    @elseif(in_array(strtolower($doc->file_type), ['xls', 'xlsx']))
                                        <i class="fas fa-file-excel text-green-500 group-hover:text-white"></i>
                                    @else
                                        <i class="fas fa-file-alt"></i>
                                    @endif
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="flex-grow min-w-0">
                                <div class="flex flex-wrap gap-2 mb-1">
                                    @if ($doc->kategori)
                                        <span
                                            class="inline-block px-2 py-0.5 rounded bg-gray-100 text-gray-600 text-[10px] font-bold uppercase tracking-wide border border-gray-200">
                                            {{ $doc->kategori->nama }}
                                        </span>
                                    @endif
                                    @if ($doc->fakultas)
                                        <span
                                            class="inline-block px-2 py-0.5 rounded bg-blue-50 text-blue-600 text-[10px] font-bold uppercase tracking-wide border border-blue-100">
                                            {{ $doc->fakultas->nama_fakultas }}
                                        </span>
                                    @endif
                                </div>

                                <h3
                                    class="text-lg font-bold text-gray-800 mb-1 group-hover:text-unmaris-blue transition leading-tight truncate">
                                    {{ $doc->judul }}
                                </h3>

                                <p class="text-sm text-gray-500 line-clamp-2 mb-3">
                                    {{ $doc->deskripsi ?? 'Tidak ada deskripsi.' }}
                                </p>

                                <div class="flex items-center text-xs text-gray-400 gap-4">
                                    <span class="flex items-center"><i class="far fa-calendar-alt mr-1.5"></i>
                                        {{ $doc->created_at->format('d M Y') }}</span>
                                    <span class="flex items-center"><i class="far fa-hdd mr-1.5"></i>
                                        {{ round($doc->file_size / 1024) }} KB</span>
                                    <span class="flex items-center"><i class="fas fa-download mr-1.5"></i>
                                        {{ $doc->download_count }}x Diunduh</span>
                                </div>
                            </div>

                            {{-- Download Button --}}
                            <div class="flex-shrink-0 mt-3 sm:mt-0">
                                <a href="{{ route('public.dokumen.download', $doc->id) }}"
                                    class="inline-flex items-center justify-center w-full sm:w-auto px-5 py-2.5 bg-unmaris-blue text-white font-bold text-sm rounded-lg hover:bg-unmaris-yellow hover:text-unmaris-blue transition shadow-sm">
                                    <i class="fas fa-download mr-2"></i> Unduh
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-16 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                            <div
                                class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm text-gray-300 text-3xl">
                                <i class="far fa-folder-open"></i>
                            </div>
                            <p class="text-gray-500 font-medium mb-2">Tidak ada dokumen ditemukan.</p>
                            <p class="text-xs text-gray-400">Coba ubah filter pencarian Anda.</p>
                        </div>
                    @endforelse
                </div>

                {{-- Note: Pagination tidak ditampilkan karena Controller menggunakan ->get() --}}
                {{-- Jika nanti menggunakan ->paginate(), uncomment baris di bawah --}}
                {{-- <div class="mt-8 pt-6 border-t border-gray-100">
                    {{ $dokumens->links('pagination::tailwind') }}
                </div> --}}

            </div>
        </div>
    </div>

</x-layouts.public>
