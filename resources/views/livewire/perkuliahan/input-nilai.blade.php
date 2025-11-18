<div>
    <x-slot:header>
        Input Nilai (TA. {{ $activeTahunAkademik?->nama_tahun }})
    </x-slot:header>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg">

        @if ($selectedKelas)
            <div class="p-6 border-b flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-semibold text-unmaris-blue">{{ $selectedKelas->mataKuliah->nama_mk }} (Kelas {{ $selectedKelas->nama_kelas }})</h3>
                    <p class="text-gray-600">{{ $selectedKelas->mataKuliah->programStudi->nama_prodi }} | {{ $selectedKelas->mataKuliah->sks }} SKS</p>
                </div>
                <button wire:click="backToList" class="bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded hover:bg-gray-300">
                    &larr; Kembali ke Daftar Kelas
                </button>
            </div>

            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIM</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Mahasiswa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase w-24">Nilai Huruf</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase w-24">Nilai Angka</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($mahasiswaDiKelas as $index => $mahasiswa)
                                <tr>
                                    <td class="px-6 py-4">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4">{{ $mahasiswa->krs->mahasiswa->nim }}</td>
                                    <td class="px-6 py-4 font-medium">{{ $mahasiswa->krs->mahasiswa->nama_lengkap }}</td>
                                    <td class="px-6 py-4">
                                        <input type="text"
                                               wire:model.defer="nilai.{{ $mahasiswa->id }}.huruf"
                                               class="border-gray-300 rounded-md shadow-sm w-full">
                                    </td>
                                    <td class="px-6 py-4">
                                        <input type="text"
                                               wire:model.defer="nilai.{{ $mahasiswa->id }}.angka"
                                               class="border-gray-300 rounded-md shadow-sm w-full">
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                        Belum ada mahasiswa yang mengambil kelas ini atau KRS belum disetujui.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if (count($mahasiswaDiKelas) > 0)
                    <div class="mt-6 text-right">
                        <button wire:click="saveNilai" class="bg-unmaris-blue text-white font-bold py-2 px-4 rounded hover:bg-unmaris-blue/80">
                            <span wire:loading.remove wire:target="saveNilai">Simpan Semua Nilai</span>
                            <span wire:loading wire:target="saveNilai">Menyimpan...</span>
                        </button>
                    </div>
                @endif
            </div>

        @else
            <div class="p-6 border-b">
                <h3 class="text-xl font-semibold text-unmaris-blue">Kelas yang Anda Ampu</h3>
                <p class="text-gray-600">Pilih kelas untuk menginput nilai.</p>
            </div>

            <div class="max-h-[70vh] overflow-y-auto">
                @forelse ($kelasList as $kelas)
                    <div wire:click="selectKelas({{ $kelas->id }})"
                         class="p-4 border-b cursor-pointer hover:bg-gray-50">
                        <div class="flex justify-between">
                            <span class="font-semibold text-unmaris-blue">{{ $kelas->mataKuliah->nama_mk }} (Kelas {{ $kelas->nama_kelas }})</span>
                            <span class="text-sm text-gray-500">{{ $kelas->hari ?? '-' }}, {{ $kelas->jam_mulai ? $kelas->jam_mulai->format('H:i') : '' }}</span>
                        </div>
                        <div class="text-sm text-gray-600">
                            {{ $kelas->mataKuliah->programStudi->nama_prodi }} | {{ $kelas->mataKuliah->sks }} SKS
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-center text-gray-500">
                        Anda tidak mengampu kelas apapun di tahun akademik aktif saat ini.
                    </div>
                @endforelse
            </div>
        @endif

    </div>
</div>
