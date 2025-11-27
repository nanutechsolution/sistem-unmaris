<div class="p-6">
    <x-slot:header>Manajemen Keuangan & Biaya</x-slot:header>

    @if (session()->has('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- TAB NAVIGATION --}}
    <div class="flex space-x-1 bg-gray-200 p-1 rounded-lg mb-6 w-fit">
        <button wire:click="$set('activeTab', 'rates')"
            class="px-4 py-2 rounded-md text-sm font-bold transition {{ $activeTab == 'rates' ? 'bg-white text-unmaris-blue shadow' : 'text-gray-600 hover:text-gray-800' }}">
            <i class="fas fa-tags mr-1"></i> Master Tarif
        </button>
        <button wire:click="$set('activeTab', 'components')"
            class="px-4 py-2 rounded-md text-sm font-bold transition {{ $activeTab == 'components' ? 'bg-white text-unmaris-blue shadow' : 'text-gray-600 hover:text-gray-800' }}">
            <i class="fas fa-list mr-1"></i> Komponen Biaya
        </button>
    </div>

    {{-- KONTEN TAB: TARIF --}}
    @if ($activeTab == 'rates')
        <div class="space-y-4">
            <div
                class="flex flex-col md:flex-row justify-between gap-4 bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                <div class="flex gap-2">
                    <select wire:model.live="filterAngkatan" class="border-gray-300 rounded-md text-sm">
                        <option value="">Semua Angkatan</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                    </select>
                    <select wire:model.live="filterProdi" class="border-gray-300 rounded-md text-sm w-48">
                        <option value="">Semua Prodi</option>
                        @foreach ($listProdi as $p)
                            <option value="{{ $p->id }}">{{ $p->nama_prodi }}</option>
                        @endforeach
                    </select>
                </div>
                <button wire:click="createRate"
                    class="bg-unmaris-blue text-white px-4 py-2 rounded font-bold text-sm hover:bg-blue-800">+ Set Tarif
                    Baru</button>
            </div>

            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left font-bold text-gray-500">Komponen</th>
                            <th class="px-6 py-3 text-left font-bold text-gray-500">Program Studi</th>
                            <th class="px-6 py-3 text-left font-bold text-gray-500">Angkatan</th>
                            <th class="px-6 py-3 text-right font-bold text-gray-500">Nominal (Rp)</th>
                            <th class="px-6 py-3 text-right font-bold text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($rates as $rate)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-800">{{ $rate->component->nama }}</div>
                                    <div class="text-xs text-gray-500">{{ $rate->component->tipe }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($rate->program_studi_id)
                                        <span
                                            class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-bold">{{ $rate->prodi->nama_prodi }}</span>
                                    @else
                                        <span
                                            class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs font-bold">Berlaku
                                            Umum (Semua Prodi)</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-mono">{{ $rate->angkatan }}</td>
                                <td class="px-6 py-4 text-right font-bold text-green-600">
                                    {{ number_format($rate->nominal, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <button wire:click="editRate({{ $rate->id }})"
                                        class="text-blue-600 hover:text-blue-900"><i class="fas fa-edit"></i></button>
                                    <button wire:click="confirmDelete('rate', {{ $rate->id }})"
                                        onclick="return confirm('Hapus tarif ini?') || event.stopImmediatePropagation()"
                                        class="text-red-600 hover:text-red-900"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada data tarif.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $rates->links() }}
        </div>
    @endif

    {{-- KONTEN TAB: KOMPONEN --}}
    @if ($activeTab == 'components')
        <div class="space-y-4">
            <div class="flex justify-between bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                <input type="text" wire:model.live.debounce="search" placeholder="Cari komponen..."
                    class="border-gray-300 rounded-md text-sm">
                <button wire:click="createComponent"
                    class="bg-unmaris-blue text-white px-4 py-2 rounded font-bold text-sm hover:bg-blue-800">+ Tambah
                    Komponen</button>
            </div>

            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left font-bold text-gray-500">Nama Komponen</th>
                            <th class="px-6 py-3 text-left font-bold text-gray-500">Tipe Pembayaran</th>
                            <th class="px-6 py-3 text-center font-bold text-gray-500">Wajib?</th>
                            <th class="px-6 py-3 text-right font-bold text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($components as $comp)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-bold text-gray-800">{{ $comp->nama }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $comp->tipe }}</td>
                                <td class="px-6 py-4 text-center">
                                    @if ($comp->is_wajib)
                                        <span class="text-green-600"><i class="fas fa-check-circle"></i> Ya</span>
                                    @else
                                        <span class="text-gray-400">Opsional</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <button wire:click="editComponent({{ $comp->id }})"
                                        class="text-blue-600 hover:text-blue-900"><i class="fas fa-edit"></i></button>
                                    <button wire:click="confirmDelete('component', {{ $comp->id }})"
                                        onclick="return confirm('Hapus komponen ini? Tarif terkait juga akan terhapus.') || event.stopImmediatePropagation()"
                                        class="text-red-600 hover:text-red-900"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada komponen biaya.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $components->links() }}
        </div>
    @endif

    {{-- MODAL KOMPONEN --}}
    @if ($showModalComponent)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4 backdrop-blur-sm" x-data
            @click.self="$wire.set('showModalComponent', false)">
            <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">
                <h3 class="text-lg font-bold mb-4">{{ $isEditing ? 'Edit' : 'Tambah' }} Komponen Biaya</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold mb-1">Nama Biaya</label>
                        <input type="text" wire:model="comp_nama" placeholder="Contoh: SPP, Uang Gedung"
                            class="w-full border-gray-300 rounded-md">
                        @error('comp_nama')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-1">Tipe</label>
                        <select wire:model="comp_tipe" class="w-full border-gray-300 rounded-md">
                            <option>Per Semester</option>
                            <option>Sekali Bayar</option>
                            <option>SKS</option>
                        </select>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" wire:model="comp_wajib" id="wajib"
                            class="rounded text-unmaris-blue">
                        <label for="wajib" class="ml-2 text-sm font-bold">Wajib Dibayar</label>
                    </div>
                    <div class="flex justify-end gap-2 pt-2">
                        <button wire:click="$set('showModalComponent', false)"
                            class="bg-gray-200 px-4 py-2 rounded text-sm font-bold">Batal</button>
                        <button wire:click="saveComponent"
                            class="bg-unmaris-blue text-white px-4 py-2 rounded text-sm font-bold">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- MODAL TARIF --}}
    @if ($showModalRate)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4 backdrop-blur-sm" x-data
            @click.self="$wire.set('showModalRate', false)">
            <div class="bg-white rounded-xl shadow-lg w-full max-w-lg p-6">
                <h3 class="text-lg font-bold mb-4">{{ $isEditing ? 'Edit' : 'Set' }} Tarif Biaya</h3>
                <div class="space-y-4">

                    <div>
                        <label class="block text-sm font-bold mb-1">Komponen Biaya</label>
                        <select wire:model="rate_comp_id" class="w-full border-gray-300 rounded-md">
                            <option value="">-- Pilih Jenis Biaya --</option>
                            @foreach ($listKomponen as $c)
                                <option value="{{ $c->id }}">{{ $c->nama }} ({{ $c->tipe }})
                                </option>
                            @endforeach
                        </select>
                        @error('rate_comp_id')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold mb-1">Untuk Prodi</label>
                            <select wire:model="rate_prodi_id" class="w-full border-gray-300 rounded-md">
                                <option value="">Semua Prodi (Umum)</option>
                                @foreach ($listProdi as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama_prodi }}</option>
                                @endforeach
                            </select>
                            <p class="text-[10px] text-gray-500 mt-1">*Kosongkan jika berlaku untuk semua.</p>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-1">Angkatan</label>
                            <input type="number" wire:model="rate_angkatan"
                                class="w-full border-gray-300 rounded-md">
                            @error('rate_angkatan')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold mb-1">Nominal (Rp)</label>
                        <input type="number" wire:model="rate_nominal"
                            class="w-full border-gray-300 rounded-md font-mono font-bold text-lg" placeholder="0">
                        @error('rate_nominal')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <button wire:click="$set('showModalRate', false)"
                            class="bg-gray-200 px-4 py-2 rounded text-sm font-bold">Batal</button>
                        <button wire:click="saveRate"
                            class="bg-unmaris-blue text-white px-4 py-2 rounded text-sm font-bold">Simpan
                            Tarif</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
