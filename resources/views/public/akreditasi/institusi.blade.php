<x-layouts.public title="Akreditasi Institusi">

    {{-- 1. HERO SECTION --}}
    <section class="bg-unmaris-blue text-white pt-32 pb-24 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/diagmonds-light.png')]"></div>
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-unmaris-yellow/10 blur-3xl"></div>
        
        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight leading-tight mb-4">
                Akreditasi Institusi
            </h1>
            <p class="text-blue-100 text-lg max-w-2xl mx-auto leading-relaxed">
                Komitmen mutu UNMARIS secara institusional diakui oleh Badan Akreditasi Nasional Perguruan Tinggi (BAN-PT).
            </p>
        </div>
    </section>

    {{-- 2. MAIN CONTENT (STATUS & SK) --}}
    <div class="max-w-7xl mx-auto px-6 py-16 -mt-12 relative z-20">
        <div class="grid lg:grid-cols-3 gap-10">

            {{-- Left: Status Utama --}}
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white p-8 rounded-3xl shadow-2xl border border-gray-100">
                    <h2 class="text-2xl font-extrabold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-award text-unmaris-yellow mr-3"></i> Status Akreditasi Saat Ini
                    </h2>
                    
                    <div class="bg-unmaris-blue/90 p-8 rounded-2xl text-white text-center shadow-lg">
                        <p class="text-xl font-medium mb-3">Peringkat Akreditasi</p>
                        <p class="text-6xl font-black tracking-widest text-unmaris-yellow mb-4">
                            {{ $apt['status'] ?? 'BELUM TERAKREDITASI' }}
                        </p>
                        <p class="text-sm text-blue-200">{{ $apt['sk_number'] ?? 'SK belum diterbitkan' }}</p>
                    </div>

                    <div class="mt-8 grid sm:grid-cols-2 gap-4">
                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                            <span class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Berlaku Hingga</span>
                            <p class="text-lg font-extrabold text-green-600">{{ $apt['valid_until'] ?? 'N/A' }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 text-right">
                            <a href="{{ $apt['sertifikat_link'] ?? '#' }}" class="inline-flex items-center font-bold text-unmaris-blue hover:text-unmaris-yellow transition">
                                Unduh Sertifikat <i class="fas fa-download ml-2"></i>
                            </a>
                            <p class="text-xs text-gray-400 mt-1">Format PDF</p>
                        </div>
                    </div>
                </div>

                {{-- Link ke Daftar Prodi --}}
                <div class="p-6 bg-yellow-50 rounded-2xl border border-yellow-100 flex justify-between items-center shadow-md">
                    <h3 class="text-xl font-bold text-gray-800">Lihat Akreditasi Program Studi</h3>
                    <a href="{{ route('akreditasi.prodi') }}" class="px-5 py-2 bg-unmaris-blue text-white rounded-full font-bold text-sm hover:bg-unmaris-yellow hover:text-unmaris-blue transition">
                        Detail Prodi
                    </a>
                </div>
            </div>

            {{-- Right: Ringkasan Prodi --}}
            <aside class="lg:col-span-1 space-y-6">
                <div class="bg-white p-6 rounded-2xl shadow-xl border border-gray-100 sticky lg:top-24">
                    <h4 class="font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2">Ringkasan Mutu Prodi</h4>
                    
                    <ul class="space-y-3">
                        <li class="flex justify-between items-center text-sm font-medium text-gray-700 border-b border-gray-50 pb-2">
                            <span>Total Program Studi</span>
                            <span class="font-extrabold text-unmaris-blue">{{ $prodi->count() }}</span>
                        </li>
                        <li class="flex justify-between items-center text-sm font-medium text-gray-700">
                            <span>Akreditasi Unggul</span>
                            <span class="font-bold text-green-600">{{ $prodi->where('akreditasi', 'Unggul')->count() }}</span>
                        </li>
                        <li class="flex justify-between items-center text-sm font-medium text-gray-700">
                            <span>Akreditasi Baik Sekali</span>
                            <span class="font-bold text-blue-600">{{ $prodi->where('akreditasi', 'Baik Sekali')->count() }}</span>
                        </li>
                        <li class="flex justify-between items-center text-sm font-medium text-gray-700">
                            <span>Akreditasi Baik</span>
                            <span class="font-bold text-yellow-600">{{ $prodi->where('akreditasi', 'Baik')->count() }}</span>
                        </li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</x-layouts.public>