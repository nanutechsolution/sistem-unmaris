<div>
    <x-slot:header>
        Manajemen Fakultas
    </x-slot:header>

    <div class="mb-4">
        <button wire:click="openCreateModal" class="bg-unmaris-yellow text-unmaris-blue font-bold py-2 px-4 rounded hover:bg-yellow-400">
            + Tambah Fakultas
        </button>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Fakultas</th>
                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($fakultas as $fak)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $fak->kode_fakultas }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $fak->nama_fakultas }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button wire:click="openEditModal({{ $fak->id }})" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                        <button wire:click="openDeleteModal({{ $fak->id }})" class="text-red-600 hover:text-red-900 ml-4">Hapus</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
                        Belum ada data fakultas.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div x-data="{ show: @entangle('showModal') }" x-show="show" x-on:keydown.escape.window="show = false" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" x-cloak>
        <div @click="show = false" class="absolute inset-0"></div>
        <div class="relative w-full max-w-lg p-6 bg-white rounded-lg shadow-lg" @click.stop>
            <form wire:submit="save">
                <h3 class="text-2xl font-semibold text-unmaris-blue">
                    {{ $isEditing ? 'Edit Fakultas' : 'Tambah Fakultas Baru' }}
                </h3>

                <div class="mt-4 space-y-4">
                    <div>
                        <label for="kode_fakultas" class="block text-sm font-medium text-gray-700">Kode Fakultas</label>
                        <input type="text" wire:model="kode_fakultas" id="kode_fakultas" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('kode_fakultas') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="nama_fakultas" class="block text-sm font-medium text-gray-700">Nama Fakultas</label>
                        <input type="text" wire:model="nama_fakultas" id="nama_fakultas" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('nama_fakultas') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-4">
                    <button type="button" wire:click="closeModal" class="bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded hover:bg-gray-300">
                        Batal
                    </button>
                    <button type="submit" class="bg-unmaris-blue text-white font-bold py-2 px-4 rounded hover:bg-unmaris-blue/80">
                        <span wire:loading.remove wire:target="save">Simpan</span>
                        <span wire:loading wire:target="save">Menyimpan...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div x-data="{ show: @entangle('showDeleteModal') }" x-show="show" x-on:keydown.escape.window="show = false" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" x-cloak>
        <div @click="show = false" class="absolute inset-0"></div>
        <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow-lg" @click.stop>
            <h3 class="text-2xl font-semibold text-unmaris-blue">Konfirmasi Hapus</h3>
            <div class="mt-4">
                <p class="text-gray-600">
                    Anda yakin ingin menghapus fakultas: <br>
                    <span class="font-bold">{{ $deletingFakultas?->nama_fakultas ?? '...' }}</span> ?
                </p>
            </div>
            <div class="mt-6 flex justify-end space-x-4">
                <button type="button" wire:click="closeDeleteModal" class="bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded hover:bg-gray-300">
                    Batal
                </button>
                <button type="button" wire:click="delete" class="bg-red-600 text-white font-bold py-2 px-4 rounded hover:bg-red-700">
                    <span wire:loading.remove wire:target="delete">Ya, Hapus</span>
                    <span wire:loading wire:target="delete">Menghapus...</span>
                </button>
            </div>
        </div>
    </div>
</div>
