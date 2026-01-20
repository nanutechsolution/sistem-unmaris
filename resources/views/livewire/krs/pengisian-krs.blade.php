<div>
    <x-slot:header>
        Pengisian KRS (TA. {{ $activeTahunAkademik->nama_tahun }})
    </x-slot:header>

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <div class="text-sm text-gray-500">Mahasiswa</div>
                <div class="text-lg font-semibold text-unmaris-blue">{{ $mahasiswa->nama_lengkap }}</div>
                <div class="text-gray-700">{{ $mahasiswa->nim }}</div>
            </div>
            <div>
                <div class="text-sm text-gray-500">Program Studi</div>
                <div class="text-lg font-semibold text-gray-900">{{ $mahasiswa->programStudi->nama_prodi }}</div>
                <div class="text-gray-700">Angkatan {{ $mahasiswa->angkatan }}</div>
            </div>
            <div>
                <div class="text-sm text-gray-500">Batas Pengambilan SKS</div>
                <div class="text-3xl font-bold text-unmaris-blue">
                    {{ $totalSks }} / <span class="text-gray-500">{{ $maxSks }}</span> SKS
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <div>
            <h3 class="text-xl font-semibold mb-2 text-unmaris-blue">Mata Kuliah Ditawarkan</h3>
            <div class="bg-white shadow-md rounded-lg overflow-hidden overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mata Kuliah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jadwal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($kelasList as $kelas)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $kelas->mataKuliah->nama_mk }}</div>
                                    <div class="text-sm text-gray-500">{{ $kelas->mataKuliah->sks }} SKS (Sm. {{ $kelas->mataKuliah->semester }})</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <div class="font-semibold">{{ $kelas->hari ?? '-' }}</div>
                                    <div class="text-xs text-gray-500">
                                        {{ $kelas->jam_mulai ? \Carbon\Carbon::parse($kelas->jam_mulai)->format('H:i') : '' }} - 
                                        {{ $kelas->jam_selesai ? \Carbon\Carbon::parse($kelas->jam_selesai)->format('H:i') : '' }}
                                    </div>
                                    <div class="text-xs mt-1">{{ $kelas->dosen?->nama_lengkap ?? 'Dosen Belum Diatur' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if($krsHeader->status == 'Draft')
                                        <button wire:click="ambilKelas({{ $kelas->id }})"
                                                wire:loading.attr="disabled"
                                                class="bg-blue-600 text-white px-3 py-1 rounded text-xs font-bold hover:bg-blue-700 transition">
                                            Ambil
                                        </button>
                                    @else
                                        <span class="text-gray-400 text-xs italic">KRS Terkunci</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Tidak ada mata kuliah yang ditawarkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            <h3 class="text-xl font-semibold mb-2 text-gray-700">Keranjang KRS Saya</h3>
            <div class="bg-white shadow-md rounded-lg overflow-hidden overflow-x-auto border-2 border-blue-50">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mata Kuliah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jadwal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($krsDetails as $detail)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $detail->mataKuliah->nama_mk }}</div>
                                    <div class="text-sm font-bold text-blue-600">{{ $detail->sks }} SKS</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <div>{{ $detail->kelas->hari ?? '-' }}, {{ $detail->kelas->jam_mulai ? \Carbon\Carbon::parse($detail->kelas->jam_mulai)->format('H:i') : '' }}-{{ $detail->kelas->jam_selesai ? \Carbon\Carbon::parse($detail->kelas->jam_selesai)->format('H:i') : '' }}</div>
                                    <div class="text-xs text-gray-500">{{ $detail->kelas->dosen?->nama_lengkap ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if($krsHeader->status == 'Draft')
                                        <button wire:click="hapusKelas({{ $detail->id }})"
                                                wire:loading.attr="disabled"
                                                class="bg-red-50 text-red-600 border border-red-200 px-3 py-1 rounded text-xs font-bold hover:bg-red-100 transition">
                                            Hapus
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-sm text-gray-500 italic">
                                    Keranjang KRS masih kosong.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-end">
                @if($krsHeader->status == 'Draft' && $totalSks > 0)
                    <div class="flex flex-col items-end gap-2">
                        <span class="text-xs text-gray-500">Pastikan mata kuliah sudah benar sebelum mengajukan.</span>
                        <button 
                            wire:click="ajukanKrs"
                            wire:confirm="Yakin ajukan KRS? Anda tidak bisa mengubahnya lagi setelah ini."
                            class="bg-green-600 text-white px-6 py-3 rounded-lg font-bold shadow-lg hover:bg-green-700 transition flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Ajukan KRS ke Dosen Wali
                        </button>
                    </div>
                @elseif($krsHeader->status == 'Pending')
                    <div class="w-full bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Menunggu Persetujuan!</strong>
                        <span class="block sm:inline">KRS Anda sedang diperiksa oleh Dosen Wali.</span>
                    </div>
                @elseif($krsHeader->status == 'Approved')
                    <div class="w-full bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">KRS Disetujui!</strong>
                        <span class="block sm:inline">Selamat, KRS Anda sudah divalidasi. Silakan cetak Kartu Studi.</span>
                    </div>
                @endif
            </div>

        </div>

    </div>
</div>