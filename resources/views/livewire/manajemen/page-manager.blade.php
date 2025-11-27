<div>
    <x-slot:header>Manajemen Halaman Statis</x-slot:header>

    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tombol Aksi -->
    <div class="mb-4 flex justify-between items-center">
        <button wire:click="openCreateModal"
            class="bg-unmaris-yellow text-unmaris-blue font-bold py-2 px-4 rounded hover:bg-yellow-400 shadow-sm">
            + Tambah Halaman Baru
        </button>

        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari halaman..."
            class="border-gray-300 rounded-md shadow-sm w-1/3">
    </div>

    <!-- Tabel Data Responsif -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Judul
                        Halaman</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Slug (URL)
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($pages as $page)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                            {{ $page->title }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono bg-gray-50">
                            /p/{{ $page->slug }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $page->status == 'Published' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $page->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button wire:click="openEditModal({{ $page->id }})"
                                class="text-indigo-600 hover:text-indigo-900 font-bold">Edit</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">
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
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" x-data
            @click.self="$wire.set('showModal', false)">

            <div class="relative w-full max-w-4xl p-6 bg-white rounded-xl shadow-2xl">
                <div class="flex justify-between items-center border-b pb-4 mb-4">
                    <h3 class="text-2xl font-bold text-unmaris-blue">
                        {{ $isEditing ? 'Edit Halaman' : 'Tambah Halaman Baru' }}
                    </h3>
                    <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600"><i
                            class="fas fa-times text-xl"></i></button>
                </div>

                <form wire:submit="save">
                    <div class="space-y-5 max-h-[70vh] overflow-y-auto pr-2">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Judul Halaman</label>
                                <input type="text" wire:model.live="title"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                                @error('title')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">URL Slug</label>
                                <div class="flex items-center">
                                    <span
                                        class="bg-gray-100 p-2 border border-r-0 border-gray-300 rounded-l-lg text-gray-500 text-sm">/p/</span>
                                    <input type="text" wire:model="slug"
                                        class="w-full border-gray-300 rounded-r-lg shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow font-mono text-sm">
                                </div>
                                @error('slug')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- TRIX EDITOR (FIXED) -->
                        <!-- TRIX EDITOR (FIXED & ROBUST) -->
                        <div wire:ignore x-data="{
                            trixContent: @entangle('content').live
                        }" x-init="// Tunggu sebentar agar elemen Trix siap di DOM
                        $nextTick(() => {
                            if ($refs.trix.editor) {
                                // Load konten awal dari Livewire ke Editor
                                $refs.trix.editor.loadHTML(trixContent);
                            }
                        });" class="space-y-1">
                            <label class="block text-sm font-bold text-gray-700">Konten</label>

                            {{-- Input Hidden untuk sinkronisasi form --}}
                            <input id="content_input" type="hidden" wire:model="content" value="{{ $content }}">

                            <trix-editor input="content_input" x-ref="trix"
                                class="trix-content min-h-[300px] border-gray-300 rounded-lg shadow-sm focus:border-unmaris-yellow focus:ring-unmaris-yellow"
                                x-on:trix-change="trixContent = $event.target.value"></trix-editor>

                            @error('content')
                                <span class="text-red-500 text-xs font-bold">{{ $message }}</span>
                            @enderror
                            <p class="text-xs text-gray-400 mt-1">*Gunakan toolbar di atas editor untuk memformat teks
                                (Bold, List, Link, dll).</p>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Status</label>
                            <select wire:model="status"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                                <option value="Published">Publikasikan (Published)</option>
                                <option value="Draft">Simpan sebagai Draft</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-4 border-t pt-4">
                        <button type="button" wire:click="closeModal"
                            class="bg-gray-200 text-gray-700 font-bold py-2 px-6 rounded-lg hover:bg-gray-300 transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="bg-unmaris-blue text-white font-bold py-2 px-6 rounded-lg hover:bg-blue-800 transition flex items-center shadow-md">
                            <span wire:loading.remove wire:target="save">Simpan Halaman</span>
                            <span wire:loading wire:target="save">
                                <i class="fas fa-spinner animate-spin mr-2"></i> Menyimpan...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
<script>
    (function() {
        var HOST = "{{ route('admin.trix.upload') }}"; // Route Upload yang sudah kita buat

        addEventListener("trix-attachment-add", function(event) {
            if (event.attachment.file) {
                uploadFileAttachment(event.attachment)
            }
        })

        function uploadFileAttachment(attachment) {
            uploadFile(attachment.file, setProgress, setAttributes)

            function setProgress(progress) {
                attachment.setUploadProgress(progress)
            }

            function setAttributes(attributes) {
                attachment.setAttributes(attributes)
            }
        }

        function uploadFile(file, progressCallback, successCallback) {
            var formData = new FormData()
            var xhr = new XMLHttpRequest()

            // Ambil CSRF Token dari meta tag
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            formData.append("file", file)
            formData.append("_token", csrfToken)

            xhr.open("POST", HOST, true)
            xhr.setRequestHeader("X-CSRF-TOKEN", csrfToken)

            xhr.upload.addEventListener("progress", function(event) {
                var progress = event.loaded / event.total * 100
                progressCallback(progress)
            })

            xhr.addEventListener("load", function(event) {
                if (xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText)
                    successCallback({
                        url: response.url,
                        href: response.url
                    })
                } else {
                    console.error("Upload failed:", xhr.statusText);
                }
            })

            xhr.send(formData)
        }
    })();
</script>
