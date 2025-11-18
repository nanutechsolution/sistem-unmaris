<div>
    <x-slot:header>
        Kartu Hasil Studi (KHS)
    </x-slot:header>

    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <div class="text-sm text-gray-500">Mahasiswa</div>
                <div class="text-lg font-semibold text-unmaris-blue">{{ $mahasiswa->nama_lengkap }}</div>
                <div class="text-gray-700">{{ $mahasiswa->nim }}</div>
            </div>
            <div>
                <div class_ ="text-sm text-gray-500">Program Studi</div>
                <div class="text-lg font-semibold text-gray-900">{{ $mahasiswa->programStudi->nama_prodi }}</div>
                <div class_ ="text-gray-700">Angkatan {{ $mahasiswa->angkatan }}</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-1">
            <div class="bg-white shadow-md rounded-lg">
                <div class="p-4 border-b">
                    <h3 class="text-lg font-semibold text-unmaris-blue">Pilih Semester</h3>
                </div>
                <div class="max-h-[60vh] overflow-y-auto">
                    @forelse ($krsSemesterList as $krs)
                        <div wire:click="selectSemester({{ $krs->id }})"
                             class="p-4 border-b cursor-pointer hover:bg-gray-50
                                    {{ $selectedKrs && $selectedKrs->id == $krs->id ? 'bg-unmaris-yellow/20' : '' }}">
                            <div class="font-semibold text-gray-800">{{ $krs->tahunAkademik->nama_tahun }}</div>
                            <div class="text-sm text-gray-600">{{ $krs->total_sks }} SKS</div>
                        </div>
                    @empty
                        <div class="p-4 text-center text-gray-500">
                            Belum ada riwayat KRS yang disetujui.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class_ ="lg:col-span-2">
            @if ($selectedKrs)
                <div class="bg-white shadow-md rounded-lg">
                    <div class="p-6 border-b">
                        <h3 class="text-xl font-semibold text-unmaris-blue">
                            Hasil Studi: {{ $selectedKrs->tahunAkademik->nama_tahun }}
                        </h3>
                    </div>

                    <div class="p-6 grid grid-cols-2 gap-4 border-b bg-gray-50">
                        <div class="text-center">
                            <div class="text-sm text-gray-500">Indeks Prestasi Semester (IPS)</div>
                            <div class="text-3xl font-bold text-unmaris-blue">{{ $ips }}</div>
                            <div class="text-sm text-gray-500">{{ $totalSksSemester }} SKS</div>
                        </div>
                        <div class="text-center">
                            <div class="text-sm text-gray-500">Indeks Prestasi Kumulatif (IPK)</div>
                            <div class="text-3xl font-bold text-gray-700">{{ $ipk }}</div>
                            <div class_ ="text-sm text-gray-500">{{ $totalSksKumulatif }} SKS</div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode MK</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Mata Kuliah</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">SKS</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nilai Huruf</th>
                                    <th class_ ="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bobot</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($krsDetails as $detail)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $detail->mataKuliah->kode_mk }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $detail->mataKuliah->nama_mk }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $detail->sks }}</td>
                                        <td class_ ="px-6 py-4 whitespace-nowrap text-sm font-bold text-unmaris-blue">{{ $detail->nilai_huruf ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($detail->bobot, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="bg-white shadow-md rounded-lg p-12 text-center">
                    <p class="text-gray-500">Pilih semester dari daftar di samping untuk melihat Kartu Hasil Studi.</p>
                </div>
            @endif
        </div>

    </div>
</div>
