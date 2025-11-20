<div>
    <x-slot:header>Manajemen Banner Depan</x-slot:header>

    <div class="mb-4">
        <button wire:click="openCreateModal" class="bg-unmaris-yellow text-unmaris-blue font-bold py-2 px-4 rounded hover:bg-yellow-400">
            + Tambah Banner
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($sliders as $slider)
            <div class="bg-white shadow-md rounded-lg overflow-hidden relative group">
                <img src="{{ Storage::url($slider->image_path) }}" class="w-full h-48 object-cover">
                
                <!-- Overlay Info -->
                <div class="p-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-bold text-lg text-gray-800">{{ $slider->title ?? '(Tanpa Judul)' }}</h3>
                            <p class="text-sm text-gray-500">{{ Str::limit($slider->description, 50) }}</p>
                        </div>
                        <span class="px-2 text-xs rounded-full {{ $slider->active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $slider->active ? 'Aktif' : 'Non-Aktif' }}
                        </span>
                    </div>
                    <div class="mt-2 text-xs text-gray-400">Urutan: {{ $slider->order }}</div>
                </div>

                <!-- Tombol Aksi -->
                <div class="absolute top-2 right-2 hidden group-hover:flex space-x-2">
                    <button wire:click="openEditModal({{ $slider->id }})" class="bg-white text-indigo-600 p-2 rounded shadow hover:bg-gray-100">
                        Edit
                    </button>
                    <button wire:click="delete({{ $slider->id }})" class="bg-white text-red-600 p-2 rounded shadow hover:bg-gray-100" onclick="return confirm('Hapus banner ini?') || event.stopImmediatePropagation()">
                        Hapus
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <!-- MODAL FORM -->
    <div x-data="{ show: @entangle('showModal') }" x-show="show" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <div class="bg-white w-full max-w-lg rounded-lg shadow-lg p-6 relative max-h-[90vh] overflow-y-auto">
            <button @click="show = false" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">&times;</button>
            
            <h3 class="text-xl font-bold mb-4">{{ $isEditing ? 'Edit Banner' : 'Tambah Banner Baru' }}</h3>
            
            <form wire:submit="save" class="space-y-4">
                <!-- Gambar -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Gambar Background</label>
                    <input type="file" wire:model="image" class="mt-1 block w-full text-sm text-gray-500">
                    @error('image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    
                    @if ($image)
                        <img src="{{ $image->temporaryUrl() }}" class="mt-2 h-32 w-full object-cover rounded">
                    @elseif ($existing_image)
                        <img src="{{ Storage::url($existing_image) }}" class="mt-2 h-32 w-full object-cover rounded">
                    @endif
                </div>

                <!-- Judul -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Judul (Headline)</label>
                    <input type="text" wire:model="title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                    @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Deskripsi (Sub-headline)</label>
                    <textarea wire:model="description" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow"></textarea>
                    @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Teks Tombol -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Teks Tombol</label>
                        <input type="text" wire:model="button_text" placeholder="Misal: Daftar" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                        @error('button_text') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <!-- URL Tombol -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Link Tombol</label>
                        <input type="url" wire:model="button_url" placeholder="https://..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                        @error('button_url') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <!-- Urutan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Urutan</label>
                        <input type="number" wire:model="order" class="mt-1 block w-20 border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                        @error('order') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                    </div>
                    <!-- Aktif -->
                    <div class="flex items-center mt-6">
                        <input type="checkbox" wire:model="active" id="active" class="h-4 w-4 text-unmaris-blue border-gray-300 rounded focus:ring-unmaris-yellow">
                        <label for="active" class="ml-2 block text-sm text-gray-900">Aktifkan Banner</label>
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="button" wire:click="closeModal" class="mr-2 px-4 py-2 text-gray-700 bg-gray-200 rounded hover:bg-gray-300">Batal</button>
                    <button type="submit" class="px-4 py-2 text-white bg-unmaris-blue rounded hover:bg-unmaris-blue/90">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>