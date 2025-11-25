<div>
    <x-slot:header>
        Distribusi & Penugasan Dosen
    </x-slot:header>

    @if (session()->has('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div
        class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 mb-6 flex flex-col md:flex-row gap-4 justify-between items-end">
        <div class="flex gap-4 w-full md:w-auto">
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Tahun Ajaran</label>
                <select wire:model.live="filterTahun"
                    class="border-gray-300 rounded-md shadow-sm focus:ring-unmaris-blue focus:border-unmaris-blue text-sm">
                    @foreach ($listTahun as $ta)
                        <option value="{{ $ta->id }}">
                            {{ $ta->kode_tahun }} - {{ $ta->nama_tahun }}
                            {{ $ta->status == 'Aktif' ? '(Aktif)' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Filter Prodi</label>
                <select wire:model.live="filterProdi"
                    class="border-gray-300 rounded-md shadow-sm focus:ring-unmaris-blue focus:border-unmaris-blue text-sm w-48">
                    <option value="">Semua Prodi</option>
                    @foreach ($listProdi as $p)
                        <option value="{{ $p->id }}">{{ $p->nama_prodi }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex gap-2 w-full md:w-auto">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari Nama Dosen..."
                class="border-gray-300 rounded-md shadow-sm text-sm w-full">

            {{-- TOMBOL BARU: COPY DATA --}}
            <button wire:click="openCopyModal"
                class="bg-indigo-600 text-white px-4 py-2 rounded-md font-bold text-sm whitespace-nowrap hover:bg-indigo-700 shadow-md flex items-center gap-2"
                title="Salin data dari semester sebelumnya">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2">
                    </path>
                </svg>
                Salin Data
            </button>

            <button wire:click="openCreateModal"
                class="bg-unmaris-blue text-white px-4 py-2 rounded-md font-bold text-sm whitespace-nowrap hover:bg-blue-800 shadow-md">
                + Penugasan Baru
            </button>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Dosen</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Homebase
                        (Asal)</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Ditugaskan
                        Di (Tujuan)</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($penugasans as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div
                                    class="flex-shrink-0 h-8 w-8 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 font-bold text-xs">
                                    {{ substr($item->dosen->nama_lengkap ?? 'X', 0, 1) }}
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $item->dosen->nama_lengkap ?? '-' }}</div>
                                    <div class="text-xs text-gray-500">NIDN: {{ $item->dosen->nidn ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $item->dosen->programStudi->nama_prodi ?? 'Belum Set' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-unmaris-blue">
                            {{ $item->programStudi->nama_prodi ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $badgeColor = match ($item->status_penugasan) {
                                    'Tetap' => 'bg-green-100 text-green-800',
                                    'LB' => 'bg-yellow-100 text-yellow-800',
                                    'Tamu' => 'bg-purple-100 text-purple-800',
                                    default => 'bg-gray-100 text-gray-800',
                                };
                            @endphp
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeColor }}">
                                Dosen {{ $item->status_penugasan }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                            <button wire:click="openEditModal({{ $item->id }})"
                                class="text-blue-600 hover:text-blue-900">Edit</button>
                            <button wire:click="confirmDelete({{ $item->id }})"
                                class="text-red-600 hover:text-red-900">Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            <p>Belum ada data penugasan di Tahun Ajaran ini.</p>
                            <p class="text-xs mt-1">Silakan tambah manual atau salin dari semester lalu.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $penugasans->links() }}</div>

    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" x-data
            @click.self="$wire.set('showModal', false)">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-lg overflow-hidden">
                <div class="px-6 py-4 border-b bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-800">
                        {{ $isEditing ? 'Edit Penugasan' : 'Tambah Penugasan Baru' }}
                    </h3>
                </div>

                <form wire:submit="save" class="p-6 space-y-4">

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tahun Ajaran</label>
                        <select wire:model="tahun_ajaran_id"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100" disabled>
                            @foreach ($listTahun as $t)
                                <option value="{{ $t->id }}">{{ $t->nama }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">*Otomatis mengikuti filter yang dipilih.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Pilih Dosen</label>
                        <select wire:model="dosen_id"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-blue focus:border-unmaris-blue">
                            <option value="">-- Pilih Dosen --</option>
                            @foreach ($listDosen as $d)
                                <option value="{{ $d->id }}">{{ $d->nama_lengkap }} ({{ $d->nidn }})
                                </option>
                            @endforeach
                        </select>
                        @error('dosen_id')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Ditugaskan di Prodi (Tujuan)</label>
                        <select wire:model="program_studi_id"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-blue focus:border-unmaris-blue">
                            <option value="">-- Pilih Prodi --</option>
                            @foreach ($listProdi as $p)
                                <option value="{{ $p->id }}">{{ $p->nama_prodi }} ({{ $p->jenjang }})
                                </option>
                            @endforeach
                        </select>
                        @error('program_studi_id')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status Penugasan</label>
                        <div class="mt-2 space-x-4">
                            <label class="inline-flex items-center">
                                <input type="radio" wire:model="status_penugasan" value="Tetap"
                                    class="text-unmaris-blue focus:ring-unmaris-blue">
                                <span class="ml-2 text-sm">Dosen Tetap (Homebase)</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" wire:model="status_penugasan" value="LB"
                                    class="text-unmaris-blue focus:ring-unmaris-blue">
                                <span class="ml-2 text-sm">Dosen LB (Luar Biasa)</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" wire:model="status_penugasan" value="Tamu"
                                    class="text-unmaris-blue focus:ring-unmaris-blue">
                                <span class="ml-2 text-sm">Dosen Tamu</span>
                            </label>
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end space-x-3">
                        <button type="button" wire:click="$set('showModal', false)"
                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md font-bold hover:bg-gray-300">Batal</button>
                        <button type="submit"
                            class="bg-unmaris-blue text-white px-4 py-2 rounded-md font-bold hover:bg-blue-800">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @if ($showDeleteModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-sm p-6 text-center">
                <h3 class="text-lg font-bold text-gray-800 mb-2">Hapus Penugasan?</h3>
                <p class="text-sm text-gray-500 mb-6">Data ini akan dihapus dari Tahun Ajaran ini.</p>
                <div class="flex justify-center space-x-3">
                    <button wire:click="$set('showDeleteModal', false)"
                        class="bg-gray-200 px-4 py-2 rounded font-bold text-sm">Batal</button>
                    <button wire:click="delete"
                        class="bg-red-600 text-white px-4 py-2 rounded font-bold text-sm hover:bg-red-700">Ya,
                        Hapus</button>
                </div>
            </div>
        </div>
    @endif

    @if ($showCopyModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" x-data
            @click.self="$wire.set('showCopyModal', false)">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
                <div class="flex items-center gap-3 mb-4 text-indigo-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2">
                        </path>
                    </svg>
                    <h3 class="text-lg font-bold text-gray-800">Salin Penugasan Dosen</h3>
                </div>

                <p class="text-sm text-gray-600 mb-4">
                    Fitur ini akan menyalin semua data penugasan dosen dari semester yang dipilih ke semester target
                    yang sedang aktif
                    (<span class="font-bold text-gray-800">
                        {{ $listTahun->where('id', $filterTahun)->first()->nama ?? '...' }}
                    </span>).
                </p>

                <div class="mb-4">
                    <label class="block text-sm font-bold text-gray-700 mb-1">Salin Dari Semester:</label>
                    <select wire:model="sumberTahun"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">-- Pilih Sumber Data --</option>
                        @foreach ($listTahun as $t)
                            {{-- Jangan tampilkan semester target di pilihan sumber --}}
                            @if ($t->id != $filterTahun)
                                <option value="{{ $t->id }}">{{ $t->kode_tahun }} - {{ $t->nama_tahun }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                    @error('sumberTahun')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <button wire:click="$set('showCopyModal', false)"
                        class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md font-bold hover:bg-gray-300">Batal</button>
                    <button wire:click="copySemester"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-md font-bold hover:bg-indigo-700 flex items-center gap-2">
                        <span wire:loading.remove wire:target="copySemester">Proses Salin</span>
                        <span wire:loading wire:target="copySemester">Memproses...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
