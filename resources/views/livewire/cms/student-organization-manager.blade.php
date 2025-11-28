<div class="p-6">
    <x-slot:header>Manajemen Organisasi Mahasiswa (UKM)</x-slot:header>
    <div class="flex justify-between items-center mb-6">
        <button wire:click="create"
            class="bg-unmaris-blue text-white font-bold py-2 px-4 rounded hover:bg-blue-800 shadow-md transition">
            + Tambah UKM
        </button>
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari UKM..."
            class="border-gray-300 rounded-md shadow-sm w-1/3">
    </div>
    {{-- GRID VIEW --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($organizations as $ukm)
            <div
                class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden group hover:shadow-md transition relative">

                {{-- Header Warna --}}
                <div class="h-2 {{ $ukm->warna }}"></div>

                <div class="p-5">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            {{-- Icon / Logo --}}
                            <div
                                class="w-12 h-12 rounded-lg {{ $ukm->warna }} text-white flex items-center justify-center text-xl shadow-sm">
                                @if ($ukm->logo)
                                    <img src="{{ Storage::url($ukm->logo) }}"
                                        class="w-full h-full object-cover rounded-lg">
                                @else
                                    <i class="{{ $ukm->icon }}"></i>
                                @endif
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 leading-tight">{{ $ukm->nama }}</h4>
                                <span
                                    class="text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded mt-1 inline-block">{{ $ukm->kategori }}</span>
                            </div>
                        </div>

                        {{-- Status Badge --}}
                        <span class="w-3 h-3 rounded-full {{ $ukm->is_active ? 'bg-green-500' : 'bg-gray-300' }}"
                            title="{{ $ukm->is_active ? 'Aktif' : 'Non-Aktif' }}"></span>
                    </div>

                    <p class="text-gray-600 text-sm mt-4 line-clamp-2">
                        {{ $ukm->deskripsi }}
                    </p>

                    <div class="mt-4 pt-4 border-t flex justify-end gap-2">
                        <button wire:click="edit({{ $ukm->id }})"
                            class="text-sm text-indigo-600 font-bold hover:underline">Edit</button>
                        <button wire:click="confirmDelete({{ $ukm->id }})"
                            class="text-sm text-red-600 font-bold hover:underline">Hapus</button>
                    </div>
                </div>
            </div>
        @empty
            <div
                class="col-span-full text-center py-12 text-gray-400 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                <p>Belum ada data UKM.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $organizations->links() }}
    </div>

    {{-- MODAL FORM --}}
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4 backdrop-blur-sm" x-data
            @click.self="$wire.set('showModal', false)">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                <div class="px-6 py-4 border-b bg-gray-50 sticky top-0 z-10">
                    <h3 class="text-lg font-bold text-gray-800">{{ $isEditing ? 'Edit UKM' : 'Tambah UKM Baru' }}</h3>
                </div>

                <form wire:submit="save" class="p-6 space-y-5">

                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-bold text-gray-700">Nama UKM</label>
                            <input type="text" wire:model="nama" placeholder="Contoh: BEM Universitas"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('nama')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-bold text-gray-700">Kategori</label>
                            <select wire:model="kategori"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option>Organisasi</option>
                                <option>Minat Bakat</option>
                                <option>Seni</option>
                                <option>Olahraga</option>
                                <option>Kerohanian</option>
                                <option>Akademik</option>
                                <option>Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700">Deskripsi Singkat</label>
                        <textarea wire:model="deskripsi" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                        @error('deskripsi')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Styling --}}
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Tampilan Kartu</label>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Warna Tema</label>
                            <select wire:model="warna" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                @foreach ($colors as $name => $class)
                                    <option value="{{ $class }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            <div class="mt-2 h-2 w-full rounded {{ $warna }}"></div> {{-- Preview Warna --}}
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Icon (FontAwesome)</label>
                            <input type="text" wire:model="icon" placeholder="fas fa-users"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <p class="text-xs text-gray-400 mt-1">Cth: fas fa-music, fas fa-futbol</p>
                        </div>
                    </div>

                    {{-- Logo Upload --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700">Logo (Opsional)</label>
                        <input type="file" wire:model="logo"
                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">

                        @if ($logo)
                            <img src="{{ $logo->temporaryUrl() }}" class="h-20 mt-2 rounded border">
                        @elseif ($old_logo)
                            <img src="{{ asset('storage/' . $old_logo) }}" class="h-20 mt-2 rounded border">
                        @endif
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" wire:model="is_active" id="is_active"
                            class="rounded text-unmaris-blue focus:ring-unmaris-blue">
                        <label for="is_active" class="ml-2 text-sm font-bold text-gray-700">Status Aktif</label>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t">
                        <button type="button" wire:click="$set('showModal', false)"
                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md font-bold hover:bg-gray-300">Batal</button>
                        <button type="submit"
                            class="bg-unmaris-blue text-white px-4 py-2 rounded-md font-bold hover:bg-blue-800">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- MODAL DELETE --}}
    @if ($showDeleteModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-sm p-6 text-center">
                <h3 class="text-lg font-bold text-red-600 mb-2">Hapus UKM?</h3>
                <p class="text-sm text-gray-600 mb-6">Data yang dihapus tidak dapat dikembalikan.</p>
                <div class="flex justify-center space-x-3">
                    <button wire:click="$set('showDeleteModal', false)"
                        class="bg-gray-200 px-4 py-2 rounded font-bold text-sm">Batal</button>
                    <button wire:click="delete"
                        class="bg-red-600 text-white px-4 py-2 rounded font-bold text-sm hover:bg-red-700">Ya,
                        Hapus</button>
                </div>
            </div>
        </div>
    @endif
</div>
