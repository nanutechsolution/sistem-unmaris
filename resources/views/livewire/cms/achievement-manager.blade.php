<div class="p-6">
    <x-slot:header>Manajemen Prestasi (Wall of Fame)</x-slot:header>

    {{-- GLOBAL TOAST --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <button wire:click="create" class="bg-unmaris-blue text-white font-bold py-2 px-4 rounded hover:bg-blue-800 shadow-md transition w-full md:w-auto text-center">
            + Tambah Prestasi
        </button>

        <div class="flex flex-col md:flex-row w-full md:w-auto gap-2">
            <select wire:model.live="filterCategory" class="border-gray-300 rounded-md shadow-sm text-sm w-full md:w-auto">
                <option value="">Semua Kategori</option>
                <option value="Akademik">Akademik</option>
                <option value="Olahraga">Olahraga</option>
                <option value="Seni">Seni</option>
            </select>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari Juara / Lomba..." 
                   class="border-gray-300 rounded-md shadow-sm text-sm w-full md:w-64">
        </div>
    </div>

    {{-- TABEL DATA (RESPONSIVE FIX) --}}
    {{-- Tambahkan 'overflow-x-auto' agar tabel bisa di-scroll horizontal di HP --}}
    <div class="bg-white shadow-md rounded-lg overflow-hidden overflow-x-auto border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Foto</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Prestasi</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Pemenang</th>
                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Level & Medali</th>
                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($achievements as $item)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="h-12 w-12 rounded bg-gray-100 overflow-hidden border border-gray-200">
                            @if($item->image_path)
                                <img src="{{ Storage::url($item->image_path) }}" class="h-full w-full object-cover">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-400">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-bold text-gray-900">{{ Str::limit($item->title, 30) }}</div>
                        <div class="text-xs text-gray-500">{{ Str::limit($item->event_name, 30) }}</div>
                        <div class="text-[10px] text-gray-400 mt-1">
                            <i class="far fa-calendar-alt mr-1"></i> {{ $item->date->format('d M Y') }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $item->winner_name }}</div>
                        <div class="text-xs text-gray-500">{{ $item->prodi_name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span class="px-2 py-1 text-xs rounded bg-gray-100 border mb-1 inline-block">
                            {{ $item->level }}
                        </span>
                        <br>
                        @php
                            $medalClass = match($item->medal) {
                                'Gold' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                'Silver' => 'bg-gray-100 text-gray-800 border-gray-200',
                                'Bronze' => 'bg-orange-100 text-orange-800 border-orange-200',
                                default => 'bg-blue-50 text-blue-800 border-blue-100'
                            };
                            $medalLabel = match($item->medal) {
                                'Gold' => 'Emas 🥇',
                                'Silver' => 'Perak 🥈',
                                'Bronze' => 'Perunggu 🥉',
                                default => 'Sertifikat 📄'
                            };
                        @endphp
                        <span class="px-2 py-0.5 text-[10px] font-bold uppercase rounded border {{ $medalClass }}">
                            {{ $medalLabel }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end gap-2">
                            <button wire:click="edit({{ $item->id }})" class="text-indigo-600 hover:text-indigo-900 font-bold bg-indigo-50 px-3 py-1 rounded hover:bg-indigo-100 transition">Edit</button>
                            <button wire:click="confirmDelete({{ $item->id }})" class="text-red-600 hover:text-red-900 font-bold bg-red-50 px-3 py-1 rounded hover:bg-red-100 transition">Hapus</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                        <div class="flex flex-col items-center justify-center">
                            <i class="fas fa-trophy text-4xl text-gray-300 mb-3"></i>
                            <p>Belum ada data prestasi.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $achievements->links() }}
    </div>

    {{-- MODAL FORM --}}
    @if($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4 backdrop-blur-sm" x-data @click.self="$wire.set('showModal', false)">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <div class="px-6 py-4 border-b bg-gray-50 sticky top-0 z-10 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800">{{ $isEditing ? 'Edit Prestasi' : 'Tambah Prestasi Baru' }}</h3>
                <button wire:click="$set('showModal', false)" class="text-gray-400 hover:text-gray-600 transition">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <form wire:submit="save" class="p-6 space-y-5">
                
                {{-- Upload Foto --}}
                <div class="flex flex-col sm:flex-row items-start gap-4">
                    <div class="w-full sm:w-32 h-32 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden shrink-0 relative">
                        <div wire:loading wire:target="image" class="absolute inset-0 bg-white/80 flex items-center justify-center z-10">
                            <i class="fas fa-spinner animate-spin text-unmaris-blue"></i>
                        </div>

                        @if ($image)
                            <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover">
                        @elseif ($old_image)
                            <img src="{{ Storage::url($old_image) }}" class="w-full h-full object-cover">
                        @else
                            <div class="text-center p-2">
                                <i class="fas fa-camera text-gray-400 text-2xl mb-1"></i>
                                <span class="text-[10px] text-gray-400 block">Preview Foto</span>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 w-full">
                        <label class="block text-sm font-bold text-gray-700 mb-1">Foto Dokumentasi</label>
                        <input type="file" wire:model="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition border border-gray-300 rounded-lg cursor-pointer">
                        <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Max: 2MB.</p>
                        @error('image') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Judul Prestasi</label>
                        <input type="text" wire:model="title" placeholder="Contoh: Juara 1 Lomba Coding" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-blue focus:border-unmaris-blue">
                        @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Event</label>
                        <input type="text" wire:model="event_name" placeholder="Contoh: GEMASTIK 2025" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-blue focus:border-unmaris-blue">
                        @error('event_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Pemenang / Tim</label>
                        <input type="text" wire:model="winner_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-blue focus:border-unmaris-blue">
                        @error('winner_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Asal Prodi (Opsional)</label>
                        <input type="text" wire:model="prodi_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-blue focus:border-unmaris-blue">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Level</label>
                        <select wire:model="level" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-blue">
                            <option>Lokal</option>
                            <option>Provinsi</option>
                            <option>Nasional</option>
                            <option>Internasional</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select wire:model="category" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-blue">
                            <option>Akademik</option>
                            <option>Olahraga</option>
                            <option>Seni</option>
                            <option>Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Pencapaian</label>
                        <select wire:model="medal" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-blue">
                            <option value="Gold">Emas 🥇</option>
                            <option value="Silver">Perak 🥈</option>
                            <option value="Bronze">Perunggu 🥉</option>
                            <option value="Participant">Sertifikat / Partisipan 📄</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Pencapaian</label>
                    <input type="date" wire:model="date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-blue">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Cerita Singkat / Deskripsi</label>
                    <textarea wire:model="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-blue"></textarea>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t bg-gray-50 -mx-6 -mb-6 p-4">
                    <button type="button" wire:click="$set('showModal', false)" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md font-bold hover:bg-gray-300 transition">Batal</button>
                    <button type="submit" class="bg-unmaris-blue text-white px-6 py-2 rounded-md font-bold hover:bg-blue-800 flex items-center shadow-md">
                        <span wire:loading.remove wire:target="save">Simpan</span>
                        <span wire:loading wire:target="save"><i class="fas fa-spinner animate-spin mr-2"></i> Menyimpan...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- MODAL DELETE --}}
    @if($showDeleteModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4 backdrop-blur-sm">
        <div class="bg-white rounded-xl shadow-lg p-6 text-center max-w-sm w-full">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <i class="fas fa-trash-alt text-red-600 text-xl"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Hapus Data?</h3>
            <p class="text-sm text-gray-500 mb-6">Data yang dihapus tidak dapat dikembalikan.</p>
            <div class="flex justify-center gap-3">
                <button wire:click="$set('showDeleteModal', false)" class="bg-gray-200 px-4 py-2 rounded-md font-bold text-sm hover:bg-gray-300 transition">Batal</button>
                <button wire:click="delete" class="bg-red-600 text-white px-4 py-2 rounded-md font-bold text-sm hover:bg-red-700 transition flex items-center shadow-md">
                    <span wire:loading.remove wire:target="delete">Ya, Hapus</span>
                    <span wire:loading wire:target="delete"><i class="fas fa-spinner animate-spin mr-2"></i> Menghapus...</span>
                </button>
            </div>
        </div>
    </div>
    @endif
</div>