<div>
    <x-slot:header>Manajemen Gelombang PMB</x-slot:header>

    <div class="mb-4">
        <button wire:click="openCreateModal" class="bg-unmaris-yellow text-unmaris-blue font-bold py-2 px-4 rounded hover:bg-yellow-400">
            + Tambah Gelombang
        </button>
    </div>

    <!-- Tabel Data -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gelombang</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Periode Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Promo</th> 
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($gelombangs as $gel)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-gray-900">{{ $gel->nama_gelombang }}</div>
                            <div class="text-xs text-gray-500">{{ $gel->tahunAkademik->nama_tahun }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <div class="flex flex-col">
                                <span>{{ $gel->tgl_mulai->format('d M Y') }} s/d {{ $gel->tgl_selesai->format('d M Y') }}</span>
                                @if(now()->between($gel->tgl_mulai, $gel->tgl_selesai))
                                    <span class="text-xs text-green-600 font-bold mt-1">● Sedang Berlangsung</span>
                                @endif
                            </div>
                        </td>
                        
                        <!-- Menampilkan Promo -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($gel->promo)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    🎁 {{ $gel->promo }}
                                </span>
                            @else
                                <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button wire:click="toggleActive({{ $gel->id }})" 
                                    class="relative inline-flex items-center cursor-pointer group">
                                <span class="mr-2 text-xs font-medium {{ $gel->aktif ? 'text-green-600' : 'text-gray-500' }}">
                                    {{ $gel->aktif ? 'ON' : 'OFF' }}
                                </span>
                                <div class="w-9 h-5 bg-gray-200 rounded-full peer group-hover:bg-gray-300 
                                            {{ $gel->aktif ? '!bg-green-500' : '' }} transition-colors"></div>
                                <div class="absolute left-0.5 top-0.5 bg-white w-4 h-4 rounded-full transition-transform border border-gray-300
                                            {{ $gel->aktif ? 'translate-x-full border-white' : '' }}" 
                                     style="left: {{ $gel->aktif ? '2.2rem' : '0.2rem' }}; transform: translateX({{ $gel->aktif ? '-100%' : '0' }});"></div>
                            </button>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button wire:click="openEditModal({{ $gel->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                            <button wire:click="openDeleteModal({{ $gel->id }})" class="text-red-600 hover:text-red-900">Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="p-8 text-center text-gray-500">Belum ada gelombang pendaftaran.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $gelombangs->links() }}</div>

    <!-- MODAL FORM -->
    <div x-data="{ show: @entangle('showModal') }" x-show="show" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <div @click="show = false" class="absolute inset-0"></div>
        <div class="bg-white w-full max-w-lg rounded-lg shadow-lg p-6 relative z-10">
            <button @click="show = false" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">&times;</button>
            <h3 class="text-xl font-bold mb-4 text-unmaris-blue">{{ $isEditing ? 'Edit Gelombang' : 'Tambah Gelombang' }}</h3>
            
            <form wire:submit="save" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tahun Akademik</label>
                    <select wire:model="tahun_akademik_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                        <option value="">-- Pilih Tahun --</option>
                        @foreach($tahunAkademiks as $ta)
                            <option value="{{ $ta->id }}">{{ $ta->nama_tahun }}</option>
                        @endforeach
                    </select>
                    @error('tahun_akademik_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Gelombang</label>
                    <input type="text" wire:model="nama_gelombang" placeholder="Contoh: Gelombang 1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                    @error('nama_gelombang') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Input Promo Baru -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Info Promo <span class="text-gray-400 font-normal text-xs">(Opsional)</span>
                    </label>
                    <input type="text" wire:model="promo" placeholder="Contoh: Diskon 50%" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow bg-blue-50">
                    @error('promo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                        <input type="date" wire:model="tgl_mulai" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                        @error('tgl_mulai') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                        <input type="date" wire:model="tgl_selesai" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                        @error('tgl_selesai') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="bg-gray-50 p-3 rounded flex items-center mt-2">
                    <input type="checkbox" wire:model="aktif" id="aktif" class="h-4 w-4 text-unmaris-blue border-gray-300 rounded focus:ring-unmaris-yellow">
                    <label for="aktif" class="ml-2 block text-sm text-gray-900 font-medium cursor-pointer">Status Aktif (ON)</label>
                </div>

                <div class="flex justify-end pt-4 border-t mt-4">
                    <button type="button" wire:click="closeModal" class="mr-2 px-4 py-2 text-gray-700 bg-gray-200 rounded hover:bg-gray-300">Batal</button>
                    <button type="submit" class="px-4 py-2 text-white bg-unmaris-blue rounded hover:bg-unmaris-blue/90">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL HAPUS -->
    <div x-data="{ show: @entangle('showDeleteModal') }" x-show="show" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6 relative z-10">
            <h3 class="text-xl font-bold mb-4 text-unmaris-blue">Konfirmasi Hapus</h3>
            <p class="text-gray-600 mb-6">Yakin hapus gelombang <b>{{ $deletingGelombang?->nama_gelombang }}</b>?</p>
            <div class="flex justify-end space-x-2">
                <button wire:click="closeDeleteModal" class="px-4 py-2 bg-gray-200 rounded text-gray-700 hover:bg-gray-300">Batal</button>
                <button wire:click="delete" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Ya, Hapus</button>
            </div>
        </div>
    </div>
</div>