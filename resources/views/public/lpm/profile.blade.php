<x-layouts.public title="Profil Lembaga Penjaminan Mutu">

    {{-- HEADER SECTION (Konsisten dengan Index & Document) --}}
    <section class="bg-unmaris-blue text-white pt-28 pb-24 relative overflow-hidden">
        {{-- Dekorasi Background --}}
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-unmaris-yellow/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 rounded-full bg-white/10 blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <nav class="flex justify-center text-sm text-unmaris-yellow/80 mb-4 font-medium">
                <a href="{{ route('lpm.index') }}" class="hover:text-white transition">LPM</a>
                <span class="mx-2">/</span>
                <span class="text-white">Profil & Visi Misi</span>
            </nav>

            <h1 class="text-4xl md:text-5xl font-extrabold mb-4 tracking-tight">
                Profil LPM UNMARIS
            </h1>

            <p class="text-blue-100 font-medium max-w-2xl mx-auto text-lg leading-relaxed">
                Fondasi, arah, dan komitmen kami dalam membangun budaya mutu yang berkelanjutan di lingkungan universitas.
            </p>
        </div>
    </section>

    {{-- MAIN CONTENT GRID (Overlapping Effect) --}}
    <div class="max-w-7xl mx-auto px-6 pb-16 grid lg:grid-cols-3 gap-10 -mt-12 relative z-20">

        {{-- LEFT & CENTER COLUMN: Visi dan Misi --}}
        <div class="lg:col-span-2 space-y-8">

            {{-- Visi Card --}}
            <div class="bg-white p-8 rounded-2xl shadow-xl border-t-4 border-unmaris-yellow">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 rounded-full bg-unmaris-yellow/10 flex items-center justify-center mr-4">
                        <i class="fas fa-eye text-unmaris-yellow text-xl"></i>
                    </div>
                    <h2 class="text-3xl font-extrabold text-unmaris-blue">Visi</h2>
                </div>

                <div class="bg-blue-50/50 p-6 rounded-xl border border-blue-100">
                    <p class="text-xl text-gray-800 leading-relaxed font-bold text-center font-serif italic">
                        "{{ $profileData['visi'] }}"
                    </p>
                </div>
            </div>

            {{-- Misi Card --}}
            <div class="bg-white p-8 rounded-2xl shadow-xl border-t-4 border-unmaris-blue">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 rounded-full bg-unmaris-blue/10 flex items-center justify-center mr-4">
                        <i class="fas fa-rocket text-unmaris-blue text-xl"></i>
                    </div>
                    <h2 class="text-3xl font-extrabold text-unmaris-blue">Misi</h2>
                </div>

                <ul class="space-y-4">
                    @foreach($profileData['misi'] as $index => $misi)
                        <li class="flex items-start group p-3 rounded-lg hover:bg-gray-50 transition duration-200">
                            <span class="flex-shrink-0 w-8 h-8 bg-unmaris-blue text-white text-sm font-bold rounded-full flex items-center justify-center mt-0.5 mr-4 shadow-md group-hover:bg-unmaris-yellow group-hover:text-unmaris-blue transition">
                                {{ $index + 1 }}
                            </span>
                            <span class="text-lg text-gray-700 font-medium">{{ $misi }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- RIGHT COLUMN: Struktur Organisasi --}}
        <aside class="lg:col-span-1">
            <div class="bg-white p-6 rounded-2xl shadow-xl lg:sticky lg:top-24 border-t-4 border-gray-800">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-sitemap text-gray-400 mr-2"></i> Struktur Organisasi
                </h3>

                <div class="group relative cursor-pointer overflow-hidden rounded-lg border border-gray-200">
                    <img src="{{ $profileData['struktur_img'] }}" alt="Struktur Organisasi LPM" class="w-full h-auto transform transition duration-500 group-hover:scale-105">

                    {{-- Overlay Hover --}}
                    <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                        <span class="text-white font-bold text-sm px-4 py-2 border border-white rounded-full">
                            <i class="fas fa-search-plus mr-1"></i> Perbesar
                        </span>
                    </div>
                </div>

                <p class="text-xs text-gray-500 mt-3 text-center">
                    Klik gambar untuk tampilan penuh.
                </p>

                {{-- Download Button --}}
                <div class="mt-6 pt-4 border-t border-gray-100">
                    <a href="#" class="flex items-center justify-center w-full py-2 px-4 bg-gray-100 text-gray-700 rounded-lg font-bold text-sm hover:bg-unmaris-blue hover:text-white transition duration-300">
                        <i class="fas fa-download mr-2"></i> Unduh Bagan (PDF)
                    </a>
                </div>
            </div>
        </aside>

    </div>
</x-layouts.public>
