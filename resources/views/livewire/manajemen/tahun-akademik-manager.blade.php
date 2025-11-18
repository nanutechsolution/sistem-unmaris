<div>
    <x-slot:header>
        Manajemen Tahun Akademik
    </x-slot:header>

    <div class="flex justify-between items-center mb-4">
        <button wire:click="openCreateModal" class="bg-unmaris-yellow text-unmaris-blue font-bold py-2 px-4 rounded hover:bg-yellow-400">
            + Tambah Tahun Akademik
        </button>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tahun Akademik</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode KRS</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode Kuliah</th>
                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($tahunAkademiks as $ta)
                    <tr class="{{ $ta->status == 'Aktif' ? 'bg-green-50' : '' }}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $ta->nama_tahun }} ({{ $ta->kode_tahun }})
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $ta->status == 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $ta->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $ta->tgl_mulai_krs->format('d M Y') }} - {{ $ta->tgl_selesai_krs->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $ta->tgl_mulai_kuliah->format('d M Y') }} - {{ $ta->tgl_selesai_kuliah->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            @if ($ta->status == 'Tidak Aktif')
                                <button wire:click="setAktif({{ $ta->id }})" class="text-green-600 hover:text-green-900" title="Aktifkan">
                                    Aktifkan
                                </button>
                                <span class="mx-1 text-gray-300">|</span>
                            @endif
                            <button wire:click="openEditModal({{ $ta->id }})" class="text-indigo-600 hover:text-indigo-900">
                                Edit
                            </button>
                            </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                            Tidak ada data tahun akademik ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $tahunAkademiks->links() }}
    </div>

    <div x-data="{ show: @entangle('showModal') }" x-show="show" x-on:keydown.escape.window="show = false" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" x-cloak>
        <div @click="show = false" class="absolute inset-0"></div>
        <div class="relative w-full max-w-2xl p-6 bg-white rounded-lg shadow-lg" @click.stop>
            <form wire:submit="save">
                <h3 class="text-2xl font-semibold text-unmaris-blue">
                    {{ $isEditing ? 'Edit Tahun Akademik' : 'Tambah Tahun Akademik Baru' }}
                </h3>

                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="kode_tahun" class="block text-sm font-medium text-gray-700">Kode Tahun (e.g., 20241)</label>
                        <input type="text" wire:model="kode_tahun" id="kode_tahun" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('kode_tahun') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="nama_tahun" class="block text-sm font-medium text-gray-700">Nama Tahun (e.g., 2024/2025 Ganjil)</label>
                        <input type="text" wire:model="nama_tahun" id="nama_tahun" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('nama_tahun') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="semester" class="block text-sm font-medium text-gray-700">Semester</label>
                        <select wire:model="semester" id="semester" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="Ganjil">Ganjil</option>
                            <option value="Genap">Genap</option>
                        </select>
                        @error('semester') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <hr class="md:col-span-2">

                    <div>
                        <label for="tgl_mulai_krs" class="block text-sm font-medium text-gray-700">Mulai KRS</label>
                        <input type="date" wire:model="tgl_mulai_krs" id="tgl_mulai_krs" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('tgl_mulai_krs') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="tgl_selesai_krs" class="block text-sm font-medium text-gray-700">Selesai KRS</label>
                        <input type="date" wire:model="tgl_selesai_krs" id="tgl_selesai_krs" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('tgl_selesai_krs') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="tgl_mulai_kuliah" class="block text-sm font-medium text-gray-700">Mulai Kuliah</label>
                        <input type="date" wire:model="tgl_mulai_kuliah" id="tgl_mulai_kuliah" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('tgl_mulai_kuliah') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="tgl_selesai_kuliah" class="block text-sm font-medium text-gray-700">Selesai Kuliah</label>
                        <input type="date" wire:model="tgl_selesai_kuliah" id="tgl_selesai_kuliah" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('tgl_selesai_kuliah') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
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
