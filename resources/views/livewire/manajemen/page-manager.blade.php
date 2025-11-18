<div>
    <!-- Slot Header -->
    <x-slot:header>Manajemen Halaman Statis</x-slot:header>

    <!-- Tombol Aksi -->
    <div class="mb-4">
        <button wire:click="openCreateModal" class="bg-unmaris-yellow text-unmaris-blue font-bold py-2 px-4 rounded hover:bg-yellow-400">
            + Tambah Halaman Baru
        </button>
    </div>

    <!-- Tabel Data Responsif -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Judul Halaman
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Slug (URL)
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Aksi</span>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($pages as $page)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $page->title }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">
                        /p/{{ $page->slug }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $page->status == 'Published' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $page->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button wire:click="openEditModal({{ $page->id }})" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                        Belum ada halaman. Klik 'Tambah Halaman Baru' untuk memulai.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginasi -->
    <div class="mt-4">
        {{ $pages->links() }}
    </div>

    <!-- MODAL TAMBAH/EDIT DATA -->
    <div x-data="{ show: @entangle('showModal') }" x-show="show" x-on:keydown.escape.window="show = false" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" x-cloak>

        <!-- Latar Belakang Modal -->
        <div @click="show = false" class="absolute inset-0"></div>

        <!-- Konten Modal -->
        <div class="relative w-full max-w-3xl p-6 bg-white rounded-lg shadow-lg" @click.stop>
            <form wire:submit="save">
                <h3 class="text-2xl font-semibold text-unmaris-blue">
                    {{ $isEditing ? 'Edit Halaman' : 'Tambah Halaman Baru' }}
                </h3>

                <div class="mt-4 space-y-4 max-h-[70vh] overflow-y-auto pr-2">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Judul Halaman</label>
                        <input type="text" wire:model.live="title" id="title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                        @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700">URL Slug</label>
                        <div class="flex items-center mt-1">
                            <span class="bg-gray-100 p-2 border border-r-0 border-gray-300 rounded-l-md text-gray-500 text-sm">/p/</span>
                            <input type="text" wire:model="slug" id="slug" class="block w-full border-gray-300 rounded-r-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                        </div>
                        @error('slug') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>


                    <div wire:ignore class="space-y-1">
                        <label for="content" class="block text-sm font-medium text-gray-700">Konten</label>

                        <input id="contentInput" type="hidden" wire:model="content">

                        <trix-editor input="contentInput" class="trix-content"></trix-editor>

                        @error('content')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select wire:model="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                            <option value="Published">Publikasikan (Published)</option>
                            <option value="Draft">Simpan sebagai Draft</option>
                        </select>
                    </div>
                </div>

                <!-- Footer Modal -->
                <div class="mt-6 flex justify-end space-x-4">
                    <button type="button" wire:click="closeModal" class="bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded hover:bg-gray-300">
                        Batal
                    </button>
                    <button type="submit" class="bg-unmaris-blue text-white font-bold py-2 px-4 rounded hover:bg-unmaris-blue/80">
                        <span wire:loading.remove wire:target="save">Simpan Halaman</span>
                        <span wire:loading wire:target="save">Menyimpan...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('trix-change', function(e) {
            @this.set('content', e.target.value)
        })
    </script>

</div>
