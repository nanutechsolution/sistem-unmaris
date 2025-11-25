<div>
    <x-slot:header>
        Riwayat Ketua Program Studi
    </x-slot:header>

    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    {{-- FILTER & TOMBOL --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <button wire:click="create"
            class="bg-unmaris-yellow text-unmaris-blue font-bold py-2 px-4 rounded hover:bg-yellow-400 w-full md:w-auto shadow-sm">
            + Lantik Kaprodi Baru
        </button>

        <div class="flex w-full md:w-auto gap-2">
            <select wire:model.live="filterProdi"
                class="border-gray-300 rounded-md shadow-sm focus:ring-unmaris-blue text-sm w-full md:w-48">
                <option value="">Semua Prodi</option>
                @foreach ($listProdi as $p)
                    <option value="{{ $p->id }}">{{ $p->nama_prodi }}</option>
                @endforeach
            </select>

            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari Nama Dosen..."
                class="border-gray-300 rounded-md shadow-sm text-sm w-full md:w-64">
        </div>
    </div>

    {{-- TABEL DATA --}}
    <div class="bg-white shadow-md rounded-lg overflow-hidden overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Program Studi</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Nama Pejabat</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Periode Menjabat</th>
                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($history as $item)
                    <tr class="hover:bg-gray-50 {{ is_null($item->selesai) ? 'bg-yellow-50/50' : '' }}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-unmaris-blue">
                            {{ $item->programStudi->nama_prodi }}
                            <span
                                class="text-gray-400 text-xs font-normal block">{{ $item->programStudi->jenjang }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8 bg-gray-200 rounded-full overflow-hidden mr-3">
                                    @if ($item->dosen->foto_profil)
                                        <img src="{{ asset('storage/' . $item->dosen->foto_profil) }}"
                                            class="h-full w-full object-cover">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($item->dosen->nama_lengkap) }}&background=0D8ABC&color=fff"
                                            class="h-full w-full object-cover">
                                    @endif
                                </div>
                                <div class="text-sm font-bold text-gray-900">{{ $item->dosen->nama_lengkap }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            <div><span class="font-bold text-green-600">Mulai:</span>
                                {{ $item->mulai->format('d M Y') }}</div>
                            @if ($item->selesai)
                                <div><span class="font-bold text-red-600">Selesai:</span>
                                    {{ $item->selesai->format('d M Y') }}</div>
                            @else
                                <div class="text-xs text-gray-400 italic mt-1">Sampai Sekarang</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if (is_null($item->selesai))
                                <span
                                    class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800 border border-green-200 animate-pulse">
                                    MENJABAT
                                </span>
                            @else
                                <span
                                    class="px-3 py-1 text-xs font-bold rounded-full bg-gray-100 text-gray-500 border border-gray-200">
                                    SELESAI
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm space-x-2">
                            <button wire:click="edit({{ $item->id }})"
                                class="text-indigo-600 hover:text-indigo-900 font-bold">Edit</button>
                            <button wire:click="confirmDelete({{ $item->id }})"
                                class="text-red-600 hover:text-red-900 font-bold">Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada data riwayat Kaprodi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $history->links() }}</div>

    {{-- MODAL FORM --}}
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" x-data
            @click.self="$wire.set('showModal', false)">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-lg">
                <div class="px-6 py-4 border-b bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-800">
                        {{ $isEditing ? 'Edit Data Jabatan' : 'Lantik Kaprodi Baru' }}
                    </h3>
                </div>

                <form wire:submit="save" class="p-6 space-y-4">

                    <div>
                        <label class="block text-sm font-bold text-gray-700">Program Studi</label>
                        <select wire:model="program_studi_id"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-blue">
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
                        <label class="block text-sm font-bold text-gray-700">Dosen Pejabat</label>
                        <select wire:model="dosen_id"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-blue">
                            <option value="">-- Pilih Dosen --</option>
                            @foreach ($listDosen as $d)
                                <option value="{{ $d->id }}">{{ $d->nama_lengkap }}</option>
                            @endforeach
                        </select>
                        @error('dosen_id')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Tanggal Mulai</label>
                            <input type="date" wire:model="mulai"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('mulai')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Tanggal Selesai</label>
                            <input type="date" wire:model="selesai"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <p class="text-[10px] text-gray-500 mt-1">*Kosongkan jika masih menjabat.</p>
                            @error('selesai')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t mt-4">
                        <button type="button" wire:click="$set('showModal', false)"
                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md font-bold hover:bg-gray-300">Batal</button>
                        <button type="submit"
                            class="bg-unmaris-blue text-white px-4 py-2 rounded-md font-bold hover:bg-blue-800">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- MODAL DELETE --}}
    @if ($showDeleteModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-sm p-6 text-center">
                <h3 class="text-lg font-bold text-red-600 mb-2">Hapus Data Jabatan?</h3>
                <p class="text-sm text-gray-600 mb-6">Data ini akan dihapus dari riwayat.</p>
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
</div>
