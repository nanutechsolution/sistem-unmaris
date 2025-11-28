<div>
    {{-- HEADER --}}
    <section class="bg-unmaris-blue text-white pt-48 pb-24 relative overflow-hidden">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-unmaris-yellow/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 rounded-full bg-white/10 blur-3xl"></div>
        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <span class="text-unmaris-yellow font-bold tracking-widest uppercase text-sm mb-2 block">Hall of Fame</span>
            <h1 class="text-4xl md:text-6xl font-extrabold mb-4 tracking-tight">
                Jejak Juara UNMARIS
            </h1>
            <p class="text-blue-100 text-lg max-w-2xl mx-auto">
                Dedikasi, kerja keras, dan prestasi membanggakan dari civitas akademika Universitas Stella Maris Sumba.
            </p>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-6 py-16 -mt-12 relative z-20">

        {{-- FILTER TABS --}}
        <div class="flex flex-wrap justify-center gap-3 mb-12">
            @php $cats = ['' => 'Semua', 'Akademik' => 'Akademik', 'Olahraga' => 'Olahraga', 'Seni' => 'Seni & Budaya']; @endphp
            @foreach ($cats as $key => $label)
                <button wire:click="setCategory('{{ $key }}')"
                    class="px-6 py-2.5 rounded-full text-sm font-bold transition shadow-md 
                    {{ $category == $key ? 'bg-unmaris-yellow text-unmaris-blue ring-2 ring-unmaris-yellow ring-offset-2' : 'bg-white text-gray-600 hover:bg-gray-50' }}">
                    {{ $label }}
                </button>
            @endforeach
        </div>

        {{-- GRID PRESTASI --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($achievements as $item)
                {{-- UPDATE: Bungkus dengan Tag A agar bisa diklik --}}
                <a href="{{ route('public.prestasi.show', $item->id) }}"
                    class="group bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:-translate-y-2 transition duration-500 relative block">

                    {{-- Image Wrapper --}}
                    <div class="h-64 overflow-hidden relative">
                        <img src="{{ $item->image_url }}"
                            class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-90">
                        </div>

                        {{-- Badge Medal --}}
                        <div class="absolute top-4 right-4">
                            @if ($item->medal == 'Gold')
                                <div class="w-10 h-10 rounded-full bg-yellow-400 flex items-center justify-center text-white shadow-lg border-2 border-yellow-200"
                                    title="Medali Emas">
                                    <i class="fas fa-medal text-lg"></i>
                                </div>
                            @elseif($item->medal == 'Silver')
                                <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-600 shadow-lg border-2 border-gray-100"
                                    title="Medali Perak">
                                    <i class="fas fa-medal text-lg"></i>
                                </div>
                            @elseif($item->medal == 'Bronze')
                                <div class="w-10 h-10 rounded-full bg-orange-400 flex items-center justify-center text-white shadow-lg border-2 border-orange-200"
                                    title="Medali Perunggu">
                                    <i class="fas fa-medal text-lg"></i>
                                </div>
                            @endif
                        </div>

                        {{-- Category --}}
                        <span
                            class="absolute top-4 left-4 bg-white/90 backdrop-blur px-3 py-1 rounded-lg text-[10px] font-bold text-unmaris-blue uppercase tracking-wider shadow-sm">
                            {{ $item->category }}
                        </span>

                        {{-- Content Overlay --}}
                        <div class="absolute bottom-0 left-0 p-6 w-full">
                            <div class="text-unmaris-yellow text-xs font-bold mb-1 flex items-center gap-2">
                                <i class="fas fa-trophy"></i> {{ $item->level }}
                            </div>
                            <h3
                                class="text-xl font-bold text-white leading-tight mb-1 group-hover:text-unmaris-yellow transition">
                                {{ $item->title }}
                            </h3>
                            <p class="text-gray-300 text-xs">{{ $item->event_name }}</p>
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div
                                class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-400">
                                <i class="fas fa-user"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800">{{ $item->winner_name }}</p>
                                <p class="text-xs text-gray-500">{{ $item->prodi_name ?? 'Mahasiswa UNMARIS' }}</p>
                            </div>
                        </div>

                        <div
                            class="pt-4 border-t border-gray-100 flex justify-between items-center text-xs text-gray-400">
                            <span><i class="far fa-calendar-alt mr-1"></i> {{ $item->date->format('d M Y') }}</span>
                            <span class="text-unmaris-blue font-bold flex items-center">Lihat Detail <i
                                    class="fas fa-arrow-right ml-1 transition-transform group-hover:translate-x-1"></i></span>
                        </div>
                    </div>
                </a>
            @empty
                <div
                    class="col-span-full text-center py-20 bg-gray-50 rounded-2xl border border-dashed border-gray-300">
                    <i class="fas fa-trophy text-4xl text-gray-300 mb-3 block"></i>
                    <p class="text-gray-500">Belum ada data prestasi untuk kategori ini.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-12">
            {{ $achievements->links() }}
        </div>

    </div>
</div>
