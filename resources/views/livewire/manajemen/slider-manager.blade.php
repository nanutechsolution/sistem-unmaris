<div class="p-6">
    <x-slot:header>Manajemen Hero Slider</x-slot:header>

    @if (session()->has('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
        {{ session('success') }}
    </div>
    @endif
    
    {{-- Pesan Error Authorization --}}
    @if (session()->has('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
        {{ session('error') }}
    </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        {{-- PROTEKSI TOMBOL TAMBAH --}}
        @can('manage_sliders')
            <button wire:click="create" class="bg-unmaris-blue text-white font-bold py-2 px-4 rounded hover:bg-blue-800 shadow-md transition">
                + Tambah Slide Baru
            </button>
        @else
            <button disabled class="bg-gray-300 text-gray-500 font-bold py-2 px-4 rounded cursor-not-allowed" title="Anda tidak memiliki akses">
                + Tambah Slide Baru (Terkunci)
            </button>
        @endcan

        <span class="text-sm text-gray-500 italic">*Urutkan tampilan berdasarkan nomor urut (Order).</span>
    </div>

    {{-- GRID CARD --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($sliders as $item)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden group hover:shadow-md transition relative">
            
            {{-- Preview Media (List) --}}
            <div class="h-48 bg-gray-100 relative group-hover:z-10">
                @if($item->type == 'video')
                    <video class="w-full h-full object-cover bg-black" controls preload="metadata" poster="{{ $item->poster_path ? asset('storage/'.$item->poster_path) : '' }}">
                        <source src="{{ asset('storage/'.$item->file_path) }}" type="video/mp4">
                        Browser tidak support.
                    </video>
                    <span class="absolute top-2 right-2 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded shadow pointer-events-none">VIDEO</span>
                @else
                    <img src="{{ asset('storage/'.$item->file_path) }}" class="w-full h-full object-cover">
                    <span class="absolute top-2 right-2 bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded shadow pointer-events-none">IMAGE</span>
                @endif

                <div class="absolute top-2 left-2 z-20">
                    {{-- PROTEKSI TOGGLE ACTIVE --}}
                    @can('manage_sliders')
                        <button wire:click="toggleActive({{ $item->id }})" 
                                class="px-2 py-1 rounded text-xs font-bold shadow transition {{ $item->active ? 'bg-green-500 text-white' : 'bg-gray-400 text-white hover:bg-green-500' }}">
                            {{ $item->active ? 'AKTIF' : 'NON-AKTIF' }}
                        </button>
                    @else
                        <span class="px-2 py-1 rounded text-xs font-bold shadow cursor-not-allowed {{ $item->active ? 'bg-green-500 text-white' : 'bg-gray-400 text-white' }}">
                            {{ $item->active ? 'AKTIF' : 'NON-AKTIF' }}
                        </span>
                    @endcan
                </div>
            </div>

            {{-- Konten --}}
            <div class="p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <h4 class="font-bold text-gray-800 line-clamp-1" title="{{ strip_tags($item->title) }}">
                            {!! $item->title ?? 'Tanpa Judul' !!}
                        </h4>
                        <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $item->description ?? 'Tanpa Deskripsi' }}</p>
                    </div>
                    <div class="text-center bg-gray-100 px-2 py-1 rounded ml-2">
                        <span class="block text-[10px] text-gray-400 uppercase">Order</span>
                        <span class="font-bold text-gray-700">{{ $item->order }}</span>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t flex justify-between items-center">
                    @if($item->button_text)
                        <span class="text-xs bg-blue-50 text-blue-600 px-2 py-1 rounded border border-blue-100 truncate max-w-[150px]">
                            BTN: {{ $item->button_text }}
                        </span>
                    @else
                        <span class="text-xs text-gray-300 italic">No Button</span>
                    @endif

                    <div class="space-x-2">
                        {{-- PROTEKSI TOMBOL EDIT & HAPUS --}}
                        @can('manage_sliders')
                            <button wire:click="edit({{ $item->id }})" class="text-gray-400 hover:text-unmaris-blue transition"><i class="fas fa-edit"></i></button>
                            <button wire:click="confirmDelete({{ $item->id }})" class="text-gray-400 hover:text-red-600 transition"><i class="fas fa-trash"></i></button>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- MODAL FORM --}}
    @if($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4 backdrop-blur-sm" x-data @click.self="$wire.set('showModal', false)">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <div class="px-6 py-4 border-b flex justify-between items-center sticky top-0 bg-white z-10">
                <h3 class="text-xl font-bold text-gray-800">{{ $isEditing ? 'Edit Slider' : 'Tambah Slider Baru' }}</h3>
                <button wire:click="$set('showModal', false)" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
            </div>
            
            <form wire:submit="save" class="p-6 space-y-6">
                
                {{-- Tipe Media --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Tipe Media</label>
                    <div class="flex space-x-4">
                        <label class="cursor-pointer">
                            <input type="radio" wire:model.live="type" value="image" class="peer sr-only">
                            <div class="px-4 py-2 rounded-lg border-2 text-center transition peer-checked:border-unmaris-blue peer-checked:bg-blue-50 peer-checked:text-unmaris-blue">
                                <i class="fas fa-image mb-1 block"></i> Gambar
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" wire:model.live="type" value="video" class="peer sr-only">
                            <div class="px-4 py-2 rounded-lg border-2 text-center transition peer-checked:border-unmaris-blue peer-checked:bg-blue-50 peer-checked:text-unmaris-blue">
                                <i class="fas fa-video mb-1 block"></i> Video
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Upload Area --}}
                <div
                    x-data="{ isUploading: false, progress: 0 }"
                    x-on:livewire-upload-start="isUploading = true"
                    x-on:livewire-upload-finish="isUploading = false"
                    x-on:livewire-upload-error="isUploading = false"
                    x-on:livewire-upload-progress="progress = $event.detail.progress"
                    class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:bg-gray-50 transition relative bg-gray-50/50"
                >
                    <div x-show="isUploading" class="absolute inset-0 bg-white/90 flex flex-col items-center justify-center z-20 px-10">
                        <div class="w-full bg-gray-200 rounded-full h-4 mb-2 overflow-hidden">
                            <div class="bg-unmaris-blue h-4 rounded-full transition-all duration-300" :style="'width: ' + progress + '%'"></div>
                        </div>
                        <span class="text-sm font-bold text-unmaris-blue" x-text="'Mengupload... ' + progress + '%'"></span>
                    </div>

                    @if ($file_upload)
                        @php $tempUrl = $this->getSafeTemporaryUrl($file_upload); @endphp
                        @if($tempUrl)
                            <p class="text-green-600 text-sm font-bold mb-2 bg-green-100 inline-block px-2 py-1 rounded"><i class="fas fa-check"></i> Siap Disimpan</p>
                            @if($type == 'image')
                                <img src="{{ $tempUrl }}" class="h-48 mx-auto rounded shadow object-cover">
                            @elseif($type == 'video')
                                <video controls class="h-48 mx-auto rounded shadow bg-black w-full">
                                    <source src="{{ $tempUrl }}" type="video/mp4">
                                </video>
                            @endif
                        @else
                            <div class="text-yellow-600 py-4"><p class="font-bold">File terpilih</p></div>
                        @endif
                    @elseif ($old_file_path)
                        <p class="text-gray-500 text-xs mb-2 font-bold uppercase tracking-wider">File Saat Ini:</p>
                        @if($type == 'image')
                            <img src="{{ asset('storage/'.$old_file_path) }}" class="h-48 mx-auto rounded shadow object-cover">
                        @else
                            <video controls class="h-48 mx-auto rounded shadow bg-black w-full">
                                <source src="{{ asset('storage/'.$old_file_path) }}" type="video/mp4">
                            </video>
                        @endif
                    @else
                        <div class="text-gray-400 py-8">
                            <i class="fas fa-cloud-upload-alt text-5xl mb-3 text-gray-300"></i>
                            <p class="text-sm font-medium text-gray-600">Klik untuk pilih {{ $type == 'video' ? 'Video' : 'Gambar' }}</p>
                        </div>
                    @endif
                    
                    <input type="file" wire:model="file_upload" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                </div>

                {{-- INPUT JUDUL TERPISAH (User Friendly) --}}
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <label class="block text-sm font-bold text-gray-700 mb-3">Pengaturan Teks Judul</label>
                    
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="text-xs font-bold text-gray-500 uppercase">Baris 1 (Teks Putih)</label>
                            <input type="text" wire:model="title_1" placeholder="Contoh: Masa Depan" class="w-full border-gray-300 rounded-md shadow-sm mt-1 focus:ring-unmaris-blue">
                            @error('title_1') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="text-xs font-bold text-unmaris-yellow uppercase bg-unmaris-blue px-2 py-0.5 rounded inline-block">Baris 2 (Teks Kuning)</label>
                            <input type="text" wire:model="title_2" placeholder="Contoh: Dimulai Di Sini" class="w-full border-gray-300 rounded-md shadow-sm mt-1 focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                            <p class="text-[10px] text-gray-400 mt-1">*Teks ini akan otomatis diberi warna kuning.</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700">Deskripsi Singkat</label>
                        <textarea wire:model="description" rows="3" class="w-full border-gray-300 rounded-md shadow-sm mt-1 focus:ring-unmaris-blue"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700">Urutan (Order)</label>
                        <input type="number" wire:model="order" class="w-full border-gray-300 rounded-md shadow-sm mt-1 focus:ring-unmaris-blue">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <div>
                        <label class="block text-sm font-bold text-gray-700">Teks Tombol</label>
                        <input type="text" wire:model="button_text" placeholder="Misal: Daftar Sekarang" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700">Link Tombol</label>
                        <input type="text" wire:model="button_url" placeholder="Misal: /pmb" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t">
                    <button type="button" wire:click="$set('showModal', false)" class="bg-gray-200 px-4 py-2 rounded-lg font-bold hover:bg-gray-300">Batal</button>
                    <button type="submit" class="bg-unmaris-blue text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-800 flex items-center shadow-md" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="save">Simpan Slider</span>
                        <span wire:loading wire:target="save">Menyimpan...</span>
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
            <h3 class="text-lg font-bold text-red-600 mb-2">Hapus Slider Ini?</h3>
            <p class="text-gray-600 text-sm mb-6">File gambar/video akan ikut terhapus dari server.</p>
            <div class="flex justify-center gap-4">
                <button wire:click="$set('showDeleteModal', false)" class="bg-gray-200 px-4 py-2 rounded-lg font-bold text-sm hover:bg-gray-300">Batal</button>
                <button wire:click="delete" class="bg-red-600 text-white px-4 py-2 rounded-lg font-bold text-sm hover:bg-red-700">Ya, Hapus</button>
            </div>
        </div>
    </div>
    @endif

</div>