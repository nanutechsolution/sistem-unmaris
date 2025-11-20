<x-layouts.public title="Fasilitas Kampus">

    {{-- 1. HERO SECTION --}}
    <section class="bg-unmaris-blue text-white pt-32 pb-24 relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        <div class="absolute bottom-0 right-0 w-full h-full bg-gradient-to-t from-unmaris-blue to-transparent"></div>
        
        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <h1 class="text-4xl md:text-6xl font-extrabold mb-6 tracking-tight">
                Kampus Masa Depan
            </h1>
            <p class="text-blue-100 text-lg max-w-3xl mx-auto leading-relaxed">
                Kami menyediakan lingkungan belajar modern yang didukung oleh fasilitas lengkap untuk menunjang kegiatan akademik dan pengembangan diri mahasiswa.
            </p>
            
            {{-- Video Tour Button (Placeholder) --}}
            <div class="mt-8">
                <button class="inline-flex items-center px-6 py-3 bg-white/10 backdrop-blur-md border border-white/20 rounded-full hover:bg-white hover:text-unmaris-blue transition group">
                    <i class="fas fa-play-circle text-2xl mr-3 text-unmaris-yellow group-hover:text-unmaris-blue"></i>
                    <span class="font-bold">Lihat Video Tour</span>
                </button>
            </div>
        </div>
    </section>

    {{-- 2. GALLERY SECTION (With Filter) --}}
    <section class="py-20 bg-gray-50" x-data="{ activeCat: 'Semua' }">
        <div class="max-w-7xl mx-auto px-6">
            
            {{-- Category Filter Buttons --}}
            <div class="flex flex-wrap justify-center gap-3 mb-12">
                <button @click="activeCat = 'Semua'" 
                        :class="activeCat === 'Semua' ? 'bg-unmaris-blue text-white shadow-lg scale-105' : 'bg-white text-gray-600 hover:bg-gray-100'"
                        class="px-6 py-2 rounded-full font-bold text-sm transition duration-300 border border-gray-200">
                    Semua
                </button>
                @foreach($categories as $cat)
                    <button @click="activeCat = '{{ $cat }}'" 
                            :class="activeCat === '{{ $cat }}' ? 'bg-unmaris-blue text-white shadow-lg scale-105' : 'bg-white text-gray-600 hover:bg-gray-100'"
                            class="px-6 py-2 rounded-full font-bold text-sm transition duration-300 border border-gray-200">
                        {{ $cat }}
                    </button>
                @endforeach
            </div>

            {{-- Gallery Grid --}}
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($facilities as $facility)
                    <div x-show="activeCat === 'Semua' || activeCat === '{{ $facility['category'] }}'" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform scale-90"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         class="group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-500">
                        
                        <div class="relative h-64 overflow-hidden">
                            <img src="{{ $facility['image'] }}" alt="{{ $facility['name'] }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                            
                            {{-- Overlay Gradient --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-60 group-hover:opacity-80 transition"></div>
                            
                            {{-- Badge Category --}}
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 bg-white/90 backdrop-blur-sm text-unmaris-blue text-xs font-bold rounded-lg uppercase tracking-wide shadow-sm">
                                    {{ $facility['category'] }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6 relative">
                            {{-- Floating Icon --}}
                            <div class="absolute -top-8 right-6 w-14 h-14 bg-unmaris-yellow rounded-xl flex items-center justify-center text-unmaris-blue text-2xl shadow-lg transform rotate-3 group-hover:rotate-12 transition duration-300">
                                @if($facility['category'] == 'Akademik') <i class="fas fa-graduation-cap"></i>
                                @elseif($facility['category'] == 'Olahraga') <i class="fas fa-running"></i>
                                @elseif($facility['category'] == 'Ibadah') <i class="fas fa-pray"></i>
                                @else <i class="fas fa-building"></i>
                                @endif
                            </div>

                            <h3 class="text-xl font-extrabold text-gray-900 mb-2 group-hover:text-unmaris-blue transition">
                                {{ $facility['name'] }}
                            </h3>
                            <p class="text-gray-500 text-sm leading-relaxed">
                                {{ $facility['description'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
            
            {{-- Empty State (Just in case) --}}
            <div x-show="false" class="text-center py-12">
                <p class="text-gray-500 italic">Tidak ada fasilitas di kategori ini.</p>
            </div>

        </div>
    </section>

    {{-- 3. LOCATION MAP (Integration) --}}
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="text-unmaris-blue font-bold uppercase tracking-widest text-sm mb-2 block">Lokasi Strategis</span>
                <h2 class="text-3xl font-extrabold text-gray-900 mb-6">Akses Mudah ke Kampus</h2>
                <p class="text-gray-600 mb-8 leading-relaxed">
                    Kampus UNMARIS terletak di jantung kota Waingapu, dikelilingi oleh pemandangan alam Sumba yang indah namun tetap dekat dengan pusat layanan publik.
                </p>
                <ul class="space-y-4">
                    <li class="flex items-center text-gray-700">
                        <i class="fas fa-check-circle text-green-500 mr-3 text-xl"></i> 10 Menit dari Bandara Umbu Mehang Kunda
                    </li>
                    <li class="flex items-center text-gray-700">
                        <i class="fas fa-check-circle text-green-500 mr-3 text-xl"></i> 5 Menit dari Pelabuhan Waingapu
                    </li>
                    <li class="flex items-center text-gray-700">
                        <i class="fas fa-check-circle text-green-500 mr-3 text-xl"></i> Dilalui Transportasi Umum
                    </li>
                </ul>
                <a href="https://maps.google.com" target="_blank" class="inline-block mt-8 px-8 py-3 border-2 border-unmaris-blue text-unmaris-blue font-bold rounded-full hover:bg-unmaris-blue hover:text-white transition">
                    Buka Google Maps
                </a>
            </div>
            <div class="rounded-3xl overflow-hidden shadow-2xl border-4 border-white h-96 relative">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3941.568561275984!2d120.2583733147825!3d-9.651944993090942!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2c4b84e333333333%3A0x3333333333333333!2sWaingapu!5e0!3m2!1sen!2sid!4v1625555555555!5m2!1sen!2sid" 
                    class="w-full h-full filter grayscale hover:grayscale-0 transition duration-700" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
        </div>
    </section>

</x-layouts.public>