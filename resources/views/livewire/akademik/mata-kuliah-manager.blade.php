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
        
        <!-- Modal Container -->
        <div class="relative w-full max-w-5xl p-6 bg-white rounded-lg shadow-lg" @click.stop>
            <form wire:submit="save">
                <h3 class="text-2xl font-semibold text-unmaris-blue mb-4 pb-2 border-b">
                    {{ $isEditing ? 'Edit Mata Kuliah' : 'Tambah Mata Kuliah' }}
                </h3>
                
                <!-- Layout Grid: Kiri (Form Utama), Kanan (Prasyarat) -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 max-h-[75vh] overflow-y-auto pr-2">
                    
                    <!-- ========== KOLOM KIRI: DATA UTAMA ========== -->
                    <div class="space-y-4">
                        <!-- Box Pilih Prodi & Kurikulum -->
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                            <h4 class="text-sm font-bold text-blue-800 uppercase mb-3">1. Tentukan Kurikulum</h4>
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
                                    <!-- wire:model.live penting agar prasyarat ter-load saat kurikulum dipilih -->
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

                        <!-- Detail MK -->
                        <div class="grid grid-cols-3 gap-4">
                             <div class="col-span-1">
                                <label class="block text-sm font-medium text-gray-700">Kode MK</label>
                                <input type="text" wire:model="kode_mk" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                                @error('kode_mk') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Nama Mata Kuliah</label>
                                <input type="text" wire:model="nama_mk" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                                @error('nama_mk') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Sifat MK</label>
                                <select wire:model="sifat" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                                    <option value="Wajib">Wajib</option>
                                    <option value="Pilihan">Pilihan</option>
                                    <option value="MKDU">MKDU</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">SKS</label>
                                <input type="number" wire:model="sks" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                                @error('sks') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Semester</label>
                                <input type="number" wire:model="semester" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                                @error('semester') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Syarat SKS Lulus <span class="text-xs text-gray-500 font-normal">(Opsional, e.g. untuk Skripsi isi 110)</span>
                            </label>
                            <input type="number" wire:model="syarat_sks_lulus" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                        </div>
                    </div>

                    <!-- ========== KOLOM KANAN: PRASYARAT (INI YANG HILANG TADI) ========== -->
                    <div class="space-y-4">
                        <div class="bg-white border-2 border-gray-200 rounded-lg p-4 h-full flex flex-col shadow-sm">
                            <div class="mb-3 border-b pb-2">
                                <label class="block text-base font-bold text-gray-800">
                                    Mata Kuliah Prasyarat
                                </label>
                                <p class="text-xs text-gray-500 mt-1">
                                    Centang MK yang <b>WAJIB LULUS</b> sebelum mahasiswa boleh mengambil mata kuliah ini.
                                </p>
                            </div>
                            
                            <div class="flex-1 overflow-y-auto bg-gray-50 rounded p-2 border border-gray-200" style="min-height: 300px; max-height: 400px;">
                                @if(count($availablePrasyarats) > 0)
                                    <div class="space-y-2">
                                        @foreach($availablePrasyarats as $pra)
                                            <label class="flex items-start p-2 hover:bg-white rounded border border-transparent hover:border-gray-200 transition cursor-pointer">
                                                <div class="flex items-center h-5">
                                                    <input type="checkbox" wire:model="prasyarat_ids" value="{{ $pra->id }}" class="h-4 w-4 text-unmaris-blue border-gray-300 rounded focus:ring-unmaris-yellow">
                                                </div>
                                                <div class="ml-3 text-sm">
                                                    <span class="font-medium text-gray-900 block">{{ $pra->nama_mk }}</span>
                                                    <span class="text-xs text-gray-500">Kode: {{ $pra->kode_mk }} | Smt {{ $pra->semester }}</span>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="flex flex-col items-center justify-center h-full text-gray-400 text-center p-4">
                                        <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                        @if(!$kurikulum_id)
                                            <p class="text-sm">Silakan pilih <b>Kurikulum</b> terlebih dahulu di kolom sebelah kiri.</p>
                                        @else
                                            <p class="text-sm">Belum ada mata kuliah lain di kurikulum ini yang bisa dijadikan prasyarat.</p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- Akhir Kolom Kanan -->

                </div>

                <!-- Footer Modal -->
                <div class="mt-6 flex justify-end space-x-4 border-t pt-4">
                    <button type="button" wire:click="closeModal" class="bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded hover:bg-gray-300">Batal</button>
                    <button type="submit" class="bg-unmaris-blue text-white font-bold py-2 px-4 rounded hover:bg-unmaris-blue/80">Simpan Mata Kuliah</button>
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