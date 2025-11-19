<div>
    <x-slot:header>
        Manajemen Quality Announcements (Pengumuman Mutu)
    </x-slot:header>

    <div class="mb-4">
        <button wire:click="create" class="bg-unmaris-yellow text-unmaris-blue font-bold py-2 px-4 rounded hover:bg-yellow-400">
            + Tambah Pengumuman
        </button>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Terbit</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diposting Oleh</th>
                    <th class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($announcements as $ann)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $ann->title }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                        {{ $ann->published_at ? \Carbon\Carbon::parse($ann->published_at)->format('d M Y') : '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                        {{ $ann->poster->name ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button wire:click="edit({{ $ann->id }})" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                        <button wire:click="openDeleteModal({{ $ann->id }})" class="text-red-600 hover:text-red-900 ml-4">Hapus</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada pengumuman</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4">
            {{ $announcements->links() }}
        </div>
    </div>

    {{-- ========================= --}}
    {{-- Modal Create / Edit --}}
    {{-- ========================= --}}
    <div x-data="{ show: @entangle('modal') }" x-show="show" x-on:keydown.escape.window="show = false" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" x-cloak>
        <div @click="show = false" class="absolute inset-0"></div>
        <div class="relative w-full max-w-2xl p-6 bg-white rounded-lg shadow-lg" @click.stop>
            <form wire:submit.prevent="save">
                <h3 class="text-2xl font-semibold text-unmaris-blue mb-4">
                    {{ $annId ? 'Edit Pengumuman' : 'Tambah Pengumuman Baru' }}
                </h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Judul</label>
                        <input type="text" wire:model="title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Konten Pengumuman</label>
                        {{-- Menggunakan textarea. Untuk editor WYSIWYG, Anda perlu integrasi tambahan. --}}
                        <textarea wire:model="content" rows="6" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                        @error('content') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
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
                    Anda yakin ingin menghapus pengumuman:
                    <span class="font-bold block">{{ $deletingAnnTitle }}</span>?
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
