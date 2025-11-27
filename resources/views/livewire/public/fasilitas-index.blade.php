<div>
    {{-- HEADER --}}
    <section class="bg-unmaris-blue text-white pt-48 pb-24 relative overflow-hidden">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-unmaris-yellow/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 rounded-full bg-white/10 blur-3xl"></div>
        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <h1 class="text-4xl md:text-6xl font-extrabold mb-4 tracking-tight">Fasilitas Kampus</h1>
            <p class="text-blue-100 text-lg max-w-2xl mx-auto">
                Sarana dan prasarana modern untuk mendukung proses pembelajaran, riset, dan pengembangan diri mahasiswa.
            </p>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-6 py-16 -mt-12 relative z-20">
        
        {{-- FILTER BUTTONS --}}
        <div class="flex flex-wrap justify-center gap-3 mb-12">
            <button wire:click="setCategory('')" 
                class="px-5 py-2 rounded-full text-sm font-bold transition shadow-md 
                {{ $category == '' ? 'bg-unmaris-yellow text-unmaris-blue' : 'bg-white text-gray-600 hover:bg-gray-100' }}">
                Semua
            </button>
            @foreach($categories as $cat)
                <button wire:click="setCategory('{{ $cat->category }}')" 
                    class="px-5 py-2 rounded-full text-sm font-bold transition shadow-md 
                    {{ $category == $cat->category ? 'bg-unmaris-yellow text-unmaris-blue' : 'bg-white text-gray-600 hover:bg-gray-100' }}">
                    {{ $cat->category }} <span class="opacity-60 ml-1 text-xs">({{ $cat->count }})</span>
                </button>
            @endforeach
        </div>

        {{-- GRID FACILITIES --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($facilities as $item)
                <div class="group bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-2xl hover:-translate-y-2 transition duration-500">
                    
                    {{-- Image Container --}}
                    <div class="h-64 overflow-hidden relative">
                        <img src="{{ $item->image_url }}" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-80"></div>
                        
                        {{-- Badge Kategori --}}
                        <span class="absolute top-4 left-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-unmaris-blue uppercase shadow-sm">
                            {{ $item->category }}
                        </span>

                        {{-- Text Overlay --}}
                        <div class="absolute bottom-0 left-0 p-6 text-white">
                            <h3 class="text-xl font-bold leading-tight mb-1">{{ $item->name }}</h3>
                        </div>
                    </div>

                    {{-- Description (Hover Reveal Effect) --}}
                    <div class="p-6">
                        <p class="text-gray-600 text-sm leading-relaxed line-clamp-3">
                            {{ $item->description ?? 'Fasilitas pendukung kegiatan akademik dan non-akademik mahasiswa.' }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20 text-gray-400 bg-gray-50 rounded-2xl border border-dashed border-gray-300">
                    <i class="fas fa-building text-4xl mb-3 opacity-50"></i>
                    <p>Belum ada data fasilitas untuk kategori ini.</p>
                </div>
            @endforelse
        </div>

    </div>
</div>