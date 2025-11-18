<div>
    <x-slot:header>
        Manajemen Program Studi
    </x-slot:header>

    <div class="mb-4">
        <button wire:click="openModal" class="bg-unmaris-yellow text-unmaris-blue font-bold py-2 px-4 rounded hover:bg-yellow-400">
            + Tambah Program Studi
        </button>
    </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Program Studi</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fakultas</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenjang</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Akreditasi</th>
                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($prodis as $prodi)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $prodi->kode_prodi }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $prodi->nama_prodi }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                        {{ $prodi->fakultas?->nama_fakultas ?? '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $prodi->jenjang }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            {{ $prodi->akreditasi ?? 'N/A' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button wire:click="openEditModal({{ $prodi->id }})" class="text-indigo-600 hover:text-indigo-900">
                            Edit
                        </button>
                        <button wire:click="openDeleteModal({{ $prodi->id }})" class="text-red-600 hover:text-red-900 ml-4">
                            Hapus
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                        Belum ada data program studi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div x-data="{ show: @entangle('showDeleteModal') }" x-show="show" x-on:keydown.escape.window="show = false" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" x-cloak>

        <div @click="show = false" class="absolute inset-0"></div>

        <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow-lg" @click.stop>

            <h3 class="text-2xl font-semibold text-unmaris-blue">Konfirmasi Hapus</h3>

            <div class="mt-4">
                <p class="text-gray-600">
                    Anda yakin ingin menghapus program studi: <br>
                    <span class="font-bold">{{ $deletingProdi?->nama_prodi ?? '...' }}</span> ?
                </p>
                <p class="mt-2 text-sm text-gray-500">
                    Tindakan ini tidak dapat dibatalkan.
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
    <div x-data="{ show: @entangle('showModal') }" x-show="show" x-on:keydown.escape.window="show = false" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" x-cloak>

        <div @click="show = false" class="absolute inset-0"></div>

        <div class="relative w-full max-w-lg p-6 bg-white rounded-lg shadow-lg" @click.stop>

            <form wire:submit="save">
                <h3 class="text-2xl font-semibold text-unmaris-blue">
                    {{ $isEditing ? 'Edit Program Studi' : 'Tambah Prodi Baru' }}
                </h3>

                <div class="mt-4 space-y-4">

                    <div>
                        <label for="fakultas_id" class="block text-sm font-medium text-gray-700">Fakultas</label>
                        <select wire:model="fakultas_id" id="fakultas_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">-- Pilih Fakultas --</option>

                            @foreach ($fakultas as $fak)
                            <option value="{{ $fak->id }}">{{ $fak->nama_fakultas }}</option>
                            @endforeach
                        </select>
                        @error('fakultas_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="kode_prodi" class="block text-sm font-medium text-gray-700">Kode Prodi</label>
                        <input type="text" wire:model="kode_prodi" id="kode_prodi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('kode_prodi') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="nama_prodi" class="block text-sm font-medium text-gray-700">Nama Program Studi</label>
                        <input type="text" wire:model="nama_prodi" id="nama_prodi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('nama_prodi') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="jenjang" class="block text-sm font-medium text-gray-700">Jenjang</label>
                        <select wire:model="jenjang" id="jenjang" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="D3">D3</option>
                            <option value="S1">S1</option>
                            <option value="S2">S2</option>
                            <option value="S3">S3</option>
                        </select>
                        @error('jenjang') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="akreditasi" class="block text-sm font-medium text-gray-700">Akreditasi (Opsional)</label>
                        <input type="text" wire:model="akreditasi" id="akreditasi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('akreditasi') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
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
</div>
