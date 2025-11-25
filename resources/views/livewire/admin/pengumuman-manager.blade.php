<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Manajemen Pengumuman</h2>
        <button wire:click="create" class="bg-unmaris-blue text-white px-4 py-2 rounded-lg font-bold hover:bg-blue-800 shadow-md">
            + Buat Pengumuman Baru
        </button>
    </div>

    {{-- Filter & Search --}}
    <div class="mb-4">
        <input type="text" wire:model.live.debounce="search" placeholder="Cari judul..." class="w-full md:w-1/3 border-gray-300 rounded-lg shadow-sm focus:ring-unmaris-blue focus:border-unmaris-blue">
    </div>

    {{-- TABEL DATA --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Info</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Status & Jadwal</th>
                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($pengumumans as $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            {{-- Thumbnail Kecil --}}
                            <div class="h-10 w-10 flex-shrink-0 bg-gray-200 rounded overflow-hidden mr-3">
                                @if($item->thumbnail)
                                    <img src="{{ asset('storage/'.$item->thumbnail) }}" class="h-full w-full object-cover">
                                @else
                                    <div class="h-full w-full flex items-center justify-center text-gray-400"><i class="fas fa-image"></i></div>
                                @endif
                            </div>
                            <div>
                                <div class="font-bold text-gray-900 line-clamp-1">{{ $item->judul }}</div>
                                <div class="text-xs text-gray-500">Views: {{ $item->views }} | Oleh: {{ $item->penulis }}</div>
                                @if($item->is_pinned)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 mt-1">
                                        <i class="fas fa-thumbtack mr-1"></i> Pinned
                                    </span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs font-bold rounded-full bg-blue-50 text-unmaris-blue border border-blue-100">
                            {{ $item->kategori }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="w-2 h-2 rounded-full {{ $item->status == 'Published' ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                            {{ $item->status }}
                        </div>
                        <div class="text-xs text-gray-400">
                            {{ $item->published_at ? $item->published_at->format('d/m/Y H:i') : '-' }}
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <button wire:click="edit({{ $item->id }})" class="text-blue-600 hover:text-blue-900 font-bold text-sm">Edit</button>
                        <button wire:click="confirmDelete({{ $item->id }})" class="text-red-600 hover:text-red-900 font-bold text-sm">Hapus</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $pengumumans->links() }}</div>

    {{-- MODAL FORM (FULL SCREEN agar puas ngetik berita) --}}
    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto bg-gray-900 bg-opacity-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">
            
            {{-- Header Modal --}}
            <div class="px-6 py-4 border-b flex justify-between items-center sticky top-0 bg-white z-10">
                <h3 class="text-xl font-bold text-gray-800">{{ $isEditing ? 'Edit Pengumuman' : 'Buat Pengumuman Baru' }}</h3>
                <button wire:click="$set('showModal', false)" class="text-gray-500 hover:text-gray-700"><i class="fas fa-times text-xl"></i></button>
            </div>

            <form wire:submit="save" class="p-6 space-y-6">
                
                {{-- Row 1: Judul & Kategori --}}
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-1">Judul Pengumuman</label>
                        <input type="text" wire:model="judul" class="w-full border-gray-300 rounded-lg focus:ring-unmaris-blue focus:border-unmaris-blue" placeholder="Contoh: Jadwal Libur Lebaran 2025">
                        @error('judul') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Kategori</label>
                        <select wire:model="kategori" class="w-full border-gray-300 rounded-lg">
                            <option>Umum</option>
                            <option>Akademik</option>
                            <option>Kemahasiswaan</option>
                            <option>Beasiswa</option>
                        </select>
                    </div>
                </div>

                {{-- Row 2: Konten Utama --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Isi Berita</label>
                    <textarea wire:model="konten" rows="10" class="w-full border-gray-300 rounded-lg focus:ring-unmaris-blue focus:border-unmaris-blue" placeholder="Tulis pengumuman lengkap di sini..."></textarea>
                    <p class="text-xs text-gray-400 mt-1">*Bisa menggunakan format HTML sederhana.</p>
                    @error('konten') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Row 3: Ringkasan (Optional) --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Ringkasan Singkat (Untuk Preview di Depan)</label>
                    <textarea wire:model="ringkasan" rows="2" class="w-full border-gray-300 rounded-lg"></textarea>
                </div>

                <div class="grid md:grid-cols-2 gap-6 border-t pt-6">
                    {{-- Row 4: Uploads --}}
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Gambar Thumbnail</label>
                            <input type="file" wire:model="thumbnail" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            @if ($thumbnail)
                                <img src="{{ $thumbnail->temporaryUrl() }}" class="mt-2 h-24 rounded border">
                            @elseif ($old_thumbnail)
                                <img src="{{ asset('storage/'.$old_thumbnail) }}" class="mt-2 h-24 rounded border">
                            @endif
                            @error('thumbnail') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Lampiran PDF (Optional)</label>
                            <input type="file" wire:model="file_lampiran" class="text-sm">
                            @if($old_file_lampiran)
                                <div class="text-xs text-green-600 mt-1"><i class="fas fa-check"></i> File lama tersimpan. Upload baru untuk mengganti.</div>
                            @endif
                        </div>
                    </div>

                    {{-- Row 5: Settings --}}
                    <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Status Tayang</label>
                            <select wire:model="status" class="w-full border-gray-300 rounded-lg">
                                <option value="Published">Published (Tayang)</option>
                                <option value="Draft">Draft (Simpan Dulu)</option>
                                <option value="Archived">Archived (Arsip)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Jadwal Tayang</label>
                            <input type="datetime-local" wire:model="published_at" class="w-full border-gray-300 rounded-lg">
                            <p class="text-xs text-gray-500 mt-1">Biarkan default jika ingin tayang sekarang.</p>
                        </div>

                        <div class="flex items-center pt-2">
                            <input type="checkbox" wire:model="is_pinned" id="pinned" class="rounded border-gray-300 text-unmaris-blue focus:ring-unmaris-blue">
                            <label for="pinned" class="ml-2 text-sm text-gray-700 font-bold">Pin Pengumuman (Tampil Paling Atas)</label>
                        </div>
                    </div>
                </div>

                {{-- Footer Actions --}}
                <div class="flex justify-end space-x-3 pt-6 border-t">
                    <button type="button" wire:click="$set('showModal', false)" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-bold">Batal</button>
                    <button type="submit" class="bg-unmaris-blue text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-800 flex items-center">
                        <span wire:loading.remove wire:target="save">Simpan Pengumuman</span>
                        <span wire:loading wire:target="save">Menyimpan...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>