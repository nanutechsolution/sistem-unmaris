<x-layouts.public title="Penerimaan Mahasiswa Baru 2025">

    {{-- 1. HERO SECTION (High Conversion Focus) --}}
    <section class="bg-unmaris-blue text-white pt-32 pb-24 relative overflow-hidden">
        {{-- Background Elements --}}
        <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-[800px] h-[800px] rounded-full bg-white/5 blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10 grid lg:grid-cols-2 gap-12 items-center">
            
            {{-- Left Text --}}
            <div class="text-center lg:text-left">
                <span class="inline-block py-1 px-3 rounded-full bg-unmaris-yellow text-unmaris-blue text-xs font-bold tracking-widest uppercase mb-6 animate-pulse">
                    Pendaftaran Gelombang 1 Dibuka!
                </span>
                <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight leading-tight mb-6">
                    Raih Masa Depan <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-unmaris-yellow to-white">Gemilang Bersama Kami.</span>
                </h1>
                <p class="text-blue-100 text-lg mb-8 leading-relaxed">
                    Bergabunglah dengan kampus berbasis teknologi dan karakter. Dapatkan beasiswa khusus untuk pendaftar bulan ini.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="https://pmb.unmaris.ac.id" target="_blank" class="px-8 py-4 bg-unmaris-yellow text-unmaris-blue font-bold text-lg rounded-full hover:bg-white transition duration-300 shadow-lg hover:shadow-unmaris-yellow/50 transform hover:-translate-y-1">
                        Daftar Online Sekarang
                    </a>
                    <a href="#alur" class="px-8 py-4 border border-white/30 text-white font-bold text-lg rounded-full hover:bg-white/10 transition duration-300 backdrop-blur-sm">
                        Lihat Alur & Syarat
                    </a>
                </div>
                {{-- Mini Trust Proof --}}
                <div class="mt-10 flex items-center justify-center lg:justify-start gap-4 text-sm text-blue-200">
                    <div class="flex -space-x-3">
                        <img class="w-10 h-10 rounded-full border-2 border-unmaris-blue" src="https://randomuser.me/api/portraits/women/1.jpg" alt="">
                        <img class="w-10 h-10 rounded-full border-2 border-unmaris-blue" src="https://randomuser.me/api/portraits/men/2.jpg" alt="">
                        <img class="w-10 h-10 rounded-full border-2 border-unmaris-blue" src="https://randomuser.me/api/portraits/women/3.jpg" alt="">
                    </div>
                    <p>Bergabung dengan <span class="font-bold text-white">2.500+</span> Mahasiswa</p>
                </div>
            </div>

            {{-- Right Image / Visual --}}
            <div class="relative hidden lg:block">
                <div class="relative z-10 rounded-3xl overflow-hidden shadow-2xl border-4 border-white/10 transform rotate-3 hover:rotate-0 transition duration-500">
                    <!-- <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" class="w-full h-auto object-cover"> -->
                    
                    {{-- Floating Badge --}}
                    <div class="absolute bottom-6 left-6 bg-white/90 backdrop-blur-md p-4 rounded-xl shadow-lg border border-white/50 max-w-xs">
                        <p class="font-bold text-unmaris-blue text-sm">"Kuliah di sini sangat menyenangkan, fasilitas lengkap dan dosennya asik!"</p>
                        <div class="flex items-center mt-2">
                            <i class="fas fa-star text-yellow-400 text-xs"></i>
                            <i class="fas fa-star text-yellow-400 text-xs"></i>
                            <i class="fas fa-star text-yellow-400 text-xs"></i>
                            <i class="fas fa-star text-yellow-400 text-xs"></i>
                            <i class="fas fa-star text-yellow-400 text-xs"></i>
                            <span class="text-xs text-gray-500 ml-2 font-bold">- Sarah, Alumni 2023</span>
                        </div>
                    </div>
                </div>
                {{-- Back Decoration --}}
                <div class="absolute -top-6 -right-6 w-full h-full rounded-3xl border-2 border-unmaris-yellow/30 z-0"></div>
            </div>

        </div>
    </section>

    {{-- 2. JADWAL GELOMBANG (Timeline Cards) --}}
    <section class="py-20 bg-white relative -mt-10 z-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid md:grid-cols-3 gap-6">
                @foreach($jadwal as $j)
                <div class="bg-white p-8 rounded-2xl shadow-xl border border-gray-100 relative overflow-hidden group hover:-translate-y-2 transition duration-300">
                    @if($j['status'] == 'Dibuka')
                        <div class="absolute top-0 right-0 bg-green-500 text-white text-[10px] font-bold px-3 py-1 rounded-bl-xl shadow-sm">
                            SEDANG DIBUKA
                        </div>
                    @elseif($j['status'] == 'Segera')
                        <!-- Tambahan untuk Status Segera -->
                        <div class="absolute top-0 right-0 bg-yellow-500 text-white text-[10px] font-bold px-3 py-1 rounded-bl-xl shadow-sm">
                            AKAN DATANG
                        </div>
                    @elseif($j['status'] == 'Tutup')
                        <div class="absolute top-0 right-0 bg-gray-400 text-white text-[10px] font-bold px-3 py-1 rounded-bl-xl shadow-sm">
                            DITUTUP
                        </div>
                    @endif

                    <h3 class="text-xl font-bold text-unmaris-blue mb-2">{{ $j['gelombang'] }}</h3>
                    <p class="text-gray-500 text-sm mb-4"><i class="far fa-calendar-alt mr-2"></i> {{ $j['periode'] }}</p>
                    
                    <div class="bg-blue-50 rounded-lg p-3 mb-4">
                        <p class="text-xs text-blue-600 font-bold uppercase tracking-wide mb-1">Promo Khusus</p>
                        <p class="text-sm font-bold text-gray-800">{{ $j['promo'] }}</p>
                    </div>

                     @if($j['status'] == 'Dibuka')
                        <a href="https://pmb.unmaris.ac.id" class="block w-full py-3 bg-unmaris-blue text-white text-center rounded-lg font-bold text-sm hover:bg-yellow-400 hover:text-unmaris-blue transition shadow-lg shadow-blue-200">
                            Daftar Gelombang Ini
                        </a>
                    @elseif($j['status'] == 'Segera')
                        <!-- Tombol Kuning untuk Segera -->
                        <button disabled class="block w-full py-3 bg-yellow-100 text-yellow-700 text-center rounded-lg font-bold text-sm cursor-not-allowed border border-yellow-200">
                            Segera Dibuka
                        </button>
                    @else
                        <!-- Tombol Abu untuk Tutup -->
                        <button disabled class="block w-full py-3 bg-gray-100 text-gray-400 text-center rounded-lg font-bold text-sm cursor-not-allowed border border-gray-200">
                            Pendaftaran Ditutup
                        </button>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 3. ALUR PENDAFTARAN (Step by Step) --}}
    <section id="alur" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold text-gray-900">Alur Pendaftaran Mudah</h2>
                <p class="text-gray-500 mt-2">Hanya 4 langkah mudah untuk menjadi bagian dari UNMARIS.</p>
            </div>

            <div class="relative">
                {{-- Connecting Line (Desktop) --}}
                <div class="hidden md:block absolute top-1/2 left-0 w-full h-1 bg-gray-200 -translate-y-1/2 z-0"></div>

                <div class="grid md:grid-cols-4 gap-8 relative z-10">
                    {{-- Step 1 --}}
                    <div class="text-center group">
                        <div class="w-20 h-20 bg-white border-4 border-unmaris-blue text-unmaris-blue rounded-full flex items-center justify-center text-2xl mx-auto mb-6 shadow-lg group-hover:bg-unmaris-blue group-hover:text-white transition duration-300">
                            <i class="fas fa-laptop"></i>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900 mb-2">1. Daftar Akun</h4>
                        <p class="text-sm text-gray-600 px-4">Isi formulir data diri di website PMB dan dapatkan ID Pendaftar.</p>
                    </div>
                    {{-- Step 2 --}}
                    <div class="text-center group">
                        <div class="w-20 h-20 bg-white border-4 border-unmaris-blue text-unmaris-blue rounded-full flex items-center justify-center text-2xl mx-auto mb-6 shadow-lg group-hover:bg-unmaris-blue group-hover:text-white transition duration-300">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900 mb-2">2. Pembayaran</h4>
                        <p class="text-sm text-gray-600 px-4">Bayar biaya pendaftaran melalui Bank Mitra atau E-Wallet.</p>
                    </div>
                    {{-- Step 3 --}}
                    <div class="text-center group">
                        <div class="w-20 h-20 bg-white border-4 border-unmaris-blue text-unmaris-blue rounded-full flex items-center justify-center text-2xl mx-auto mb-6 shadow-lg group-hover:bg-unmaris-blue group-hover:text-white transition duration-300">
                            <i class="fas fa-pen-alt"></i>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900 mb-2">3. Ujian Seleksi</h4>
                        <p class="text-sm text-gray-600 px-4">Ikuti tes potensi akademik secara online (One Day Service).</p>
                    </div>
                    {{-- Step 4 --}}
                    <div class="text-center group">
                        <div class="w-20 h-20 bg-white border-4 border-unmaris-blue text-unmaris-blue rounded-full flex items-center justify-center text-2xl mx-auto mb-6 shadow-lg group-hover:bg-unmaris-blue group-hover:text-white transition duration-300">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900 mb-2">4. Daftar Ulang</h4>
                        <p class="text-sm text-gray-600 px-4">Lengkapi berkas dan resmi menjadi mahasiswa UNMARIS.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 4. BIAYA KULIAH (Transparency) --}}
    <section class="py-20 bg-white">
        <div class="max-w-5xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900">Estimasi Biaya Kuliah</h2>
                <p class="text-gray-500 mt-2">Transparan, terjangkau, dan dapat diangsur.</p>
            </div>

            <div class="bg-blue-50 rounded-3xl p-8 border border-blue-100">
                <div class="grid md:grid-cols-2 gap-10 items-center">
                    <div>
                        <h3 class="text-2xl font-bold text-unmaris-blue mb-6">Komponen Biaya Awal</h3>
                        <ul class="space-y-4">
                            <li class="flex justify-between items-center border-b border-blue-200 pb-2">
                                <span class="text-gray-700">Pendaftaran</span>
                                <span class="font-bold text-gray-900">Rp {{ number_format($biaya['Reguler']['pendaftaran'], 0, ',', '.') }}</span>
                            </li>
                            <li class="flex justify-between items-center border-b border-blue-200 pb-2">
                                <span class="text-gray-700">SPP Per Semester (Estimasi)</span>
                                <span class="font-bold text-gray-900">Rp {{ number_format($biaya['Reguler']['spp_semester'], 0, ',', '.') }}</span>
                            </li>
                            <li class="flex justify-between items-center border-b border-blue-200 pb-2">
                                <span class="text-gray-700">Dana Pengembangan (DPP)</span>
                                <span class="font-bold text-gray-900">Rp {{ number_format($biaya['Reguler']['dpp_awal'], 0, ',', '.') }}</span>
                            </li>
                            <li class="flex justify-between items-center border-b border-blue-200 pb-2">
                                <span class="text-gray-700">Atribut & Orientasi</span>
                                <span class="font-bold text-gray-900">Rp {{ number_format($biaya['Reguler']['lainnya'], 0, ',', '.') }}</span>
                            </li>
                        </ul>
                        <p class="text-xs text-gray-500 mt-4 italic">* Biaya dapat berubah sewaktu-waktu. DPP dapat diangsur 3x.</p>
                    </div>
                    <div class="text-center bg-white p-8 rounded-2xl shadow-lg">
                        <p class="text-gray-500 font-bold mb-2">Total Pembayaran Awal</p>
                        <p class="text-4xl font-extrabold text-unmaris-blue mb-6">
                            Rp {{ number_format(array_sum($biaya['Reguler']), 0, ',', '.') }}
                        </p>
                        <a href="/brosur" class="inline-flex items-center justify-center px-6 py-3 bg-unmaris-yellow text-unmaris-blue font-bold rounded-lg hover:bg-yellow-400 transition w-full">
                            <i class="fas fa-download mr-2"></i> Download Rincian Lengkap
                        </a>
                        <p class="text-xs text-gray-400 mt-3">Format PDF (2MB)</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 5. BEASISWA --}}
    <section class="py-20 bg-unmaris-blue text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-unmaris-yellow/20 rounded-full blur-3xl -mr-10 -mt-10"></div>
        
        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <h2 class="text-3xl font-extrabold mb-8">Program Beasiswa</h2>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-white/20 hover:bg-white/20 transition">
                    <i class="fas fa-medal text-4xl text-unmaris-yellow mb-4"></i>
                    <h3 class="text-xl font-bold mb-2">Beasiswa Prestasi</h3>
                    <p class="text-sm text-blue-100">Potongan hingga 100% untuk siswa berprestasi akademik maupun non-akademik.</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-white/20 hover:bg-white/20 transition">
                    <i class="fas fa-hand-holding-heart text-4xl text-unmaris-yellow mb-4"></i>
                    <h3 class="text-xl font-bold mb-2">KIP Kuliah</h3>
                    <p class="text-sm text-blue-100">Dukungan penuh dari pemerintah untuk calon mahasiswa kurang mampu yang berprestasi.</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-white/20 hover:bg-white/20 transition">
                    <i class="fas fa-church text-4xl text-unmaris-yellow mb-4"></i>
                    <h3 class="text-xl font-bold mb-2">Beasiswa Yayasan</h3>
                    <p class="text-sm text-blue-100">Bantuan khusus dari Yayasan Stella Maris untuk putra-putri daerah.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- 6. FAQ (Accordion) --}}
    <section class="py-20 bg-gray-50">
        <div class="max-w-3xl mx-auto px-6">
            <h2 class="text-3xl font-extrabold text-center text-gray-900 mb-10">Pertanyaan Sering Diajukan</h2>
            
            <div class="space-y-4" x-data="{ active: 1 }">
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <button @click="active = 1" class="w-full px-6 py-4 text-left font-bold text-gray-800 flex justify-between items-center hover:bg-gray-50">
                        Apakah pendaftaran bisa dilakukan offline?
                        <i class="fas fa-chevron-down text-gray-400" :class="active === 1 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="active === 1" x-collapse class="px-6 pb-6 text-gray-600 text-sm">
                        Bisa. Silakan datang langsung ke Sekretariat PMB di Kampus UNMARIS pada jam kerja (08.00 - 16.00 WITA) dengan membawa berkas persyaratan.
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <button @click="active = 2" class="w-full px-6 py-4 text-left font-bold text-gray-800 flex justify-between items-center hover:bg-gray-50">
                        Apa saja syarat pendaftaran ulang?
                        <i class="fas fa-chevron-down text-gray-400" :class="active === 2 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="active === 2" x-collapse class="px-6 pb-6 text-gray-600 text-sm">
                        Fotokopi Ijazah/SKL yang dilegalisir, Fotokopi KK & KTP, Pas foto terbaru, dan Bukti pembayaran daftar ulang.
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-layouts.public>