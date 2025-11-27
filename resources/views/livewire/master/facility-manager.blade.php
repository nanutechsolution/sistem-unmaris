<div class="p-6">
    <x-slot:header>Manajemen Fasilitas Kampus</x-slot:header>

    @if (session()->has('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">{{ session('success') }}</div>
    @endif

    <div class="flex justify-between mb-6">
        <button wire:click="create" class="bg-unmaris-blue text-white px-4 py-2 rounded font-bold shadow hover:bg-blue-800">+ Tambah Fasilitas</button>
        <input type="text" wire:model.live.debounce="search" placeholder="Cari fasilitas..." class="border-gray-300 rounded-md shadow-sm">
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($facilities as $item)
        <div class="bg-white rounded-xl shadow-sm border overflow-hidden group relative">
            <img src="{{ $item->image_url }}" class="h-48 w-full object-cover">
            <div class="absolute top-2 right-2 bg-white/90 px-2 py-1 rounded text-xs font-bold text-unmaris-blue">{{ $item->category }}</div>
            <div class="p-4">
                <h4 class="font-bold text-lg text-gray-800">{{ $item->name }}</h4>
                <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $item->description }}</p>
                <div class="mt-4 flex justify-end gap-2">
                    <button wire:click="edit({{ $item->id }})" class="text-blue-600 hover:underline text-sm">Edit</button>
                    <button wire:click="confirmDelete({{ $item->id }})" class="text-red-600 hover:underline text-sm">Hapus</button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- MODAL FORM --}}
    @if($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" x-data @click.self="$wire.set('showModal', false)">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-lg p-6 max-h-[90vh] overflow-y-auto">
            <h3 class="text-lg font-bold mb-4">{{ $isEditing ? 'Edit' : 'Tambah' }} Fasilitas</h3>
            <form wire:submit="save" class="space-y-4">
                
                <!-- Upload Image -->
                <div class="border-2 border-dashed p-4 rounded text-center">
                    @if($image) <img src="{{ $image->temporaryUrl() }}" class="h-32 mx-auto rounded mb-2">
                    @elseif($old_image) <img src="{{ asset('storage/'.$old_image) }}" class="h-32 mx-auto rounded mb-2">
                    @endif
                    <input type="file" wire:model="image" class="text-sm">
                    @error('image') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold mb-1">Nama Fasilitas</label>
                    <input type="text" wire:model="name" class="w-full border-gray-300 rounded-md">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold mb-1">Kategori</label>
                        <select wire:model="category" class="w-full border-gray-300 rounded-md">
                            <option>Gedung</option>
                            <option>Laboratorium</option>
                            <option>Olahraga</option>
                            <option>Penunjang</option>
                            <option>Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-1">Urutan</label>
                        <input type="number" wire:model="order" class="w-full border-gray-300 rounded-md">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold mb-1">Deskripsi</label>
                    <textarea wire:model="description" rows="3" class="w-full border-gray-300 rounded-md"></textarea>
                </div>

                <div class="flex justify-end gap-2 pt-4">
                    <button type="button" wire:click="$set('showModal', false)" class="bg-gray-200 px-4 py-2 rounded">Batal</button>
                    <button type="submit" class="bg-unmaris-blue text-white px-4 py-2 rounded hover:bg-blue-800">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>