<div>
    <x-slot:header>
        Manajemen Quality Documents
    </x-slot:header>

    <div class="mb-4">
        <button wire:click="openCreateModal" class="bg-unmaris-yellow text-unmaris-blue font-bold py-2 px-4 rounded hover:bg-yellow-400">
            + Tambah Dokumen
        </button>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($documents as $doc)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $doc->kode }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $doc->title }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $doc->category }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                        {{ $doc->published_at ? \Carbon\Carbon::parse($doc->published_at)->format('d M Y') : '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button wire:click="openEditModal({{ $doc->id }})" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                        <button wire:click="openDeleteModal({{ $doc->id }})" class="text-red-600 hover:text-red-900 ml-4">Hapus</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada dokumen</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4">
            {{ $documents->links() }}
        </div>
    </div>

    {{-- ========================= --}}
    {{-- Modal Create / Edit --}}
    {{-- ========================= --}}
    <div x-data="{ show: @entangle('modal') }" x-show="show" x-on:keydown.escape.window="show = false" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" x-cloak>

        <div @click="show = false" class="absolute inset-0"></div>

        <div class="relative w-full max-w-xl p-6 bg-white rounded-lg shadow-lg" @click.stop>
            <form wire:submit.prevent="save">

                <h3 class="text-2xl font-semibold text-unmaris-blue mb-4">
                    {{ $isEditing ? 'Edit Dokumen' : 'Tambah Dokumen Baru' }}
                </h3>

                <div class="space-y-4">

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kode Dokumen</label>
                        <input type="text" wire:model="kode" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('kode') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Judul</label>
                        <input type="text" wire:model="title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select wire:model="category" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="SOP">SOP</option>
                            <option value="Kebijakan Mutu">Kebijakan Mutu</option>
                            <option value="Manual Mutu">Manual Mutu</option>
                            <option value="Panduan">Panduan</option>
                            <option value="Formulir">Formulir</option>
                            <option value="Instruksi Kerja">Instruksi Kerja</option>
                        </select>
                        @error('category') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea wire:model="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                        @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Upload File</label>
                        <input type="file" wire:model="file" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />

                        @error('file') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                        @if ($isEditing && $docId)
                        @php
                        $fileDoc = \App\Models\QualityDocument::find($docId);
                        @endphp

                        @if ($fileDoc && $fileDoc->file_path)
                        <p class="mt-2 text-sm text-gray-600">
                            File saat ini:
                            <a href="{{ Storage::url($fileDoc->file_path) }}" target="_blank" class="text-blue-600 underline">
                                Lihat File
                            </a>
                        </p>
                        @endif
                        @endif
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Terbit</label>
                        <input type="date" wire:model="published_at" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('published_at') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                </div>

                <div class="mt-6 flex justify-end space-x-4">
                    <button type="button" wire:click="$set('modal', false)" class="bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded hover:bg-gray-300">
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

    {{-- ========================= --}}
    {{-- Delete Modal --}}
    {{-- ========================= --}}
    <div x-data="{ show: @entangle('showDeleteModal') }" x-show="show" x-on:keydown.escape.window="show = false" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" x-cloak>

        <div @click="show = false" class="absolute inset-0"></div>

        <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow-lg" @click.stop>
            <h3 class="text-2xl font-semibold text-unmaris-blue">Konfirmasi Hapus</h3>

            <div class="mt-4">
                <p class="text-gray-600">
                    Anda yakin ingin menghapus dokumen:<br>
                    <span class="font-bold">
                        {{ $deletingDoc?->title ?? '...' }}
                    </span> ?
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
