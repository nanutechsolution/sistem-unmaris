<div class="p-6">
    <x-slot:header>Manajemen Prestasi (Wall of Fame)</x-slot:header>

    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <button wire:click="create"
            class="bg-unmaris-yellow text-unmaris-blue font-bold py-2 px-4 rounded hover:bg-blue-800 shadow-md transition">
            + Tambah Prestasi
        </button>

        <div class="flex w-full md:w-auto gap-2">
            <select wire:model.live="filterCategory" class="border-gray-300 rounded-md shadow-sm text-sm">
                <option value="">Semua Kategori</option>
                <option value="Akademik">Akademik</option>
                <option value="Olahraga">Olahraga</option>
                <option value="Seni">Seni</option>
            </select>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari Juara / Lomba..."
                class="border-gray-300 rounded-md shadow-sm text-sm w-full md:w-64">
        </div>
    </div>

    {{-- TABEL DATA --}}
    <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Foto</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Prestasi</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Pemenang</th>
                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase">Level & Medali</th>
                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($achievements as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="h-12 w-12 rounded bg-gray-100 overflow-hidden border border-gray-200">
                                <img src="{{ $item->image_url }}" class="h-full w-full object-cover">
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-gray-900">{{ $item->title }}</div>
                            <div class="text-xs text-gray-500">{{ $item->event_name }}</div>
                            <div class="text-[10px] text-gray-400 mt-1">
                                <i class="far fa-calendar-alt mr-1"></i> {{ $item->date->format('d M Y') }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $item->winner_name }}</div>
                            <div class="text-xs text-gray-500">{{ $item->prodi_name }}</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-2 py-1 text-xs rounded bg-gray-100 border mb-1 inline-block">
                                {{ $item->level }}
                            </span>
                            <br>
                            @php
                                // Logic Warna Badge
                                $medalClass = match ($item->medal) {
                                    'Gold' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                    'Silver' => 'bg-gray-100 text-gray-800 border-gray-200',
                                    'Bronze' => 'bg-orange-100 text-orange-800 border-orange-200',
                                    default
                                        => 'bg-blue-50 text-blue-800 border-blue-100', // Untuk Sertifikat/Participant
                                };

                                // Logic Label Tampilan (Ubah Participant jadi Sertifikat)
                                $medalLabel = match ($item->medal) {
                                    'Gold' => 'Emas 🥇',
                                    'Silver' => 'Perak 🥈',
                                    'Bronze' => 'Perunggu 🥉',
                                    default => 'Sertifikat 📄',
                                };
                            @endphp
                            <span
                                class="px-2 py-0.5 text-[10px] font-bold uppercase rounded border {{ $medalClass }}">
                                {{ $medalLabel }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button wire:click="edit({{ $item->id }})"
                                class="text-indigo-600 hover:text-indigo-900 font-bold mr-3">Edit</button>
                            <button wire:click="confirmDelete({{ $item->id }})"
                                class="text-red-600 hover:text-red-900 font-bold">Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada data prestasi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $achievements->links() }}</div>

    {{-- MODAL FORM --}}
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" x-data
            @click.self="$wire.set('showModal', false)">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                <div class="px-6 py-4 border-b bg-gray-50 sticky top-0 z-10">
                    <h3 class="text-lg font-bold text-gray-800">
                        {{ $isEditing ? 'Edit Prestasi' : 'Tambah Prestasi Baru' }}</h3>
                </div>

                <form wire:submit="save" class="p-6 space-y-5">

                    {{-- Upload Foto --}}
                    <div class="flex items-start gap-4">
                        <div
                            class="w-32 h-32 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden shrink-0">
                            @if ($image)
                                <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover">
                            @elseif ($old_image)
                                <img src="{{ Storage::url($old_image) }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-xs text-gray-400 text-center p-2">Preview Foto</span>
                            @endif
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Foto Dokumentasi</label>
                            <input type="file" wire:model="image"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                            <div wire:loading wire:target="image" class="text-xs text-blue-500 mt-1">Mengupload...</div>
                            @error('image')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Judul Prestasi</label>
                            <input type="text" wire:model="title" placeholder="Juara 1 Lomba Coding"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('title')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Event</label>
                            <input type="text" wire:model="event_name" placeholder="GEMASTIK 2025"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('event_name')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Pemenang / Tim</label>
                            <input type="text" wire:model="winner_name"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('winner_name')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Asal Prodi (Opsional)</label>
                            <input type="text" wire:model="prodi_name"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Level</label>
                            <select wire:model="level" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option>Lokal</option>
                                <option>Provinsi</option>
                                <option>Nasional</option>
                                <option>Internasional</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kategori</label>
                            <select wire:model="category"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option>Akademik</option>
                                <option>Olahraga</option>
                                <option>Seni</option>
                                <option>Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Pencapaian</label>
                            <select wire:model="medal"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-blue focus:border-unmaris-blue">
                                <option value="Gold">Emas 🥇</option>
                                <option value="Silver">Perak 🥈</option>
                                <option value="Bronze">Perunggu 🥉</option>
                                {{-- Opsi ini untuk yang tidak dapat medali --}}
                                <option value="Participant">Sertifikat / Partisipan 📄</option>
                            </select>
                            <p class="text-[10px] text-gray-400 mt-1">*Pilih 'Sertifikat' jika tidak ada medali.</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Pencapaian</label>
                        <input type="date" wire:model="date"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Cerita Singkat / Deskripsi</label>
                        <textarea wire:model="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t">
                        <button type="button" wire:click="$set('showModal', false)"
                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md font-bold hover:bg-gray-300">Batal</button>
                        <button type="submit"
                            class="bg-unmaris-blue text-white px-4 py-2 rounded-md font-bold hover:bg-blue-800">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- MODAL DELETE --}}
    @if ($showDeleteModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-sm p-6 text-center">
                <h3 class="text-lg font-bold text-red-600 mb-2">Hapus Data?</h3>
                <p class="text-sm text-gray-600 mb-6">Data yang dihapus tidak dapat dikembalikan.</p>
                <div class="flex justify-center space-x-3">
                    <button wire:click="$set('showDeleteModal', false)"
                        class="bg-gray-200 px-4 py-2 rounded font-bold text-sm">Batal</button>
                    <button wire:click="delete"
                        class="bg-red-600 text-white px-4 py-2 rounded font-bold text-sm hover:bg-red-700">Ya,
                        Hapus</button>
                </div>
            </div>
        </div>
    @endif
</div>
