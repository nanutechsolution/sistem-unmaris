<div>
    <x-slot:header>
        Validasi KRS (TA. {{ $activeTahunAkademik->nama_tahun }})
    </x-slot:header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-1">
            <div class="bg-white shadow-md rounded-lg">
                <div class="p-4 space-y-2 border-b">
                    <select wire:model.live="filterStatus" class="border-gray-300 rounded-md shadow-sm w-full">
                        <option value="Draft">Draft</option>
                        <option value="Submitted">Diajukan (Submitted)</option>
                        <option value="Approved">Disetujui (Approved)</option>
                        <option value="Rejected">Ditolak (Rejected)</option>
                    </select>

                    <select wire:model.live="filterProdi" class="border-gray-300 rounded-md shadow-sm w-full">
                        <option value="">Semua Program Studi</option>
                        @foreach ($programStudis as $prodi)
                            <option value="{{ $prodi->id }}">{{ $prodi->nama_prodi }}</option>
                        @endforeach
                    </select>

                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari NIM atau Nama..."
                        class="border-gray-300 rounded-md shadow-sm w-full">
                </div>

                <div class="max-h-[60vh] overflow-y-auto">
                    @forelse ($krsList as $krs)
                        <div wire:click="selectKrs({{ $krs->id }})"
                            class="p-4 border-b cursor-pointer hover:bg-gray-50
                                    {{ $selectedKrs && $selectedKrs->id == $krs->id ? 'bg-unmaris-yellow/20' : '' }}">
                            <div class="flex justify-between">
                                <span class="font-semibold text-unmaris-blue">{{ $krs->mahasiswa->nama_lengkap }}</span>
                                <span class="text-sm font-medium">{{ $krs->total_sks }} SKS</span>
                            </div>
                            <div class="text-sm text-gray-600">
                                {{ $krs->mahasiswa->nim }} | {{ $krs->mahasiswa->programStudi->nama_prodi }}
                            </div>
                        </div>
                    @empty
                        <div class="p-4 text-center text-gray-500">
                            Tidak ada data KRS ditemukan.
                        </div>
                    @endforelse
                </div>

                <div class="p-4 border-t">
                    {{ $krsList->links() }}
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            @if ($selectedKrs)
                <div class="bg-white shadow-md rounded-lg">
                    <div class="p-6 border-b">
                        <h3 class="text-xl font-semibold text-unmaris-blue">{{ $selectedKrs->mahasiswa->nama_lengkap }}
                        </h3>
                        <p class="text-gray-700">{{ $selectedKrs->mahasiswa->nim }} |
                            {{ $selectedKrs->mahasiswa->programStudi->nama_prodi }}</p>
                        <div class="mt-2">
                            <span class="text-lg font-bold">Total SKS: {{ $selectedKrs->total_sks }}</span>
                            <span
                                class="ml-4 px-3 py-1 rounded-full text-sm font-medium
                                @if ($selectedKrs->status == 'Approved') bg-green-100 text-green-800 @endif
                                @if ($selectedKrs->status == 'Submitted') bg-yellow-100 text-yellow-800 @endif
                                @if ($selectedKrs->status == 'Rejected') bg-red-100 text-red-800 @endif
                                @if ($selectedKrs->status == 'Draft') bg-gray-100 text-gray-800 @endif
                            ">
                                Status: {{ $selectedKrs->status }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6">
                        <h4 class="text-lg font-semibold mb-2">Daftar Mata Kuliah</h4>
                        <div class="max-h-[45vh] overflow-y-auto overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Mata
                                            Kuliah</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                            Dosen & Jadwal</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">SKS
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($krsDetails as $detail)
                                        <tr>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $detail->mataKuliah->nama_mk }}</div>
                                                <div class="text-sm text-gray-500">{{ $detail->mataKuliah->kode_mk }} |
                                                    Kelas {{ $detail->kelas->nama_kelas }}</div>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">
                                                <div>{{ $detail->kelas->dosen?->nama_lengkap ?? 'N/A' }}</div>
                                                <div>{{ $detail->kelas->hari ?? '-' }},
                                                    {{ $detail->kelas->jam_mulai ? $detail->kelas->jam_mulai->format('H:i') : '' }}-{{ $detail->kelas->jam_selesai ? $detail->kelas->jam_selesai->format('H:i') : '' }}
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                                {{ $detail->sks }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if ($selectedKrs->status == 'Submitted')
                        <div class="p-6 border-t bg-gray-50 flex justify-end space-x-3">
                            <button wire:click="returnToDraft"
                                class="bg-yellow-500 text-white font-bold py-2 px-4 rounded hover:bg-yellow-600">
                                Kembalikan ke Draft
                            </button>
                            <button wire:click="rejectKrs"
                                class="bg-red-600 text-white font-bold py-2 px-4 rounded hover:bg-red-700">
                                Tolak
                            </button>
                            <button wire:click="approveKrs"
                                class="bg-green-600 text-white font-bold py-2 px-4 rounded hover:bg-green-700">
                                Setujui
                            </button>
                        </div>
                    @endif

                    @if (in_array($selectedKrs->status, ['Approved', 'Rejected']))
                        <div class="p-6 border-t bg-gray-50 flex justify-end space-x-3">
                            <button wire:click="returnToDraft"
                                class="bg-gray-500 text-white font-bold py-2 px-4 rounded hover:bg-gray-600">
                                Batalkan Validasi (Kembalikan ke Draft)
                            </button>
                        </div>
                    @endif

                </div>
            @else
                <div class="bg-white shadow-md rounded-lg p-12 text-center">
                    <p class="text-gray-500">Pilih mahasiswa dari daftar di samping untuk melihat detail KRS.</p>
                </div>
            @endif
        </div>

    </div>
</div>
