<x-layouts.public title="Daftar Akreditasi Program Studi">

    {{-- 1. HERO SECTION --}}
    <section class="bg-unmaris-blue text-white pt-48 pb-24 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-96 h-96 rounded-full bg-unmaris-yellow/10 blur-3xl"></div>
        
        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight leading-tight mb-4">
                Akreditasi Program Studi
            </h1>
            <p class="text-blue-100 text-lg max-w-2xl mx-auto leading-relaxed">
                Tabel lengkap peringkat akreditasi setiap program studi di UNMARIS.
            </p>
        </div>
    </section>

    {{-- 2. MAIN CONTENT (Tabel) --}}
    <div class="max-w-7xl mx-auto px-6 py-16 -mt-12 relative z-20">
        
        {{-- Ringkasan di Atas Tabel --}}
        <div class="mb-8 p-6 bg-gray-50 rounded-2xl shadow-inner border border-gray-100 flex flex-wrap justify-between items-center">
            <div class="text-center md:text-left mb-4 md:mb-0">
                <span class="block text-xs font-bold text-gray-500 uppercase tracking-widest">Total Program Studi</span>
                <span class="text-3xl font-extrabold text-unmaris-blue">{{ $totalProdi }}</span>
            </div>
            <div class="text-center">
                <a href="{{ route('public.akreditasi.institusi') }}" class="px-6 py-3 bg-unmaris-yellow text-unmaris-blue font-bold rounded-full text-sm hover:bg-yellow-400 transition">
                    Lihat Status Institusi &raquo;
                </a>
            </div>
        </div>

        {{-- Tabel Akreditasi --}}
        <div class="bg-white rounded-2xl shadow-xl overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">No.</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Fakultas</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Program Studi</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Jenjang</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Peringkat</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">SK Terbaru</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($prodiList as $index => $prodi)
                        @php
                            $akreditasi = $prodi->akreditasi;
                            $status = match ($akreditasi) {
                                'Unggul' => ['text-green-600', 'bg-green-100'],
                                'Baik Sekali' => ['text-blue-600', 'bg-blue-100'],
                                'Baik' => ['text-yellow-600', 'bg-yellow-100'],
                                default => ['text-gray-600', 'bg-gray-100'],
                            };
                        @endphp
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-unmaris-blue">{{ $prodi->fakultas->nama_fakultas ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $prodi->nama_prodi }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-700">{{ $prodi->jenjang }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $status[1] }} {{ $status[0] }}">
                                    {{ $prodi->akreditasi ?? 'Proses' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500 font-mono">
                                SK-{{ $prodi->kode_prodi ?? 'N/A' }} /2024
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                <a href="#" class="text-unmaris-blue hover:text-unmaris-yellow text-xs font-bold">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">Tidak ada data program studi ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.public>