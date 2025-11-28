<div class="bg-gray-50 min-h-screen pt-24 pb-20">

    {{-- 1. HERO HEADER (GAMBAR & JUDUL) --}}
    {{-- UPDATE: Tambahkan -mt-24 agar background naik ke atas (di balik navbar) --}}
    {{-- UPDATE: Ubah pt-20 jadi pt-48 agar konten teks turun --}}
    <section class="relative bg-unmaris-blue text-white pt-48 pb-32 overflow-hidden -mt-24">
        {{-- Background Pattern --}}
        <div class="absolute top-0 right-0 w-96 h-96 bg-unmaris-yellow/10 rounded-full blur-3xl -mr-20 -mt-20"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/5 rounded-full blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10">
            {{-- Breadcrumb --}}
            <nav class="flex text-sm text-white/70 mb-6 font-medium space-x-2">
                <a href="/" class="hover:text-unmaris-yellow transition">Home</a>
                <span>/</span>
                <a href="{{ route('public.prestasi.index') }}" class="hover:text-unmaris-yellow transition">Wall of Fame</a>
                <span>/</span>
                <span class="text-white truncate max-w-xs">{{ $achievement->title }}</span>
            </nav>

            <div class="flex flex-col md:flex-row gap-8 items-start">
                <div class="flex-1">
                    {{-- Badges --}}
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="px-3 py-1 rounded-full bg-white/10 border border-white/20 text-xs font-bold uppercase tracking-wide backdrop-blur-sm">
                            {{ $achievement->category }}
                        </span>
                        <span class="px-3 py-1 rounded-full bg-unmaris-yellow text-unmaris-blue text-xs font-bold uppercase tracking-wide">
                            Tingkat {{ $achievement->level }}
                        </span>
                    </div>

                    <h1 class="text-3xl md:text-5xl font-extrabold leading-tight mb-6">
                        {{ $achievement->title }}
                    </h1>
                    
                    <p class="text-xl text-blue-100 font-light flex items-center gap-2">
                        <i class="fas fa-trophy text-unmaris-yellow"></i>
                        {{ $achievement->event_name }}
                    </p>
                </div>
                
                {{-- Medal Display (Visual) --}}
                <div class="hidden md:flex flex-col items-center justify-center bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6 w-40 shrink-0 text-center">
                    @php
                        $medalIcon = match($achievement->medal) {
                            'Gold' => 'text-yellow-400',
                            'Silver' => 'text-gray-300',
                            'Bronze' => 'text-orange-400',
                            default => 'text-blue-400'
                        };
                        $medalLabel = match($achievement->medal) {
                            'Gold' => 'Emas',
                            'Silver' => 'Perak',
                            'Bronze' => 'Perunggu',
                            default => 'Partisipan'
                        };
                    @endphp
                    <i class="fas fa-medal text-6xl {{ $medalIcon }} mb-2 drop-shadow-lg"></i>
                    <span class="text-sm font-bold uppercase tracking-wider">Medali {{ $medalLabel }}</span>
                </div>
            </div>
        </div>
    </section>

    {{-- 2. MAIN CONTENT --}}
    <div class="max-w-7xl mx-auto px-6 -mt-20 relative z-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

            {{-- KOLOM KIRI: FOTO DOKUMENTASI (8 Kolom) --}}
            <div class="lg:col-span-8">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                    {{-- Foto Besar --}}
                    <div class="relative h-[400px] md:h-[500px] bg-gray-200 group">
                        <img src="{{ $achievement->image_url }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-60"></div>
                    </div>

                    <div class="p-8 md:p-10">
                        <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-quote-left text-unmaris-blue mr-3 opacity-50"></i> Cerita Prestasi
                        </h3>
                        <div class="prose prose-lg prose-blue max-w-none text-gray-600 leading-relaxed">
                            @if($achievement->description)
                                {!! nl2br(e($achievement->description)) !!}
                            @else
                                <p class="italic text-gray-400">Belum ada deskripsi detail untuk prestasi ini.</p>
                            @endif
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-100 flex justify-between items-center">
                            <div class="text-sm text-gray-500">
                                <i class="far fa-calendar-alt mr-2"></i> Tanggal Pencapaian: 
                                <span class="font-bold text-gray-800">{{ $achievement->date->translatedFormat('d F Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: PROFIL JUARA (4 Kolom) --}}
            <div class="lg:col-span-4 space-y-8">
                
                {{-- Card Profil Pemenang --}}
                <div class="bg-white p-8 rounded-2xl shadow-lg border-t-4 border-unmaris-blue relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-bl-full -mr-4 -mt-4"></div>
                    
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-6 relative z-10">Profil Juara</h3>
                    
                    <div class="text-center relative z-10">
                        <div class="w-28 h-28 mx-auto bg-gray-100 rounded-full flex items-center justify-center text-4xl text-gray-400 mb-4 shadow-inner border-4 border-white">
                            <i class="fas fa-user"></i>
                        </div>
                        <h4 class="text-xl font-extrabold text-gray-900 mb-1">{{ $achievement->winner_name }}</h4>
                        <p class="text-unmaris-blue font-medium">{{ $achievement->prodi_name ?? 'Mahasiswa UNMARIS' }}</p>
                    </div>

                    <div class="mt-8 space-y-3">
                        <div class="flex justify-between text-sm border-b border-gray-100 pb-2">
                            <span class="text-gray-500">Kategori</span>
                            <span class="font-bold text-gray-800">{{ $achievement->category }}</span>
                        </div>
                        <div class="flex justify-between text-sm border-b border-gray-100 pb-2">
                            <span class="text-gray-500">Level</span>
                            <span class="font-bold text-gray-800">{{ $achievement->level }}</span>
                        </div>
                        <div class="flex justify-between text-sm pb-2">
                            <span class="text-gray-500">Medali</span>
                            <span class="font-bold text-gray-800">{{ $achievement->medal }}</span>
                        </div>
                    </div>
                </div>

                {{-- Prestasi Lainnya --}}
                @if($related->count() > 0)
                <div class="bg-white p-6 rounded-2xl shadow-md border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-4">Prestasi Serupa</h3>
                    <div class="space-y-4">
                        @foreach($related as $item)
                            <a href="{{ route('public.prestasi.show', $item->id) }}" class="flex gap-3 group items-center">
                                <div class="w-12 h-12 bg-gray-100 rounded-lg overflow-hidden shrink-0">
                                    <img src="{{ $item->image_url }}" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition">
                                </div>
                                <div>
                                    <h5 class="text-sm font-bold text-gray-800 group-hover:text-unmaris-blue transition line-clamp-1">{{ $item->title }}</h5>
                                    <p class="text-xs text-gray-500">{{ $item->event_name }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>

        </div>
    </div>

</div>