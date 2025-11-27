<div class="p-6">
    <x-slot:header>Manajemen Dokumen & Arsip</x-slot:header>

    @if (session()->has('success'))
        <div
            class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 shadow-sm flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <button wire:click="create"
            class="bg-unmaris-blue text-white font-bold py-2 px-4 rounded hover:bg-blue-800 shadow-md transition flex items-center">
            <i class="fas fa-cloud-upload-alt mr-2"></i> Upload Dokumen
        </button>

        <div class="relative w-full md:w-1/3">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari judul dokumen..."
                class="border-gray-300 rounded-md shadow-sm w-full pl-10 focus:ring-unmaris-yellow focus:border-unmaris-yellow transition">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
        </div>
    </div>

    {{-- TABEL DATA --}}
    <div class="bg-white shadow-md rounded-lg overflow-hidden overflow-x-auto border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Dokumen
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kategori
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Akses</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Info File
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($documents as $doc)
                    <tr class="hover:bg-blue-50/30 transition group">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div
                                    class="flex-shrink-0 h-10 w-10 bg-gray-100 rounded-lg flex items-center justify-center text-lg">
                                    {{-- Icon Dinamis dari Model --}}
                                    <i class="{{ $doc->icon }}"></i>
                                </div>
                                <div class="ml-4">
                                    <div
                                        class="text-sm font-bold text-gray-900 group-hover:text-unmaris-blue transition">
                                        {{ $doc->judul }}</div>
                                    <div class="text-xs text-gray-500 truncate max-w-xs">
                                        {{ Str::limit($doc->deskripsi, 50) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 border border-gray-200">
                                {{ $doc->kategori->nama ?? 'Umum' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $accessColor = match ($doc->akses) {
                                    'Publik' => 'bg-green-100 text-green-800 border-green-200',
                                    'Mahasiswa' => 'bg-blue-100 text-blue-800 border-blue-200',
                                    'Dosen' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                    'Admin' => 'bg-red-100 text-red-800 border-red-200',
                                };
                            @endphp
                            <span
                                class="px-2 py-1 inline-flex text-[10px] uppercase font-bold rounded border {{ $accessColor }}">
                                {{ $doc->akses }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                            <div>{{ strtoupper($doc->file_type) }} • {{ $doc->size_label }}</div> {{-- size_label dari accessor model --}}
                            <div class="mt-1 font-bold text-gray-400"><i class="fas fa-download mr-1"></i>
                                {{ $doc->download_count }}x</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ $doc->url }}" target="_blank"
                                class="text-blue-600 hover:text-blue-900 mr-3" title="Download / Preview">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                            <button wire:click="delete({{ $doc->id }})"
                                onclick="confirm('Yakin ingin menghapus dokumen ini?') || event.stopImmediatePropagation()"
                                class="text-red-600 hover:text-red-900" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <i class="far fa-folder-open text-4xl mb-2 text-gray-300"></i>
                                <p>Belum ada dokumen yang diunggah.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $documents->links() }}
    </div>

    {{-- MODAL UPLOAD --}}
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4 backdrop-blur-sm" x-data
            @click.self="$wire.set('showModal', false)">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg overflow-hidden">
                <div class="px-6 py-4 border-b bg-gray-50 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">Upload Dokumen Baru</h3>
                    <button wire:click="$set('showModal', false)" class="text-gray-400 hover:text-gray-600"><i
                            class="fas fa-times"></i></button>
                </div>

                <form wire:submit="save" class="p-6 space-y-5">

                    {{-- Judul --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Judul Dokumen</label>
                        <input type="text" wire:model="judul" placeholder="Contoh: Kalender Akademik 2025"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-blue focus:border-unmaris-blue">
                        @error('judul')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Kategori & Akses --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Kategori</label>
                            <select wire:model="kategori_id"
                                class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                                <option value="">-- Pilih --</option>
                                @foreach ($kategoris as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->nama }}</option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Hak Akses</label>
                            <select wire:model="akses" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                                <option value="Publik">Publik (Website)</option>
                                <option value="Mahasiswa">Mahasiswa (Portal)</option>
                                <option value="Dosen">Dosen (Portal)</option>
                                <option value="Admin">Internal Admin</option>
                            </select>
                            <p class="text-[10px] text-gray-500 mt-1">*Hanya 'Publik' yang muncul di web depan.</p>
                            @error('akses')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Deskripsi Singkat</label>
                        <textarea wire:model="deskripsi" rows="2" class="w-full border-gray-300 rounded-md shadow-sm text-sm"></textarea>
                    </div>

                    {{-- Upload Area --}}
                    <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
                        x-on:livewire-upload-finish="isUploading = false"
                        x-on:livewire-upload-error="isUploading = false"
                        x-on:livewire-upload-progress="progress = $event.detail.progress">

                        <label class="block text-sm font-bold text-gray-700 mb-2">File Dokumen (PDF/Docx/Xlsx)</label>

                        <div
                            class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:bg-gray-50 transition">
                            <input type="file" wire:model="file_upload"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">

                            <div x-show="!isUploading">
                                @if ($file_upload)
                                    <p class="text-green-600 text-sm font-bold"><i class="fas fa-check-circle"></i>
                                        File Terpilih: {{ $file_upload->getClientOriginalName() }}</p>
                                @else
                                    <div class="text-gray-400">
                                        <i class="fas fa-file-upload text-3xl mb-2"></i>
                                        <p class="text-sm">Klik untuk memilih file (Max 20MB)</p>
                                    </div>
                                @endif
                            </div>

                            {{-- Progress Bar --}}
                            <div x-show="isUploading" class="w-full">
                                <div class="w-full bg-gray-200 rounded-full h-2.5 mb-1">
                                    <div class="bg-unmaris-blue h-2.5 rounded-full transition-all duration-300"
                                        :style="'width: ' + progress + '%'"></div>
                                </div>
                                <p class="text-xs text-gray-500">Mengupload... <span x-text="progress + '%'"></span>
                                </p>
                            </div>
                        </div>
                        @error('file_upload')
                            <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="pt-4 flex justify-end gap-3 border-t">
                        <button type="button" wire:click="$set('showModal', false)"
                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-bold hover:bg-gray-300 text-sm">Batal</button>

                        <button type="submit"
                            class="bg-unmaris-blue text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-800 text-sm flex items-center"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="save">Upload & Simpan</span>
                            <span wire:loading wire:target="save">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Memproses...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
