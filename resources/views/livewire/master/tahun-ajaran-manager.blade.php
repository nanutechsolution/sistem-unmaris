<div>
    <x-slot:header>
        Master Tahun Ajaran
    </x-slot:header>

    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="flex justify-between items-center mb-4">
        <button wire:click="create" class="bg-unmaris-blue text-white font-bold py-2 px-4 rounded hover:bg-blue-800 shadow-md">
            + Tahun Ajaran Baru
        </button>

        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari Kode/Nama..." class="border-gray-300 rounded-md shadow-sm w-1/3">
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Kode</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Nama Semester</th>
                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase">Status Aktif</th>
                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($tahun_ajarans as $ta)
                <tr class="hover:bg-gray-50 {{ $ta->is_aktif ? 'bg-green-50' : '' }}">
                    <td class="px-6 py-4 whitespace-nowrap font-mono font-bold text-unmaris-blue">
                        {{ $ta->kode }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-700 font-medium">
                        {{ $ta->nama }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        @if($ta->is_aktif)
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 border border-green-200">
                                <i class="fas fa-check-circle mr-1 mt-0.5"></i> AKTIF
                            </span>
                        @else
                            <button wire:click="toggleActive({{ $ta->id }})" class="text-gray-400 hover:text-green-600 text-xs font-bold border border-gray-300 px-2 py-1 rounded hover:bg-gray-50 transition" title="Klik untuk aktifkan">
                                Aktifkan?
                            </button>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                        <button wire:click="edit({{ $ta->id }})" class="text-indigo-600 hover:text-indigo-900 font-bold">Edit</button>
                        <button wire:click="confirmDelete({{ $ta->id }})" class="text-red-600 hover:text-red-900 font-bold">Hapus</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada data Tahun Ajaran.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $tahun_ajarans->links() }}</div>

    @if($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" x-data @click.self="$wire.set('showModal', false)">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">
                {{ $isEditing ? 'Edit Tahun Ajaran' : 'Tambah Tahun Ajaran' }}
            </h3>
            
            <form wire:submit="save" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Kode (5 Digit)</label>
                    <input type="text" wire:model="kode" placeholder="Contoh: 20252" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-blue focus:border-unmaris-blue" maxlength="5">
                    <p class="text-[10px] text-gray-500 mt-1">Format: [Tahun][1=Ganjil/2=Genap]. Cth: 20251</p>
                    @error('kode') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Semester</label>
                    <input type="text" wire:model="nama" placeholder="Contoh: Genap 2025/2026" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-blue focus:border-unmaris-blue">
                    @error('nama') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center pt-2">
                    <input type="checkbox" wire:model="is_aktif" id="is_aktif" class="rounded text-unmaris-blue focus:ring-unmaris-blue h-5 w-5">
                    <label for="is_aktif" class="ml-2 text-sm font-bold text-gray-700">Set sebagai Semester Aktif</label>
                </div>
                <p class="text-xs text-yellow-600 bg-yellow-50 p-2 rounded border border-yellow-200">
                    <i class="fas fa-exclamation-triangle mr-1"></i> Mengaktifkan semester ini akan otomatis menonaktifkan semester lainnya.
                </p>

                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" wire:click="$set('showModal', false)" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md font-bold hover:bg-gray-300">Batal</button>
                    <button type="submit" class="bg-unmaris-blue text-white px-4 py-2 rounded-md font-bold hover:bg-blue-800">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    @if($showDeleteModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-sm p-6 text-center">
            <h3 class="text-lg font-bold text-red-600 mb-2">Hapus Data?</h3>
            <p class="text-sm text-gray-600 mb-6">Data yang dihapus tidak dapat dikembalikan.</p>
            <div class="flex justify-center space-x-3">
                <button wire:click="$set('showDeleteModal', false)" class="bg-gray-200 px-4 py-2 rounded font-bold text-sm">Batal</button>
                <button wire:click="delete" class="bg-red-600 text-white px-4 py-2 rounded font-bold text-sm hover:bg-red-700">Ya, Hapus</button>
            </div>
        </div>
    </div>
    @endif
</div>