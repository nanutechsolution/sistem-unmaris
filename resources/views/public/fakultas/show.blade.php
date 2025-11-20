<x-layouts.public :title="$fakultas->nama_fakultas">

    {{-- LOGIKA IKON & WARNA (Sama seperti di Home) --}}
    @php
        $icon = 'fas fa-thumbs-up fa-5x';
        $bgTheme = 'bg-unmaris-blue';
        $textTheme = 'text-unmaris-blue';
        
        if (Str::contains($fakultas->nama_fakultas, 'Teknik', true)) {
    $icon = 'fa-solid fa-laptop-code';
    $bgTheme = 'bg-blue-600';
    $textTheme = 'text-blue-700';
} elseif (Str::contains($fakultas->nama_fakultas, ['Ekonomi', 'Bisnis'], true)) {
    $icon = 'fa-solid fa-chart-line';
    $bgTheme = 'bg-yellow-600';
    $textTheme = 'text-yellow-700';
} elseif (Str::contains($fakultas->nama_fakultas, ['Kesehatan'], true)) {
    $icon = 'fa-solid fa-hospital';
    $bgTheme = 'bg-green-600';
    $textTheme = 'text-green-700';
} elseif (Str::contains($fakultas->nama_fakultas, ['Guru', 'Pendidikan'], true)) {
    $icon = 'fa-solid fa-graduation-cap';
    $bgTheme = 'bg-red-600';
    $textTheme = 'text-red-600';
} 
$dean = $fakultas->currentDean->dosen ?? null;
        if ($dean) {
            // Asumsi model Dosen memiliki field 'nama', 'gelar', dan 'foto'
            $fullName = $dean->nama_lengkap . ', ' . ($dean->gelar ?? '');
            // Asumsi field foto ada, jika tidak, gunakan inisial sebagai placeholder
            $photoUrl = $dean->foto_profil ? Storage::url($dean->foto_profil) : 'https://placehold.co/200x200/ccc/666?text=' . urlencode(substr($dean->nama_lengkap, 0, 1)); 
        } else {
            $fullName = 'Pelaksana Tugas Dekan';
            $photoUrl = 'https://placehold.co/200x200/ccc/666?text=Foto+Dekan';
        }
    @endphp

    {{-- 1. HERO SECTION --}}
    <section class="{{ $bgTheme }} text-white pt-32 pb-24 relative overflow-hidden">
        {{-- Background Pattern --}}
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/diagmonds-light.png')]"></div>
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-white/10 blur-3xl"></div>
        
        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center md:text-left flex flex-col md:flex-row items-center gap-8">
            {{-- Icon Besar --}}
            <div class="w-24 h-24 md:w-32 md:h-32 bg-white/10 backdrop-blur-md rounded-3xl flex items-center justify-center text-5xl md:text-6xl text-unmaris-yellow shadow-2xl border border-white/20 transform rotate-3">
                <i class="{{ $icon }}"></i>
            </div>

            <div>
                <span class="inline-block py-1 px-3 rounded-full bg-white/20 text-white text-xs font-bold tracking-widest uppercase mb-3 border border-white/30">
                    Fakultas Akademik
                </span>
                <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight leading-tight mb-4">
                    {{ $fakultas->nama_fakultas }}
                </h1>
                <p class="text-blue-100 text-lg max-w-2xl leading-relaxed">
                    {{ $fakultas->deskripsi }}
                </p>
            </div>
        </div>
    </section>

    {{-- 2. MAIN CONTENT GRID --}}
    <div class="max-w-7xl mx-auto px-6 py-16 -mt-12 relative z-20">
        <div class="grid lg:grid-cols-3 gap-10">

            {{-- LEFT COLUMN: Sambutan Dekan & Info --}}
            <aside class="lg:col-span-1 space-y-8 order-2 lg:order-1">
                
                {{-- Card Sambutan Dekan (Placeholder) --}}
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border-t-4 border-unmaris-yellow">
                    <div class="p-6 text-center bg-gray-50 border-b border-gray-100">
                        <div class="w-24 h-24 mx-auto rounded-full bg-gray-300 border-4 border-white shadow-md overflow-hidden mb-4">
                            {{-- Foto Dekan Placeholder --}}
                            <img src="https://placehold.co/200x200/ccc/666?text=Foto+Dekan" class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">{{$fullName}}</h3>
                        <p class="text-xs text-gray-500 uppercase tracking-wide font-bold">Dekan Fakultas</p>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 text-sm italic text-center leading-relaxed">
                            "Selamat datang di {{ $fakultas->nama_fakultas }}. Kami berkomitmen memberikan pendidikan terbaik berbasis karakter dan teknologi."
                        </p>
                    </div>
                </div>

                {{-- Card Fasilitas --}}
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100">
                    <h4 class="font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-tools {{ $textTheme }} mr-2"></i> Fasilitas Unggulan
                    </h4>
                    <ul class="space-y-3 text-sm text-gray-600">
                        <li class="flex items-center"><i class="fas fa-wifi w-6 text-center text-gray-400 mr-2"></i> Free Wi-Fi Area</li>
                        <li class="flex items-center"><i class="fas fa-desktop w-6 text-center text-gray-400 mr-2"></i> Laboratorium Komputer</li>
                        <li class="flex items-center"><i class="fas fa-book w-6 text-center text-gray-400 mr-2"></i> Ruang Baca Digital</li>
                        <li class="flex items-center"><i class="fas fa-chalkboard-teacher w-6 text-center text-gray-400 mr-2"></i> Ruang Kelas AC</li>
                    </ul>
                </div>

                {{-- CTA Daftar --}}
                <div class="bg-unmaris-blue rounded-2xl p-6 text-center text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-unmaris-yellow/20 rounded-full blur-2xl -mr-10 -mt-10"></div>
                    <h4 class="text-xl font-bold mb-2 relative z-10">Tertarik Bergabung?</h4>
                    <p class="text-sm text-blue-100 mb-4 relative z-10">Jadilah bagian dari keluarga besar kami.</p>
                    <a href="/pmb" class="inline-block w-full py-3 bg-unmaris-yellow text-unmaris-blue font-bold rounded-lg hover:bg-white transition relative z-10 shadow-lg">
                        Daftar Sekarang
                    </a>
                </div>
            </aside>

            {{-- RIGHT COLUMN: Program Studi List --}}
            <div class="lg:col-span-2 order-1 lg:order-2">
                <div class="bg-white p-8 rounded-2xl shadow-xl border border-gray-100 min-h-[500px]">
                    <h2 class="text-2xl font-extrabold text-gray-800 mb-6 flex items-center">
                        <span class="bg-blue-50 text-unmaris-blue w-10 h-10 rounded-full flex items-center justify-center mr-3 text-lg">
                            <i class="fas fa-layer-group"></i>
                        </span>
                        Program Studi Tersedia
                    </h2>

                    <div class="grid md:grid-cols-2 gap-6">
                        @forelse($fakultas->programStudis as $prodi)
                            <div class="group relative border border-gray-200 rounded-xl p-5 hover:shadow-lg hover:border-unmaris-blue/50 transition duration-300 bg-white">
                                {{-- Badge Jenjang --}}
                                <span class="absolute top-4 right-4 bg-gray-100 text-gray-600 text-[10px] font-bold px-2 py-1 rounded uppercase group-hover:bg-unmaris-blue group-hover:text-white transition">
                                    {{ $prodi->jenjang }}
                                </span>

                                <div class="w-12 h-12 rounded-lg bg-blue-50 text-unmaris-blue flex items-center justify-center text-xl mb-4 group-hover:scale-110 transition">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                                
                                <h3 class="text-lg font-bold text-gray-800 mb-2 group-hover:text-unmaris-blue transition">
                                    {{ $prodi->nama_prodi }}
                                </h3>
                                
                                <div class="space-y-1 mb-4">
                                    <p class="text-xs text-gray-500 flex items-center">
                                        <i class="fas fa-star w-5 text-yellow-500"></i>
                                        Akreditasi: <span class="font-bold ml-1 text-gray-700">{{ $prodi->akreditasi ?? 'Proses' }}</span>
                                    </p>
                                    <p class="text-xs text-gray-500 flex items-center">
                                        <i class="fas fa-code w-5 text-gray-400"></i>
                                        Kode: <span class="font-mono ml-1">{{ $prodi->kode_prodi }}</span>
                                    </p>
                                </div>

                                 <a href="{{ route('prodi.show', $prodi->id) }}" class="inline-flex items-center text-sm font-bold text-unmaris-blue hover:text-unmaris-yellow transition">
    Kurikulum & Profil <i class="fas fa-arrow-right ml-2 text-xs"></i>
</a>
                            </div>
                        @empty
                            <div class="col-span-2 text-center py-10 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                                <i class="far fa-folder-open text-4xl text-gray-300 mb-3"></i>
                                <p class="text-gray-500 font-medium">Belum ada data Program Studi.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Additional Info (Visi Misi Fakultas - Placeholder) --}}
                <div class="mt-8 bg-blue-50 rounded-2xl p-8 border border-blue-100">
                    <h3 class="text-lg font-bold text-unmaris-blue mb-3">Keunggulan Fakultas</h3>
                    <p class="text-gray-700 text-sm leading-relaxed">
                        {{ $fakultas->nama_fakultas }} UNMARIS dirancang untuk memberikan pengalaman belajar yang relevan dengan industri. Kurikulum kami diperbarui secara berkala dan didukung oleh dosen praktisi serta akademisi berpengalaman.
                    </p>
                </div>
            </div>

        </div>
    </div>

</x-layouts.public>