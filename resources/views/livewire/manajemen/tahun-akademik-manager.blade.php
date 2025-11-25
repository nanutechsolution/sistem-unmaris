<div>
    <x-slot:header>Master Tahun Akademik</x-slot:header>

    <div class="flex justify-between items-center mb-4">
        <button wire:click="create" class="bg-unmaris-blue text-white font-bold py-2 px-4 rounded hover:bg-blue-800">+ Tahun Akademik Baru</button>
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari Kode/Nama..." class="border-gray-300 rounded-md w-1/3">
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left font-bold text-gray-500 uppercase">Kode</th>
                    <th class="px-4 py-3 text-left font-bold text-gray-500 uppercase">Tahun & Semester</th>
                    <th class="px-4 py-3 text-left font-bold text-gray-500 uppercase">Periode KRS</th>
                    <th class="px-4 py-3 text-left font-bold text-gray-500 uppercase">Periode Kuliah</th>
                    <th class="px-4 py-3 text-center font-bold text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-right font-bold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($tahun_akademiks as $ta)
                <tr class="hover:bg-gray-50 {{ $ta->status == 'Aktif' ? 'bg-green-50' : '' }}">
                    <td class="px-4 py-3 font-mono font-bold text-unmaris-blue">{{ $ta->kode_tahun }}</td>
                    <td class="px-4 py-3">
                        <div class="font-bold">{{ $ta->nama_tahun }}</div>
                        <div class="text-xs text-gray-500 uppercase">{{ $ta->semester }}</div>
                    </td>
                    <td class="px-4 py-3 text-xs">
                        @if($ta->tgl_mulai_krs)
                            {{ $ta->tgl_mulai_krs->format('d M') }} - {{ $ta->tgl_selesai_krs->format('d M Y') }}
                        @else <span class="text-gray-400">-</span> @endif
                    </td>
                    <td class="px-4 py-3 text-xs">
                        @if($ta->tgl_mulai_kuliah)
                            {{ $ta->tgl_mulai_kuliah->format('d M') }} - {{ $ta->tgl_selesai_kuliah->format('d M Y') }}
                        @else <span class="text-gray-400">-</span> @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        @if($ta->status == 'Aktif')
                            <span class="px-2 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800 border border-green-200">AKTIF</span>
                        @else
                            <button wire:click="toggleActive({{ $ta->id }})" class="text-gray-400 hover:text-green-600 text-xs border border-gray-300 px-2 py-1 rounded">Set Aktif</button>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right space-x-2">
                        <button wire:click="edit({{ $ta->id }})" class="text-blue-600 font-bold">Edit</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $tahun_akademiks->links() }}</div>

    @if($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">{{ $isEditing ? 'Edit' : 'Tambah' }} Tahun Akademik</h3>
            
            <form wire:submit="save" class="grid grid-cols-2 gap-4">
                <div class="space-y-3">
                    <h4 class="font-bold text-xs text-gray-400 uppercase border-b pb-1">Identitas</h4>
                    <div>
                        <label class="text-xs font-bold text-gray-700">Kode (5 Digit)</label>
                        <input type="text" wire:model="kode_tahun" class="w-full border-gray-300 rounded-md text-sm">
                        @error('kode_tahun') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-700">Nama (Contoh: 2025/2026)</label>
                        <input type="text" wire:model="nama_tahun" class="w-full border-gray-300 rounded-md text-sm">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-700">Semester</label>
                        <select wire:model="semester" class="w-full border-gray-300 rounded-md text-sm">
                            <option value="Ganjil">Ganjil</option>
                            <option value="Genap">Genap</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-700">Status</label>
                        <select wire:model="status" class="w-full border-gray-300 rounded-md text-sm">
                            <option value="Tidak Aktif">Tidak Aktif</option>
                            <option value="Aktif">Aktif</option>
                        </select>
                    </div>
                </div>

                <div class="space-y-3">
                    <h4 class="font-bold text-xs text-gray-400 uppercase border-b pb-1">Jadwal Akademik</h4>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="text-xs text-gray-700">Mulai KRS</label>
                            <input type="date" wire:model="tgl_mulai_krs" class="w-full border-gray-300 rounded-md text-xs">
                        </div>
                        <div>
                            <label class="text-xs text-gray-700">Selesai KRS</label>
                            <input type="date" wire:model="tgl_selesai_krs" class="w-full border-gray-300 rounded-md text-xs">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="text-xs text-gray-700">Mulai Kuliah</label>
                            <input type="date" wire:model="tgl_mulai_kuliah" class="w-full border-gray-300 rounded-md text-xs">
                        </div>
                        <div>
                            <label class="text-xs text-gray-700">Selesai Kuliah</label>
                            <input type="date" wire:model="tgl_selesai_kuliah" class="w-full border-gray-300 rounded-md text-xs">
                        </div>
                    </div>
                </div>

                <div class="col-span-2 flex justify-end gap-2 pt-4 border-t">
                    <button type="button" wire:click="$set('showModal', false)" class="bg-gray-200 px-4 py-2 rounded text-sm font-bold">Batal</button>
                    <button type="submit" class="bg-unmaris-blue text-white px-4 py-2 rounded text-sm font-bold">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>