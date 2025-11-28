<div>
    {{-- CUSTOM CSS UNTUK GARIS POHON (TREE LINES) --}}
    <style>
        /* Garis vertikal penghubung */
        .tree-connector::before {
            content: '';
            position: absolute;
            top: -24px;
            left: 50%;
            transform: translateX(-50%);
            width: 2px;
            height: 24px;
            background-color: #CBD5E1; /* slate-300 */
            z-index: 0;
        }

        /* Garis horizontal untuk cabang banyak */
        .tree-branch {
            position: relative;
        }
        .tree-branch::after {
            content: '';
            position: absolute;
            top: -24px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #CBD5E1;
            z-index: 0;
        }
        /* Hilangkan garis kiri untuk elemen pertama */
        .tree-branch:first-child::after {
            left: 50%;
            width: 50%;
        }
        /* Hilangkan garis kanan untuk elemen terakhir */
        .tree-branch:last-child::after {
            width: 50%;
        }
        /* Jika cuma 1 anak, tidak perlu garis horizontal */
        .tree-branch:only-child::after {
            display: none;
        }
        /* Garis vertikal kecil di atas setiap anak */
        .tree-branch::before {
            content: '';
            position: absolute;
            top: -24px;
            left: 50%;
            width: 2px;
            height: 24px;
            background-color: #CBD5E1;
        }
    </style>

    {{-- HEADER --}}
    <section class="bg-unmaris-blue text-white pt-48 pb-24 relative overflow-hidden">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-unmaris-yellow/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 rounded-full bg-white/10 blur-3xl"></div>
        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <nav class="flex justify-center text-sm text-unmaris-yellow/80 mb-4 font-medium">
                <a href="/" class="hover:text-white transition">Home</a>
                <span class="mx-2">/</span>
                <span class="text-white">Profil Kampus</span>
            </nav>
            <h1 class="text-4xl md:text-6xl font-extrabold mb-4 tracking-tight">Struktur Organisasi</h1>
            <p class="text-blue-100 text-lg max-w-2xl mx-auto">
                Sinergi kepemimpinan untuk mewujudkan visi Universitas Stella Maris Sumba.
            </p>
        </div>
    </section>

    {{-- CONTENT --}}
    <div class="max-w-7xl mx-auto px-6 py-20 -mt-16 relative z-20">

        {{-- 1. BAGAN YAYASAN (SUPRA STRUKTUR) --}}
        @if(isset($groupedLeaders['Yayasan']))
        <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12 mb-16 relative overflow-hidden border-t-4 border-purple-600">
            <div class="absolute top-0 left-0 w-full h-2 bg-purple-600"></div>
            <div class="text-center mb-10">
                <h2 class="text-2xl font-extrabold text-gray-800">Badan Penyelenggara</h2>
                <p class="text-purple-600 font-bold uppercase tracking-widest text-xs mt-1">Yayasan Stella Maris</p>
            </div>

            <div class="flex flex-wrap justify-center gap-8 md:gap-12 relative z-10">
                @foreach($groupedLeaders['Yayasan'] as $pos)
                    <div class="flex flex-col items-center group w-48">
                        <div class="relative w-32 h-32 mb-4">
                            <div class="absolute inset-0 bg-purple-100 rounded-full transform rotate-6 group-hover:rotate-12 transition duration-300"></div>
                            <div class="absolute inset-0 rounded-full overflow-hidden border-4 border-white shadow-lg bg-gray-200 z-10">
                                @if($pos->currentOfficial)
                                    <img src="{{ $pos->currentOfficial->photo_url }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400"><i class="fas fa-user text-4xl"></i></div>
                                @endif
                            </div>
                        </div>
                        {{-- UPDATE: Hapus truncate agar gelar tampil --}}
                        <h4 class="text-base font-bold text-gray-900 text-center leading-tight min-h-[2.5rem] flex items-center justify-center">
                            {{ $pos->currentOfficial->name ?? '-' }}
                        </h4>
                        <span class="text-xs text-purple-600 font-bold mt-1 uppercase text-center">{{ $pos->name }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- 2. BAGAN REKTORAT & FAKULTAS (TREE DIAGRAM) --}}
        @if(isset($groupedLeaders['Rektorat']))
        <div class="overflow-x-auto pb-10 custom-scrollbar"> {{-- Agar bisa discroll di HP --}}
            <div class="min-w-[800px] flex flex-col items-center"> {{-- Min width agar bagan tidak gepeng --}}

                @php
                    $rektor = $groupedLeaders['Rektorat']->first(fn($i) => str_contains(strtolower($i->name), 'rektor') && !str_contains(strtolower($i->name), 'wakil'));
                    $wakil = $groupedLeaders['Rektorat']->reject(fn($i) => $i->id === ($rektor->id ?? 0));
                @endphp

                {{-- LEVEL 1: REKTOR --}}
                @if($rektor)
                <div class="relative z-10 mb-12">
                    <div class="flex flex-col items-center bg-white p-6 rounded-2xl shadow-2xl border-t-4 border-unmaris-yellow w-72 relative group hover:-translate-y-2 transition duration-300">
                        {{-- Connector ke Bawah --}}
                        <div class="absolute -bottom-12 left-1/2 w-0.5 h-12 bg-slate-300"></div>

                        <div class="w-32 h-32 rounded-full border-4 border-white shadow-md overflow-hidden mb-4 bg-gray-200">
                            @if($rektor->currentOfficial)
                                <img src="{{ $rektor->currentOfficial->photo_url }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400"><i class="fas fa-user text-5xl"></i></div>
                            @endif
                        </div>
                        <h3 class="text-lg font-extrabold text-gray-900 text-center leading-tight">
                            {{ $rektor->currentOfficial->name ?? '-(Kosong)-' }}
                        </h3>
                        <div class="bg-unmaris-blue text-white text-xs font-bold px-3 py-1 rounded-full mt-2 uppercase tracking-wider">
                            {{ $rektor->name }}
                        </div>
                    </div>
                </div>
                @endif

                {{-- LEVEL 2: WAKIL REKTOR --}}
                <div class="flex justify-center gap-8 mb-16 relative w-full">
                    {{-- Garis Horizontal Panjang di atas level 2 --}}
                    <div class="absolute -top-12 left-[10%] right-[10%] h-0.5 bg-slate-300"></div>
                    {{-- Garis Vertikal Tengah dari Rektor --}}
                    <div class="absolute -top-12 left-1/2 w-0.5 h-12 bg-slate-300 transform -translate-x-1/2"></div>

                    @foreach($wakil as $pos)
                        <div class="flex flex-col items-center tree-branch px-4">
                            <div class="bg-white p-5 rounded-xl shadow-lg border-l-4 border-blue-500 w-56 text-center hover:shadow-xl transition duration-300 relative mt-6">
                                {{-- Garis Konektor ke atas (CSS Class) --}}
                                
                                <div class="w-20 h-20 mx-auto rounded-full border-2 border-gray-100 overflow-hidden mb-3 bg-gray-100">
                                    @if($pos->currentOfficial)
                                        <img src="{{ $pos->currentOfficial->photo_url }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-300"><i class="fas fa-user text-2xl"></i></div>
                                    @endif
                                </div>
                                <h4 class="text-sm font-bold text-gray-800 leading-tight min-h-[2.5rem] flex items-center justify-center">
                                    {{ $pos->currentOfficial->name ?? '-' }}
                                </h4>
                                <p class="text-[10px] font-bold text-blue-600 uppercase mt-1">{{ $pos->name }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- LEVEL 3: DEKAN --}}
                @if($dekans->count() > 0)
                <div class="relative w-full">
                    {{-- Judul Section --}}
                    <div class="flex justify-center mb-8 relative z-10">
                        <span class="bg-gray-200 text-gray-600 px-4 py-1 rounded-full text-xs font-bold uppercase tracking-widest border border-white shadow-sm">
                            Pimpinan Fakultas
                        </span>
                    </div>
                    
                    {{-- Garis konektor pusat ke Fakultas --}}
                    <div class="absolute -top-10 left-1/2 w-0.5 h-14 bg-slate-300 transform -translate-x-1/2 -z-10"></div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 w-full px-4">
                        @foreach($dekans as $fakultas)
                            <div class="bg-white rounded-xl p-4 shadow border-t-4 border-green-600 text-center relative mt-6 tree-branch">
                                {{-- Konektor khusus CSS --}}
                                
                                <div class="w-16 h-16 mx-auto rounded-full border border-gray-200 overflow-hidden mb-3 bg-gray-50">
                                    @if($fakultas->dekanAktif && $fakultas->dekanAktif->dosen->foto_profil)
                                        <img src="{{ asset('storage/'.$fakultas->dekanAktif->dosen->foto_profil) }}" class="w-full h-full object-cover">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($fakultas->dekanAktif->dosen->nama_lengkap ?? 'Dekan') }}" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <h5 class="text-xs font-bold text-gray-900 leading-tight line-clamp-2 h-8 flex items-center justify-center">
                                    {{ $fakultas->dekanAktif->dosen->nama_lengkap ?? '-' }}
                                </h5>
                                <p class="text-[10px] text-green-700 font-bold uppercase mt-1">Dekan</p>
                                <p class="text-[9px] text-gray-500">{{ $fakultas->nama_fakultas }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>
        </div>
        @endif

        {{-- 4. KAPRODI (List Grid Biasa) --}}
        @if(isset($kaprodis) && $kaprodis->count() > 0)
            <div class="mt-20 pt-10 border-t border-gray-200">
                <div class="text-center mb-10">
                    <h3 class="text-2xl font-extrabold text-unmaris-blue">Ketua Program Studi</h3>
                    <p class="text-gray-500">Ujung tombak pelayanan akademik di setiap jurusan.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6">
                    @foreach($kaprodis as $prodi)
                        <div class="flex items-center gap-3 p-4 bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition group" title="{{ $prodi->kaprodiAktif->dosen->nama_lengkap ?? '' }}">
                            <div class="w-12 h-12 rounded-full overflow-hidden shrink-0 bg-gray-100 border">
                                @if($prodi->kaprodiAktif && $prodi->kaprodiAktif->dosen->foto_profil)
                                    <img src="{{ asset('storage/'.$prodi->kaprodiAktif->dosen->foto_profil) }}" class="w-full h-full object-cover">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($prodi->kaprodiAktif->dosen->nama_lengkap ?? 'Kaprodi') }}&background=random&color=fff" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="min-w-0 w-full">
                                {{-- PERBAIKAN: Ganti truncate dengan line-clamp dan h-8 untuk menampung 2 baris --}}
                                <h5 class="text-xs font-bold text-gray-900 leading-tight line-clamp-2 h-8 flex items-center">
                                    {{ $prodi->kaprodiAktif->dosen->nama_lengkap ?? '-' }}
                                </h5>
                                <p class="text-[10px] text-gray-500 uppercase truncate">Kaprodi {{ $prodi->nama_prodi }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>