<div>
    <!-- Slot Header -->
    <x-slot:header>Manajemen Mata Kuliah</x-slot:header>

    <!-- Notifikasi Error -->
    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Tombol Aksi & Pencarian -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-4">
        <button wire:click="openCreateModal" class="bg-unmaris-yellow text-unmaris-blue font-bold py-2 px-4 rounded hover:bg-yellow-400 w-full md:w-auto">
            + Tambah Mata Kuliah
        </button>
        
        <div class="flex w-full md:w-auto gap-2">
            <select wire:model.live="filterProdi" class="border-gray-300 rounded-md shadow-sm w-full md:w-48 focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                <option value="">Semua Prodi</option>
                @foreach($programStudis as $prodi)
                    <option value="{{ $prodi->id }}">{{ $prodi->nama_prodi }}</option>
                @endforeach
            </select>

            <input 
                type="text" 
                wire:model.live.debounce.300ms="search" 
                placeholder="Cari Kode/Nama MK..." 
                class="border-gray-300 rounded-md shadow-sm w-full md:w-64 focus:ring-unmaris-yellow focus:border-unmaris-yellow">
        </div>
    </div>

    <!-- Tabel Data -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode & Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kurikulum</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sifat</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKS / Smt</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prasyarat</th>
                    <th class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($mataKuliahs as $mk)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $mk->nama_mk }}</div>
                            <div class="text-xs text-gray-500 font-mono">{{ $mk->kode_mk }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 font-medium">{{ $mk->kurikulum->nama_kurikulum ?? 'Tanpa Kurikulum' }}</div>
                            <div class="text-xs text-gray-500">{{ $mk->programStudi->nama_prodi }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $mk->sifat == 'Wajib' ? 'bg-blue-100 text-blue-800' : ($mk->sifat == 'MKDU' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ $mk->sifat }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $mk->sks }} SKS (Smt {{ $mk->semester }})
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700 max-w-xs whitespace-normal">
                            @if($mk->prasyarats->count() > 0)
                                <ul class="list-disc list-inside text-xs text-gray-600">
                                    @foreach($mk->prasyarats as $pra)
                                        <li>{{ $pra->nama_mk }} ({{ $pra->kode_mk }})</li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button wire:click="openEditModal({{ $mk->id }})" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                            <button wire:click="openDeleteModal({{ $mk->id }})" class="text-red-600 hover:text-red-900 ml-4">Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                            Tidak ada data mata kuliah.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $mataKuliahs->links() }}
    </div>

    <!-- MODAL TAMBAH/EDIT -->
    <div x-data="{ show: @entangle('showModal') }" 
         x-show="show" 
         x-on:keydown.escape.window="show = false" 
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" 
         x-cloak>
        <div @click="show = false" class="absolute inset-0"></div>
        <div class="relative w-full max-w-4xl p-6 bg-white rounded-lg shadow-lg" @click.stop>
            <form wire:submit="save">
                <h3 class="text-2xl font-semibold text-unmaris-blue">
                    {{ $isEditing ? 'Edit Mata Kuliah' : 'Tambah Mata Kuliah' }}
                </h3>
                
                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6 max-h-[75vh] overflow-y-auto pr-2">
                    
                    <!-- Kolom Kiri: Data Utama -->
                    <div class="space-y-4">
                        <!-- Pilih Prodi & Kurikulum Dulu (Penting untuk filter Prasyarat) -->
                        <div class="bg-gray-50 p-3 rounded border border-gray-200">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">1. Tentukan Kurikulum</label>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Program Studi</label>
                                    <select wire:model.live="program_studi_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                                        <option value="">-- Pilih Prodi --</option>
                                        @foreach($programStudis as $prodi)
                                            <option value="{{ $prodi->id }}">{{ $prodi->nama_prodi }}</option>
                                        @endforeach
                                    </select>
                                    @error('program_studi_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Kurikulum</label>
                                    <select wire:model.live="kurikulum_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow" {{ empty($kurikulums) ? 'disabled' : '' }}>
                                        <option value="">-- Pilih Kurikulum --</option>
                                        @foreach($kurikulums as $kur)
                                            <option value="{{ $kur->id }}">
                                                {{ $kur->nama_kurikulum }} {{ $kur->aktif ? '(Aktif)' : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if(empty($kurikulums) && $program_studi_id)
                                        <p class="text-xs text-yellow-600 mt-1">Prodi ini belum memiliki data kurikulum.</p>
                                    @endif
                                    @error('kurikulum_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="kode_mk" class="block text-sm font-medium text-gray-700">Kode Mata Kuliah</label>
                            <input type="text" wire:model="kode_mk" id="kode_mk" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                            @error('kode_mk') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="nama_mk" class="block text-sm font-medium text-gray-700">Nama Mata Kuliah</label>
                            <input type="text" wire:model="nama_mk" id="nama_mk" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                            @error('nama_mk') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="sks" class="block text-sm font-medium text-gray-700">SKS</label>
                                <input type="number" wire:model="sks" id="sks" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                                @error('sks') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="semester" class="block text-sm font-medium text-gray-700">Semester</label>
                                <input type="number" wire:model="semester" id="semester" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                                @error('semester') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label for="sifat" class="block text-sm font-medium text-gray-700">Sifat</label>
                            <select wire:model="sifat" id="sifat" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                                <option value="Wajib">Wajib</option>
                                <option value="Pilihan">Pilihan</option>
                                <option value="MKDU">MKDU (Wajib Nasional)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Syarat SKS Lulus <span class="text-xs text-gray-500">(Opsional)</span>
                            </label>
                            <input type="number" wire:model="syarat_sks_lulus" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                            <p class="text-xs text-gray-500 mt-1">Minimal SKS yang harus lulus (e.g. untuk Skripsi).</p>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Prasyarat -->
                    <div class="space-y-4">
                        <div class="bg-white border border-gray-300 rounded-md p-4 h-full flex flex-col">
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                Mata Kuliah Prasyarat
                                <span class="font-normal text-xs text-gray-500 block">Centang MK yang harus LULUS sebelum mengambil MK ini.</span>
                            </label>
                            
                            <div class="flex-1 overflow-y-auto border border-gray-200 rounded p-2 bg-gray-50 max-h-96">
                                @if(count($availablePrasyarats) > 0)
                                    <div class="space-y-2">
                                        @foreach($availablePrasyarats as $pra)
                                            <label class="flex items-start">
                                                <input type="checkbox" wire:model="prasyarat_ids" value="{{ $pra->id }}" class="mt-1 h-4 w-4 text-unmaris-blue border-gray-300 rounded focus:ring-unmaris-yellow">
                                                <div class="ml-2 text-sm">
                                                    <span class="font-medium text-gray-900">{{ $pra->nama_mk }}</span>
                                                    <span class="text-gray-500 text-xs block">Smt {{ $pra->semester }} ({{ $pra->kode_mk }})</span>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500 text-center mt-4">
                                        @if(!$kurikulum_id)
                                            Pilih Kurikulum terlebih dahulu untuk melihat daftar prasyarat.
                                        @else
                                            Belum ada MK lain di kurikulum ini.
                                        @endif
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-4 border-t pt-4">
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
                    Anda yakin ingin menghapus MK: <br>
                    <span class="font-bold">{{ $deletingMataKuliah?->nama_mk ?? '...' }}</span> ?
                </p>
            </div>
            <div class="mt-6 flex justify-end space-x-4">
                <button type="button" wire:click="closeDeleteModal" class="bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded hover:bg-gray-300">Batal</button>
                <button type="button" wire:click="delete" class="bg-red-600 text-white font-bold py-2 px-4 rounded hover:bg-red-700">Ya, Hapus</button>
            </div>
        </div>
    </div>
</div>