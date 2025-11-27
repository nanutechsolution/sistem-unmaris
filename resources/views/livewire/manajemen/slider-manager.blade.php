<div class="p-6">
    <x-slot:header>Manajemen Hero Slider</x-slot:header>

    @if (session()->has('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
        {{ session('success') }}
    </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <button wire:click="create" class="bg-unmaris-blue text-white font-bold py-2 px-4 rounded hover:bg-blue-800 shadow-md transition">
            + Tambah Slide Baru
        </button>
        <span class="text-sm text-gray-500 italic">*Urutkan tampilan berdasarkan nomor urut (Order).</span>
    </div>

    {{-- GRID CARD --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($sliders as $item)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden group hover:shadow-md transition relative">
            
            {{-- Preview Media (List) --}}
            <div class="h-48 bg-gray-100 relative group-hover:z-10">
                @if($item->type == 'video')
                    {{-- UPDATE: Tambah 'controls' dan hapus opacity --}}
                    <video class="w-full h-full object-cover bg-black" controls preload="metadata" poster="{{ $item->poster_path ? asset('storage/'.$item->poster_path) : '' }}">
                        <source src="{{ asset('storage/'.$item->file_path) }}" type="video/mp4">
                        Browser tidak support.
                    </video>
                    {{-- Overlay icon dihapus biar tombol play asli bisa diklik --}}
                    
                    <span class="absolute top-2 right-2 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded shadow pointer-events-none">VIDEO</span>
                @else
                    <img src="{{ asset('storage/'.$item->file_path) }}" class="w-full h-full object-cover">
                    <span class="absolute top-2 right-2 bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded shadow pointer-events-none">IMAGE</span>
                @endif

                {{-- Status Badge --}}
                <div class="absolute top-2 left-2 z-20">
                    <button wire:click="toggleActive({{ $item->id }})" 
                            class="px-2 py-1 rounded text-xs font-bold shadow transition {{ $item->active ? 'bg-green-500 text-white' : 'bg-gray-400 text-white hover:bg-green-500' }}">
                        {{ $item->active ? 'AKTIF' : 'NON-AKTIF' }}
                    </button>
                </div>
            </div>

            {{-- Konten --}}
            <div class="p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <h4 class="font-bold text-gray-800 line-clamp-1" title="{{ $item->title }}">{!! strip_tags($item->title ?? 'Tanpa Judul') !!}</h4>
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
                        <button wire:click="edit({{ $item->id }})" class="text-gray-400 hover:text-unmaris-blue transition"><i class="fas fa-edit"></i></button>
                        <button wire:click="confirmDelete({{ $item->id }})" class="text-gray-400 hover:text-red-600 transition"><i class="fas fa-trash"></i></button>
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
                
                {{-- Pilihan Tipe File --}}
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
                    {{-- Progress Bar --}}
                    <div x-show="isUploading" class="absolute inset-0 bg-white/90 flex flex-col items-center justify-center z-20 px-10">
                        <div class="w-full bg-gray-200 rounded-full h-4 mb-2 overflow-hidden">
                            <div class="bg-unmaris-blue h-4 rounded-full transition-all duration-300" :style="'width: ' + progress + '%'"></div>
                        </div>
                        <span class="text-sm font-bold text-unmaris-blue" x-text="'Mengupload... ' + progress + '%'"></span>
                    </div>

                    {{-- Loading Processing --}}
                    <div wire:loading wire:target="file_upload" class="absolute inset-0 bg-white/80 flex flex-col items-center justify-center z-20">
                        <svg class="animate-spin h-8 w-8 text-unmaris-blue mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <span class="text-sm font-bold text-gray-600">Memproses file...</span>
                    </div>

                    {{-- Preview Area --}}
                    @if ($file_upload)
                        @php $tempUrl = $this->getSafeTemporaryUrl($file_upload); @endphp
                        @if($tempUrl)
                            <p class="text-green-600 text-sm font-bold mb-2 bg-green-100 inline-block px-2 py-1 rounded"><i class="fas fa-check"></i> File Siap Disimpan</p>
                            @if($type == 'image')
                                <img src="{{ $tempUrl }}" class="h-48 mx-auto rounded shadow object-cover">
                            @elseif($type == 'video')
                                <video controls class="h-48 mx-auto rounded shadow bg-black w-full">
                                    <source src="{{ $tempUrl }}" type="video/mp4">
                                </video>
                            @endif
                        @else
                            <div class="text-yellow-600 py-4">
                                <i class="fas fa-file-video text-4xl mb-2"></i>
                                <p class="font-bold">File terpilih: {{ $file_upload->getClientOriginalName() }}</p>
                                <p class="text-xs mt-1">Preview tidak tersedia, tapi file bisa disimpan.</p>
                            </div>
                        @endif
                    @elseif ($old_file_path)
                        <p class="text-gray-500 text-xs mb-2 font-bold uppercase tracking-wider">File Saat Ini:</p>
                        @if($type == 'image')
                            <img src="{{ asset('storage/'.$old_file_path) }}" class="h-48 mx-auto rounded shadow object-cover">
                        @else
                            {{-- Preview Video Lama --}}
                            <video controls class="h-48 mx-auto rounded shadow bg-black w-full">
                                <source src="{{ asset('storage/'.$old_file_path) }}" type="video/mp4">
                            </video>
                        @endif
                    @else
                        <div class="text-gray-400 py-8">
                            <i class="fas fa-cloud-upload-alt text-5xl mb-3 text-gray-300"></i>
                            <p class="text-sm font-medium text-gray-600">Klik untuk pilih {{ $type == 'video' ? 'Video (MP4/M4V)' : 'Gambar (JPG/PNG)' }}</p>
                            <p class="text-xs text-gray-400 mt-1">Max: 2GB (Video), 10MB (Gambar)</p>
                        </div>
                    @endif
                    
                    <input type="file" wire:model="file_upload" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                    @error('file_upload') <div class="absolute bottom-2 left-0 right-0 text-center"><span class="text-red-500 text-xs bg-red-100 px-2 py-1 rounded font-bold">{{ $message }}</span></div> @enderror
                </div>

                {{-- Poster Video --}}
                @if($type == 'video')
                <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200 relative">
                    <div wire:loading wire:target="poster_upload" class="absolute inset-0 bg-white/50 flex items-center justify-center z-20 rounded-lg"><span class="text-xs font-bold text-yellow-800">Mengupload poster...</span></div>
                    <label class="block text-sm font-bold text-yellow-800 mb-1">Cover Video (Poster)</label>
                    <p class="text-xs text-yellow-600 mb-3">Gambar ini muncul sebelum video diputar. (Opsional)</p>
                    <div class="flex items-start gap-4">
                        @if ($poster_upload)
                            @php $posterUrl = $this->getSafeTemporaryUrl($poster_upload); @endphp
                            @if($posterUrl) <img src="{{ $posterUrl }}" class="h-20 w-32 object-cover rounded border border-yellow-300 shadow-sm"> @endif
                        @elseif ($old_poster_path)
                            <img src="{{ asset('storage/'.$old_poster_path) }}" class="h-20 w-32 object-cover rounded border border-yellow-300 shadow-sm">
                        @else
                            <div class="h-20 w-32 bg-yellow-100 rounded border border-yellow-200 flex items-center justify-center text-yellow-400"><i class="fas fa-image text-2xl"></i></div>
                        @endif
                        <input type="file" wire:model="poster_upload" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-white file:text-yellow-700 hover:file:bg-yellow-100 cursor-pointer">
                    </div>
                </div>
                @endif

                {{-- Judul & Order --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700">Judul Utama (HTML Support)</label>
                        <input type="text" wire:model="title" placeholder="Contoh: Masa Depan <br> Dimulai Disini" class="w-full border-gray-300 rounded-md shadow-sm mt-1 focus:ring-unmaris-blue">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700">Urutan (Order)</label>
                        <input type="number" wire:model="order" class="w-full border-gray-300 rounded-md shadow-sm mt-1 focus:ring-unmaris-blue">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700">Deskripsi Singkat</label>
                    <textarea wire:model="description" rows="2" class="w-full border-gray-300 rounded-md shadow-sm mt-1 focus:ring-unmaris-blue"></textarea>
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
                        <span wire:loading wire:target="save"><svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Menyimpan...</span>
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