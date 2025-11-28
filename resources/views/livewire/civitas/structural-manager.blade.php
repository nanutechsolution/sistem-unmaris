<div class="p-6">
    <x-slot:header>Manajemen Pimpinan & Yayasan</x-slot:header>

    {{-- NOTIFIKASI --}}
    @if (session()->has('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- TAB NAVIGASI --}}
    <div class="flex space-x-1 bg-gray-100 p-1 rounded-lg mb-6 w-fit border border-gray-200">
        @foreach(['Rektorat', 'Yayasan', 'Senat'] as $tab)
            <button wire:click="$set('activeTab', '{{ $tab }}')" 
                    class="px-6 py-2 rounded-md text-sm font-bold transition {{ $activeTab == $tab ? 'bg-white text-unmaris-blue shadow' : 'text-gray-500 hover:text-gray-700' }}">
                {{ $tab }}
            </button>
        @endforeach
    </div>

    <div class="flex justify-between items-center mb-4">
        <button wire:click="create" class="bg-unmaris-blue text-white font-bold py-2 px-4 rounded hover:bg-blue-800 shadow-md transition">
            + Lantik Pejabat Baru
        </button>

        <div class="w-1/3">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama pejabat..." 
                   class="w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-blue">
        </div>
    </div>

    {{-- TABEL DATA --}}
    <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Jabatan</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pejabat</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Periode</th>
                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($assignments as $item)
                <tr class="hover:bg-gray-50 {{ !$item->is_active ? 'bg-gray-50 opacity-75' : '' }}">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm font-bold text-unmaris-blue">{{ $item->position->name }}</span>
                        <div class="text-xs text-gray-400">Urutan: {{ $item->position->urutan }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <img src="{{ $item->photo_url }}" class="h-10 w-10 rounded-full object-cover border border-gray-200 mr-3">
                            <div>
                                <div class="text-sm font-bold text-gray-900">{{ $item->name }}</div>
                                <div class="text-xs text-gray-500">
                                    {{ $item->dosen_id ? 'Internal (Dosen)' : 'Eksternal' }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        {{ $item->start_date->format('d M Y') }} 
                        <span class="text-gray-400 mx-1">-</span> 
                        {{ $item->end_date ? $item->end_date->format('d M Y') : 'Sekarang' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        @if($item->is_active)
                            <span class="px-2 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800 border border-green-200">
                                AKTIF
                            </span>
                        @else
                            <span class="px-2 py-1 text-xs font-bold rounded-full bg-gray-100 text-gray-500 border border-gray-200">
                                SELESAI
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm space-x-2">
                        <button wire:click="edit({{ $item->id }})" class="text-indigo-600 hover:text-indigo-900 font-bold">Edit</button>
                        <button wire:click="confirmDelete({{ $item->id }})" class="text-red-600 hover:text-red-900 font-bold">Hapus</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                        <i class="far fa-user-circle text-3xl mb-2 text-gray-300"></i>
                        <p>Belum ada data pejabat untuk kelompok {{ $activeTab }}.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $assignments->links() }}</div>

    {{-- MODAL FORM --}}
    @if($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4 backdrop-blur-sm" x-data @click.self="$wire.set('showModal', false)">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
            <div class="px-6 py-4 border-b bg-gray-50 sticky top-0 z-10">
                <h3 class="text-lg font-bold text-gray-800">{{ $isEditing ? 'Edit Data' : 'Lantik Pejabat Baru' }}</h3>
            </div>
            
            <form wire:submit="save" class="p-6 space-y-5">
                
                {{-- PILIH JABATAN (DENGAN FITUR TAMBAH BARU) --}}
                <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-sm font-bold text-gray-700">Jabatan ({{ $activeTab }})</label>
                        
                        {{-- Tombol Toggle Tambah Jabatan --}}
                        <button type="button" 
                                wire:click="$toggle('isCreatingPosition')" 
                                class="text-xs text-unmaris-blue hover:text-blue-800 font-bold flex items-center">
                            {{ $isCreatingPosition ? 'Batal Tambah' : '+ Buat Jabatan Baru' }}
                        </button>
                    </div>

                    @if($isCreatingPosition)
                        {{-- INPUT JABATAN BARU --}}
                        <div class="flex gap-2 items-start animate-fade-in">
                            <div class="flex-1">
                                <input type="text" wire:model="new_position_name" placeholder="Nama Jabatan (Mis: Pembina)" class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-unmaris-blue">
                                @error('new_position_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div class="w-20">
                                <input type="number" wire:model="new_position_order" placeholder="Urut" class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-unmaris-blue">
                            </div>
                            <button type="button" wire:click="saveNewPosition" class="bg-green-600 text-white px-3 py-2 rounded-md font-bold text-xs hover:bg-green-700 shadow-sm">
                                Simpan
                            </button>
                        </div>
                        <p class="text-[10px] text-gray-500 mt-1">*Jabatan baru akan otomatis masuk ke kelompok <strong>{{ $activeTab }}</strong>.</p>
                    @else
                        {{-- DROPDOWN JABATAN BIASA --}}
                        <select wire:model="structural_position_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-blue">
                            <option value="">-- Pilih Posisi --</option>
                            @foreach($positions as $pos)
                                <option value="{{ $pos->id }}">{{ $pos->name }}</option>
                            @endforeach
                        </select>
                        @error('structural_position_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    @endif
                </div>

                {{-- Sumber Data Toggle --}}
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-3">Sumber Data Pejabat</label>
                    <div class="flex gap-4 mb-4">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" wire:model.live="source_type" value="dosen" class="text-unmaris-blue focus:ring-unmaris-blue">
                            <span class="ml-2 text-sm font-medium">Dosen Internal</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" wire:model.live="source_type" value="manual" class="text-unmaris-blue focus:ring-unmaris-blue">
                            <span class="ml-2 text-sm font-medium">Input Manual (Luar)</span>
                        </label>
                    </div>

                    {{-- Jika Dosen --}}
                    @if($source_type == 'dosen')
                        <div>
                            <select wire:model="dosen_id" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                                <option value="">-- Pilih Dosen --</option>
                                @foreach($dosens as $d)
                                    <option value="{{ $d->id }}">{{ $d->nama_lengkap }}</option>
                                @endforeach
                            </select>
                            @error('dosen_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    @else
                        {{-- Jika Manual --}}
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-bold text-gray-600">Nama Lengkap & Gelar</label>
                                <input type="text" wire:model="name_custom" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                                @error('name_custom') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600">Foto Pejabat</label>
                                <input type="file" wire:model="photo_custom" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                @if($photo_custom)
                                    <img src="{{ $photo_custom->temporaryUrl() }}" class="h-16 w-16 mt-2 rounded-full object-cover border">
                                @elseif($old_photo_custom)
                                    <img src="{{ Storage::url($old_photo_custom) }}" class="h-16 w-16 mt-2 rounded-full object-cover border">
                                @endif
                                @error('photo_custom') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Periode --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Mulai Menjabat</label>
                        <input type="date" wire:model="start_date" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                        @error('start_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Selesai Menjabat</label>
                        <input type="date" wire:model="end_date" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                        @error('end_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Status Aktif --}}
                <div class="flex items-center bg-green-50 p-3 rounded border border-green-200">
                    <input type="checkbox" wire:model="is_active" id="active_status" class="rounded text-green-600 focus:ring-green-500 h-5 w-5">
                    <label for="active_status" class="ml-2 text-sm font-bold text-green-800">Set sebagai Pejabat Aktif Saat Ini</label>
                </div>
                @error('is_active') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror

                <div class="flex justify-end gap-3 pt-4 border-t">
                    <button type="button" wire:click="$set('showModal', false)" class="bg-gray-200 px-4 py-2 rounded text-sm font-bold hover:bg-gray-300">Batal</button>
                    <button type="submit" class="bg-unmaris-blue text-white px-4 py-2 rounded text-sm font-bold hover:bg-blue-800">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>