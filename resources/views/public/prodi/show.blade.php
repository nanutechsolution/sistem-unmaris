<x-layouts.public :title="$prodi->nama_prodi">

    {{-- 1. HERO SECTION --}}
    <section class="bg-unmaris-blue text-white pt-32 pb-24 relative overflow-hidden">
        {{-- Pattern --}}
        <div class="absolute top-0 left-0 w-full h-full opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
        <div class="absolute bottom-0 right-0 -mr-20 -mb-20 w-96 h-96 rounded-full bg-unmaris-yellow/10 blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10">
            {{-- Breadcrumb --}}
            <nav class="flex items-center text-sm text-unmaris-yellow/80 mb-6 font-medium space-x-2">
                <a href="/" class="hover:text-white transition">Home</a>
                <span>/</span>
                <a href="{{ route('fakultas.show', $prodi->fakultas_id ?? 1) }}" class="hover:text-white transition">{{ $prodi->fakultas->nama_fakultas ?? 'Fakultas' }}</a>
                <span>/</span>
                <span class="text-white">Program Studi</span>
            </nav>

            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <div class="flex items-center gap-3 mb-3">
                        <span class="bg-unmaris-yellow text-unmaris-blue px-3 py-1 rounded-md text-xs font-bold uppercase tracking-wide">
                            {{ $prodi->jenjang }}
                        </span>
                        @if($prodi->akreditasi)
                        <span class="bg-white/20 backdrop-blur-md text-white px-3 py-1 rounded-md text-xs font-bold uppercase tracking-wide border border-white/20">
                            Akreditasi {{ $prodi->akreditasi }}
                        </span>
                        @endif
                    </div>
                    <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight leading-tight">
                        {{ $prodi->nama_prodi }}
                    </h1>
                </div>
                
                {{-- Quick Stats --}}
                <div class="flex gap-6 md:gap-8 text-center">
                    <div>
                        <span class="block text-2xl font-bold text-unmaris-yellow">144</span>
                        <span class="text-xs text-blue-200 uppercase tracking-wider">SKS</span>
                    </div>
                    <div>
                        <span class="block text-2xl font-bold text-unmaris-yellow">8</span>
                        <span class="text-xs text-blue-200 uppercase tracking-wider">Semester</span>
                    </div>
                    <div>
                        <span class="block text-2xl font-bold text-unmaris-yellow">S.Kom</span>
                        <span class="text-xs text-blue-200 uppercase tracking-wider">Gelar</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 2. MAIN CONTENT (TABS) --}}
    <div class="max-w-7xl mx-auto px-6 py-12 -mt-16 relative z-20" x-data="{ activeTab: 'profil' }">
        
        {{-- Tab Navigation --}}
        <div class="bg-white rounded-t-2xl shadow-sm border-b border-gray-200 flex overflow-x-auto scrollbar-hide">
            <button @click="activeTab = 'profil'" 
                    :class="activeTab === 'profil' ? 'text-unmaris-blue border-unmaris-blue bg-blue-50/50' : 'text-gray-500 border-transparent hover:text-unmaris-blue hover:bg-gray-50'"
                    class="px-8 py-4 font-bold text-sm border-b-2 transition whitespace-nowrap flex items-center">
                <i class="far fa-id-card mr-2"></i> Profil & Kompetensi
            </button>
            <button @click="activeTab = 'kurikulum'" 
                    :class="activeTab === 'kurikulum' ? 'text-unmaris-blue border-unmaris-blue bg-blue-50/50' : 'text-gray-500 border-transparent hover:text-unmaris-blue hover:bg-gray-50'"
                    class="px-8 py-4 font-bold text-sm border-b-2 transition whitespace-nowrap flex items-center">
                <i class="fas fa-book mr-2"></i> Kurikulum
            </button>
            <button @click="activeTab = 'dosen'" 
                    :class="activeTab === 'dosen' ? 'text-unmaris-blue border-unmaris-blue bg-blue-50/50' : 'text-gray-500 border-transparent hover:text-unmaris-blue hover:bg-gray-50'"
                    class="px-8 py-4 font-bold text-sm border-b-2 transition whitespace-nowrap flex items-center">
                <i class="fas fa-chalkboard-teacher mr-2"></i> Dosen Pengajar
            </button>
        </div>

        {{-- Tab Content --}}
        <div class="bg-white rounded-b-2xl shadow-xl p-8 md:p-10 min-h-[500px]">
            
            {{-- TAB 1: PROFIL --}}
            <div x-show="activeTab === 'profil'" x-transition.opacity class="grid md:grid-cols-3 gap-12">
                <div class="md:col-span-2 space-y-8">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Tentang Program Studi</h3>
                        <div class="prose prose-blue text-gray-600 leading-relaxed">
                            <p>Program Studi {{ $prodi->nama_prodi }} di Universitas Stella Maris Sumba dirancang untuk menghasilkan lulusan yang tidak hanya unggul dalam kemampuan teknis, tetapi juga memiliki integritas moral dan jiwa kepemimpinan. Kurikulum kami disusun berdasarkan standar nasional dan kebutuhan industri terkini.</p>
                            <p>Mahasiswa akan dibekali dengan pemahaman mendalam tentang teori serta kesempatan luas untuk praktik langsung melalui laboratorium modern dan program magang mitra.</p>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Kompetensi Lulusan</h3>
                        <ul class="grid sm:grid-cols-2 gap-4">
                            <li class="flex items-start p-4 bg-blue-50 rounded-xl border border-blue-100">
                                <i class="fas fa-check-circle text-unmaris-blue mt-1 mr-3"></i>
                                <span class="text-sm text-gray-700 font-medium">Menguasai konsep teoretis bidang ilmu secara mendalam.</span>
                            </li>
                            <li class="flex items-start p-4 bg-blue-50 rounded-xl border border-blue-100">
                                <i class="fas fa-check-circle text-unmaris-blue mt-1 mr-3"></i>
                                <span class="text-sm text-gray-700 font-medium">Mampu memformulasikan penyelesaian masalah prosedural.</span>
                            </li>
                            <li class="flex items-start p-4 bg-blue-50 rounded-xl border border-blue-100">
                                <i class="fas fa-check-circle text-unmaris-blue mt-1 mr-3"></i>
                                <span class="text-sm text-gray-700 font-medium">Mampu mengambil keputusan strategis berdasarkan analisis data.</span>
                            </li>
                            <li class="flex items-start p-4 bg-blue-50 rounded-xl border border-blue-100">
                                <i class="fas fa-check-circle text-unmaris-blue mt-1 mr-3"></i>
                                <span class="text-sm text-gray-700 font-medium">Memiliki etika profesional dan tanggung jawab sosial.</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="md:col-span-1">
                    <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 sticky top-24">
                        <h4 class="font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-briefcase text-unmaris-yellow mr-2"></i> Prospek Karir
                        </h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($prospekKarir as $karir)
                                <span class="px-3 py-1 bg-white border border-gray-200 rounded-full text-xs font-medium text-gray-600 hover:border-unmaris-blue hover:text-unmaris-blue transition cursor-default">
                                    {{ $karir }}
                                </span>
                            @endforeach
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <h4 class="font-bold text-gray-800 mb-2">Siap Mendaftar?</h4>
                            <p class="text-xs text-gray-500 mb-4">Wujudkan cita-citamu bersama kami.</p>
                            <a href="/pmb" class="block w-full py-3 bg-unmaris-blue text-white text-center font-bold rounded-xl hover:bg-unmaris-yellow hover:text-unmaris-blue transition shadow-lg">
                                Daftar Prodi Ini
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAB 2: KURIKULUM --}}
            <div x-show="activeTab === 'kurikulum'" x-cloak class="space-y-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-800">Struktur Kurikulum</h3>
                    <button class="text-sm font-bold text-unmaris-blue hover:text-unmaris-yellow transition flex items-center">
                        <i class="fas fa-download mr-2"></i> Unduh PDF Kurikulum
                    </button>
                </div>

                <div class="grid md:grid-cols-2 gap-8">
                    @foreach($kurikulum as $semester => $matkul)
                        <div class="border border-gray-200 rounded-xl overflow-hidden">
                            <div class="bg-gray-50 px-6 py-3 border-b border-gray-200 flex justify-between items-center">
                                <h4 class="font-bold text-gray-800">{{ $semester }}</h4>
                                <span class="text-xs font-bold bg-white px-2 py-1 rounded border border-gray-200 text-gray-500">
                                    Total: {{ collect($matkul)->sum('sks') }} SKS
                                </span>
                            </div>
                            <div class="divide-y divide-gray-100">
                                @foreach($matkul as $mk)
                                    <div class="px-6 py-3 flex justify-between items-center hover:bg-blue-50 transition group">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="text-xs font-mono text-gray-400 bg-gray-100 px-1.5 rounded">{{ $mk['kode'] }}</span>
                                                <span class="text-sm font-bold text-gray-700 group-hover:text-unmaris-blue">{{ $mk['nama'] }}</span>
                                            </div>
                                            <span class="text-[10px] text-gray-400 uppercase tracking-wider font-medium mt-0.5 block">{{ $mk['jenis'] }}</span>
                                        </div>
                                        <span class="text-sm font-bold text-gray-600">{{ $mk['sks'] }} SKS</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- TAB 3: DOSEN --}}
            <div x-show="activeTab === 'dosen'" x-cloak>
                <div class="text-center max-w-2xl mx-auto mb-10">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Tim Pengajar Ahli</h3>
                    <p class="text-gray-500">Dosen-dosen kami adalah praktisi dan akademisi berpengalaman di bidangnya.</p>
                </div>

                <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    {{-- Mock Data Dosen --}}
                    @for($i=1; $i<=4; $i++)
                        <div class="group bg-white border border-gray-100 rounded-2xl p-6 text-center hover:shadow-xl hover:border-unmaris-blue/30 transition duration-300">
                            <div class="w-24 h-24 mx-auto rounded-full bg-gray-200 mb-4 overflow-hidden border-4 border-white shadow-md group-hover:scale-105 transition">
                                <img src="https://placehold.co/150x150/003366/FFFFFF?text=Dosen+{{$i}}" class="w-full h-full object-cover">
                            </div>
                            <h4 class="font-bold text-gray-900 mb-1">Nama Dosen {{ $i }}</h4>
                            <p class="text-xs text-unmaris-blue font-bold uppercase tracking-wide mb-3">Spesialisasi AI & Data</p>
                            <div class="flex justify-center gap-2 opacity-0 group-hover:opacity-100 transition">
                                <a href="#" class="text-gray-400 hover:text-unmaris-blue"><i class="fab fa-linkedin"></i></a>
                                <a href="#" class="text-gray-400 hover:text-unmaris-blue"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

        </div>
    </div>

</x-layouts.public>