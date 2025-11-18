<div>
    <x-slot:header>Manajemen Berita & Pengumuman</x-slot:header>

    <div class="mb-4">
        <button wire:click="openCreateModal" class="bg-unmaris-yellow text-unmaris-blue font-bold py-2 px-4 rounded hover:bg-yellow-400">
            + Tulis Berita Baru
        </button>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Berita</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penulis</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Terbit</th>
                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($posts as $post)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $post->title }}</div>
                        <div class="text-xs text-gray-500 font-mono">/berita/{{ $post->slug }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $post->category?->name ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $post->author?->name ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $post->status == 'Published' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $post->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $post->published_at->format('d M Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button wire:click="openEditModal({{ $post->id }})" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                        <button wire:click="openDeleteModal({{ $post->id }})" class="text-red-600 hover:text-red-900 ml-4">Hapus</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                        Belum ada berita. Klik 'Tulis Berita Baru' untuk memulai.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $posts->links() }}
    </div>

    <div x-data="{ show: @entangle('showModal') }" x-show="show" x-on:keydown.escape.window="show = false" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" x-cloak>

        {{-- Overlay klik untuk menutup --}}
        <div @click="show = false" class="absolute inset-0"></div>

        {{-- CARD MODAL --}}
        <div class="relative w-full max-w-5xl bg-white rounded-lg shadow-lg overflow-hidden" @click.stop>
            <form wire:submit="save" class="flex flex-col h-full">

                {{-- HEADER --}}
                <div class="p-6 border-b">
                    <h3 class="text-2xl font-semibold text-unmaris-blue">
                        {{ $isEditing ? 'Edit Berita' : 'Tulis Berita Baru' }}
                    </h3>
                </div>

                {{-- BODY --}}
                <div class="flex-1 p-6 grid grid-cols-1 md:grid-cols-3 gap-6 overflow-y-auto max-h-[70vh]">

                    {{-- LEFT — MAIN CONTENT --}}
                    <div class="md:col-span-2 space-y-4">

                        {{-- Title --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Judul Berita</label>
                            <input type="text" wire:model.live="title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                            @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        {{-- Slug --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">URL Slug</label>
                            <div class="flex items-center mt-1">
                                <span class="bg-gray-100 p-2 border border-r-0 border-gray-300 rounded-l-md text-gray-500 text-sm">/berita/</span>
                                <input type="text" wire:model="slug" class="block w-full border-gray-300 rounded-r-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                            </div>
                        </div>

                        {{-- TRIX EDITOR --}}
                        <div wire:ignore>
                            <label for="content" class="block text-sm font-medium text-gray-700">Konten</label>

                            <input id="content" type="hidden" wire:model="content">

                            <trix-editor input="content" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-white">
                            </trix-editor>
                        </div>

                        @error('content')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror

                    </div>

                    {{-- RIGHT — META --}}
                    <div class="md:col-span-1 space-y-4">

                        {{-- Status --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select wire:model="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                                <option value="Published">Publikasikan</option>
                                <option value="Draft">Simpan sebagai Draft</option>
                            </select>
                        </div>

                        {{-- Date --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Terbit</label>
                            <input type="date" wire:model="published_at" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                        </div>

                        {{-- Category --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kategori</label>
                            <select wire:model="category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        {{-- Featured Image --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Gambar Unggulan</label>
                            <input type="file" wire:model="featured_image" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                            @error('featured_image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                            {{-- PREVIEW --}}
                            <div class="mt-2">
                                @if ($featured_image)
                                <img src="{{ $featured_image->temporaryUrl() }}" class="w-full h-auto rounded shadow">
                                @elseif ($existing_featured_image)
                                <img src="{{ Storage::url($existing_featured_image) }}" class="w-full h-auto rounded shadow">
                                @endif
                            </div>
                        </div>

                    </div>
                </div>

                {{-- FOOTER --}}
                <div class="p-6 border-t flex justify-end gap-3 bg-gray-50">

                    <button type="button" wire:click="closeModal" class="bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded hover:bg-gray-300">
                        Batal
                    </button>

                    <button type="submit" class="bg-unmaris-blue text-white font-semibold py-2 px-4 rounded hover:bg-unmaris-blue/80">
                        <span wire:loading.remove wire:target="save">Simpan Berita</span>
                        <span wire:loading wire:target="save">Menyimpan...</span>
                    </button>

                </div>
            </form>
        </div>
    </div>

    {{-- TRIX SYNC --}}
    <script>
        document.addEventListener("trix-change", e => {
            @this.set("content", e.target.value);
        });

        Livewire.on("loadTrix", content => {
            document.querySelector("trix-editor").editor.loadHTML(content);
        });

    </script>


    <div x-data="{ show: @entangle('showDeleteModal') }" x-show="show" x-on:keydown.escape.window="show = false" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" x-cloak>

        <div @click="show = false" class="absolute inset-0"></div>

        <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow-lg" @click.stop>
            <h3 class="text-2xl font-semibold text-unmaris-blue">Konfirmasi Hapus</h3>
            <div class="mt-4">
                <p class="text-gray-600">
                    Anda yakin ingin menghapus berita: <br>
                    <span class="font-bold">{{ $deletingPost?->title ?? '...' }}</span> ?
                </p>
                <p class="mt-2 text-sm text-red-500">
                    Tindakan ini akan menghapus gambar unggulan dan tidak dapat dibatalkan.
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
