<div>
    <x-slot:header>Manajemen Kurikulum</x-slot:header>
    
    <!-- Notifikasi Error -->
    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Tombol Aksi & Filter -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-4">
        <button wire:click="openCreateModal" class="bg-unmaris-yellow text-unmaris-blue font-bold py-2 px-4 rounded hover:bg-yellow-400 w-full md:w-auto">
            + Tambah Kurikulum
        </button>
        
        <select wire:model.live="filterProdi" class="border-gray-300 rounded-md shadow-sm w-full md:w-1/3 focus:ring-unmaris-yellow focus:border-unmaris-yellow">
            <option value="">Semua Program Studi</option>
            @foreach($programStudis as $prodi)
                <option value="{{ $prodi->id }}">{{ $prodi->nama_prodi }}</option>
            @endforeach
        </select>
    </div>

    <!-- Tabel Data -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Program Studi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kurikulum</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tahun Mulai</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($kurikulums as $kur)
                    <tr class="{{ $kur->aktif ? 'bg-green-50' : '' }}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-medium">
                            {{ $kur->programStudi->nama_prodi }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $kur->nama_kurikulum }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $kur->tahun_mulai }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($kur->aktif)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Aktif
                                </span>
                            @else
                                <button wire:click="toggleActive({{ $kur->id }})" class="text-gray-400 hover:text-green-600 text-sm font-medium underline decoration-dotted">
                                    Set Aktif
                                </button>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button wire:click="openEditModal({{ $kur->id }})" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                            <button wire:click="openDeleteModal({{ $kur->id }})" class="text-red-600 hover:text-red-900 ml-4">Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                            Belum ada data kurikulum.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $kurikulums->links() }}
    </div>

    <!-- MODAL TAMBAH/EDIT -->
    <div x-data="{ show: @entangle('showModal') }" 
         x-show="show" 
         x-on:keydown.escape.window="show = false" 
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" 
         x-cloak>
        <div @click="show = false" class="absolute inset-0"></div>
        <div class="relative w-full max-w-lg p-6 bg-white rounded-lg shadow-lg" @click.stop>
            <form wire:submit="save">
                <h3 class="text-2xl font-semibold text-unmaris-blue">
                    {{ $isEditing ? 'Edit Kurikulum' : 'Tambah Kurikulum' }}
                </h3>
                
                <div class="mt-4 space-y-4">
                    <div>
                        <label for="program_studi_id" class="block text-sm font-medium text-gray-700">Program Studi</label>
                        <select wire:model="program_studi_id" id="program_studi_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                            <option value="">-- Pilih Prodi --</option>
                            @foreach($programStudis as $prodi)
                                <option value="{{ $prodi->id }}">{{ $prodi->nama_prodi }}</option>
                            @endforeach
                        </select>
                        @error('program_studi_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label for="nama_kurikulum" class="block text-sm font-medium text-gray-700">Nama Kurikulum</label>
                        <input type="text" wire:model="nama_kurikulum" id="nama_kurikulum" placeholder="Contoh: Kurikulum MBKM 2024" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                        @error('nama_kurikulum') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="tahun_mulai" class="block text-sm font-medium text-gray-700">Tahun Mulai Berlaku</label>
                        <input type="number" wire:model="tahun_mulai" id="tahun_mulai" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                        @error('tahun_mulai') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" wire:model="aktif" id="aktif" class="h-4 w-4 text-unmaris-blue border-gray-300 rounded focus:ring-unmaris-yellow">
                        <label for="aktif" class="ml-2 block text-sm text-gray-900">
                            Set sebagai Kurikulum Aktif (Default)
                        </label>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-4">
                    <button type="button" wire:click="closeModal" class="bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded hover:bg-gray-300">Batal</button>
                    <button type="submit" class="bg-unmaris-blue text-white font-bold py-2 px-4 rounded hover:bg-unmaris-blue/80">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL HAPUS -->
    <div x-data="{ show: @entangle('showDeleteModal') }" x-show="show" x-on:keydown.escape.window="show = false" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" x-cloak>
        <div @click="show = false" class="absolute inset-0"></div>
        <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow-lg" @click.stop>
            <h3 class="text-2xl font-semibold text-unmaris-blue">Konfirmasi Hapus</h3>
            <div class="mt-4">
                <p class="text-gray-600">
                    Anda yakin ingin menghapus kurikulum: <br>
                    <span class="font-bold">{{ $deletingKurikulum?->nama_kurikulum ?? '...' }}</span> ?
                </p>
                <p class="mt-2 text-sm text-red-500">
                    Pastikan tidak ada Mata Kuliah yang terhubung ke kurikulum ini.
                </p>
            </div>
            <div class="mt-6 flex justify-end space-x-4">
                <button type="button" wire:click="closeDeleteModal" class="bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded hover:bg-gray-300">Batal</button>
                <button type="button" wire:click="delete" class="bg-red-600 text-white font-bold py-2 px-4 rounded hover:bg-red-700">Ya, Hapus</button>
            </div>
        </div>
    </div>
</div>