<div>
    {{-- HEADER: SELAMAT DATANG --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Dashboard Overview</h1>
            <p class="text-sm text-gray-500">Selamat datang kembali, <span class="font-bold text-unmaris-blue">{{ Auth::user()->name }}</span>!</p>
        </div>

        {{-- Indikator Semester Aktif --}}
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm px-4 py-2 flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase font-bold">Semester Aktif</p>
                <p class="text-sm font-bold text-gray-800">
                    {{ $activeSemester->nama_tahun ?? 'Belum Diset' }} 
                    <span class="text-xs font-normal text-gray-500">({{ $activeSemester->semester ?? '-' }})</span>
                </p>
            </div>
        </div>
    </div>

    {{-- TAMPILAN UNTUK BAAK & SUPER ADMIN --}}
    @hasrole('super_admin|baak')
        {{-- 1. STATISTIK KARTU UTAMA --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            
            {{-- Card 1: Mahasiswa --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 group hover:shadow-md transition">
                <div class="w-14 h-14 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl group-hover:scale-110 transition">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Mahasiswa Aktif</p>
                    <h3 class="text-2xl font-extrabold text-gray-800">{{ $stats['mahasiswa_aktif'] ?? 0 }}</h3>
                </div>
            </div>

            {{-- Card 2: Dosen --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 group hover:shadow-md transition">
                <div class="w-14 h-14 rounded-xl bg-green-50 text-green-600 flex items-center justify-center text-2xl group-hover:scale-110 transition">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Dosen Tetap</p>
                    <h3 class="text-2xl font-extrabold text-gray-800">{{ $stats['dosen_tetap'] ?? 0 }}</h3>
                </div>
            </div>

            {{-- Card 3: Prodi --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 group hover:shadow-md transition">
                <div class="w-14 h-14 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-2xl group-hover:scale-110 transition">
                    <i class="fas fa-university"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Program Studi</p>
                    <h3 class="text-2xl font-extrabold text-gray-800">{{ $stats['total_prodi'] ?? 0 }}</h3>
                </div>
            </div>

            {{-- Card 4: Berita --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 group hover:shadow-md transition">
                <div class="w-14 h-14 rounded-xl bg-yellow-50 text-yellow-600 flex items-center justify-center text-2xl group-hover:scale-110 transition">
                    <i class="fas fa-newspaper"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Berita Terbit</p>
                    <h3 class="text-2xl font-extrabold text-gray-800">{{ $stats['berita_pub'] ?? 0 }}</h3>
                </div>
            </div>
        </div>

        {{-- 2. CONTENT GRID (CHART & ACTIVITY) --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- KOLOM KIRI: Distribusi Mahasiswa (Simple Bar Chart) --}}
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-800">Populasi Mahasiswa per Prodi</h3>
                    <a href="{{ route('admin.civitas.mahasiswa.index') }}" class="text-xs text-unmaris-blue font-bold hover:underline">Lihat Detail</a>
                </div>

                <div class="space-y-5">
                    @foreach($prodiStats as $prodi)
                        @php
                            // Hitung persentase sederhana untuk lebar bar (Max 100%)
                            $max = $prodiStats->max('total') > 0 ? $prodiStats->max('total') : 1; 
                            $percent = ($prodi->total / $max) * 100;
                            // Warna bar selang-seling
                            $colors = ['bg-blue-500', 'bg-green-500', 'bg-yellow-500', 'bg-purple-500', 'bg-red-500'];
                            $color = $colors[$loop->index % 5];
                        @endphp
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-medium text-gray-700">{{ $prodi->nama_prodi }}</span>
                                <span class="font-bold text-gray-900">{{ $prodi->total }} Mhs</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2.5">
                                <div class="{{ $color }} h-2.5 rounded-full transition-all duration-1000" style="width: {{ $percent }}%"></div>
                            </div>
                        </div>
                    @endforeach
                    
                    @if(count($prodiStats) == 0)
                        <p class="text-center text-gray-400 py-10 italic">Belum ada data mahasiswa.</p>
                    @endif
                </div>
            </div>

            {{-- KOLOM KANAN: Berita Terbaru / Aktivitas --}}
            <div class="lg:col-span-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-800">Berita Terbaru</h3>
                    <a href="{{ route('admin.cms.posts.index') }}" class="text-xs bg-blue-50 text-blue-600 px-2 py-1 rounded hover:bg-blue-100 transition">Kelola</a>
                </div>

                <div class="space-y-4">
                    @foreach($latestPosts as $post)
                        <div class="flex gap-3 group">
                            <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden shrink-0">
                                @if($post->featured_image)
                                    <img src="{{ asset('storage/'.$post->featured_image) }}" class="w-full h-full object-cover group-hover:scale-110 transition">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300"><i class="fas fa-image"></i></div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-bold text-gray-800 leading-snug line-clamp-2 group-hover:text-unmaris-blue transition">
                                    {{ $post->title }}
                                </h4>
                                <p class="text-xs text-gray-400 mt-1">{{ $post->published_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endforeach
                    @if(count($latestPosts) == 0)
                         <p class="text-center text-gray-400 py-6 italic text-xs">Belum ada berita.</p>
                    @endif
                </div>

                <div class="mt-6 pt-6 border-t border-gray-100">
                    <a href="{{ route('admin.cms.posts.index') }}" class="block w-full py-2 border border-dashed border-gray-300 text-gray-500 text-center rounded-lg hover:border-unmaris-blue hover:text-unmaris-blue transition text-sm">
                        <i class="fas fa-plus mr-1"></i> Tulis Berita Baru
                    </a>
                </div>
            </div>
        </div>
    @endhasrole

    {{-- TAMPILAN UNTUK LPM (Khusus Mutu) --}}
    @hasrole('lpm')
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 text-center py-20">
            <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4 text-unmaris-blue">
                <i class="fas fa-certificate text-4xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800">Dashboard Penjaminan Mutu</h2>
            <p class="text-gray-500 mt-2 max-w-lg mx-auto">Anda login sebagai Admin LPM. Silakan kelola dokumen mutu dan informasi akreditasi melalui menu di samping.</p>
            
            <div class="mt-8 flex justify-center gap-4">
                <a href="{{ route('admin.lpm.documents.index') }}" class="bg-unmaris-blue text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-800 transition">
                    Kelola Dokumen
                </a>
                <a href="{{ route('admin.lpm.announcements.index') }}" class="bg-gray-100 text-gray-700 px-6 py-2 rounded-lg font-bold hover:bg-gray-200 transition">
                    Info Mutu
                </a>
            </div>
        </div>
    @endhasrole
</div>