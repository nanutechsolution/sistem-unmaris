<div>
    <x-slot:header>
        Pengisian KRS (TA. {{ $activeTahunAkademik->nama_tahun }})
    </x-slot:header>

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
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
            <h3 class="text-xl font-semibold mb-2 text-unmaris-blue">Mata Kuliah Ditawarkan (Prodi Anda)</h3>
            <div class="bg-white shadow-md rounded-lg overflow-hidden overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mata Kuliah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jadwal & Dosen</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($kelasList as $kelas)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div classt="text-sm font-medium text-gray-900">{{ $kelas->mataKuliah->nama_mk }}</div>
                                    <div class="text-sm text-gray-500">{{ $kelas->mataKuliah->sks }} SKS (Sm. {{ $kelas->mataKuliah->semester }})</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <div>{{ $kelas->dosen?->nama_lengkap ?? 'N/A' }}</div>
                                    <div>{{ $kelas->hari ?? '-' }}, {{ $kelas->jam_mulai ? $kelas->jam_mulai->format('H:i') : '' }}-{{ $kelas->jam_selesai ? $kelas->jam_selesai->format('H:i') : '' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button wire:click="ambilKelas({{ $kelas->id }})"
                                            wire:loading.attr="disabled"
                                            class="bg-unmaris-blue text-white px-3 py-1 rounded text-xs font-bold hover:bg-unmaris-blue/80">
                                        Ambil
                                    </button>
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
            <h3 class="text-xl font-semibold mb-2 text-gray-700">Mata Kuliah Diambil</h3>
            <div class="bg-white shadow-md rounded-lg overflow-hidden overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mata Kuliah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jadwal & Dosen</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($krsDetails as $detail)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $detail->mataKuliah->nama_mk }}</div>
                                    <div class="text-sm text-gray-500">{{ $detail->sks }} SKS</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <div>{{ $detail->kelas->dosen?->nama_lengkap ?? 'N/A' }}</div>
                                    <div>{{ $detail->kelas->hari ?? '-' }}, {{ $detail->kelas->jam_mulai ? $detail->kelas->jam_mulai->format('H:i') : '' }}-{{ $detail->kelas->jam_selesai ? $detail->kelas->jam_selesai->format('H:i') : '' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button wire:click="hapusKelas({{ $detail->id }})"
                                            wire:loading.attr="disabled"
                                            class="bg-red-600 text-white px-3 py-1 rounded text-xs font-bold hover:bg-red-700">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Belum ada mata kuliah yang diambil.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
