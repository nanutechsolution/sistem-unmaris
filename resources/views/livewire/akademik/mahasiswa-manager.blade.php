<div>
    <x-slot:header>Manajemen Mahasiswa</x-slot:header>

    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-4">
        <button wire:click="openCreateModal"
            class="bg-unmaris-yellow text-unmaris-blue font-bold py-2 px-4 rounded hover:bg-yellow-400 w-full md:w-auto">
            + Tambah Mahasiswa
        </button>

        <div class="flex w-full md:w-auto gap-2">
            <select wire:model.live="filterProdi"
                class="border-gray-300 rounded-md shadow-sm w-full md:w-48 focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                <option value="">Semua Prodi</option>
                @foreach ($programStudis as $prodi)
                    <option value="{{ $prodi->id }}">{{ $prodi->nama_prodi }}</option>
                @endforeach
            </select>

            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari NIM atau Nama..."
                class="border-gray-300 rounded-md shadow-sm w-full md:w-64 focus:ring-unmaris-yellow focus:border-unmaris-yellow">
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mahasiswa
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Akademik
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kontak
                    </th>
                    <th class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($mahasiswas as $mhs)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    @if ($mhs->foto_profil)
                                        <img class="h-10 w-10 rounded-full object-cover"
                                            src="{{ asset('storage/' . $mhs->foto_profil) }}" alt="">
                                    @else
                                        <img class="h-10 w-10 rounded-full"
                                            src="https://ui-avatars.com/api/?name={{ urlencode($mhs->nama_lengkap) }}&background=0D8ABC&color=fff"
                                            alt="">
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $mhs->nama_lengkap }}</div>
                                    <div class="text-xs text-gray-500 font-mono">{{ $mhs->nim }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 font-medium">{{ $mhs->programStudi->nama_prodi ?? '-' }}
                            </div>
                            <div class="text-xs text-gray-500">Angkatan {{ $mhs->angkatan }}</div>
                            <div class="text-[10px] text-gray-400 mt-1">
                                {{ $mhs->kurikulum->nama_kurikulum ?? 'Belum set kurikulum' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusClass = match ($mhs->status_mahasiswa) {
                                    'Aktif' => 'bg-green-100 text-green-800',
                                    'Cuti' => 'bg-yellow-100 text-yellow-800',
                                    'Lulus' => 'bg-blue-100 text-blue-800',
                                    'Drop Out' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-100 text-gray-800',
                                };
                            @endphp
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                {{ $mhs->status_mahasiswa }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div><i class="fas fa-envelope mr-1 text-gray-400"></i> {{ $mhs->email ?? '-' }}</div>
                            <div><i class="fas fa-phone mr-1 text-gray-400"></i> {{ $mhs->no_hp ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button wire:click="openEditModal({{ $mhs->id }})"
                                class="text-indigo-600 hover:text-indigo-900">Edit</button>
                            <button wire:click="openDeleteModal({{ $mhs->id }})"
                                class="text-red-600 hover:text-red-900 ml-4">Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                            Tidak ada data mahasiswa ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $mahasiswas->links() }}
    </div>

    <div x-data="{ show: @entangle('showModal') }" x-show="show" x-on:keydown.escape.window="show = false"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" x-cloak>
        <div @click="show = false" class="absolute inset-0"></div>
        <div class="relative w-full max-w-5xl p-6 bg-white rounded-lg shadow-lg" @click.stop>
            <form wire:submit="save">
                <h3 class="text-2xl font-semibold text-unmaris-blue border-b pb-4 mb-4">
                    {{ $isEditing ? 'Edit Data Mahasiswa' : 'Tambah Mahasiswa Baru' }}
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-h-[70vh] overflow-y-auto px-1">

                    <div class="space-y-4">
                        <h4 class="font-bold text-gray-700 uppercase text-xs border-b pb-1 mb-3">Data Akademik</h4>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">NIM <span
                                    class="text-red-500">*</span></label>
                            <input type="text" wire:model="nim"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow"
                                placeholder="Nomor Induk Mahasiswa">
                            @error('nim')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Lengkap <span
                                    class="text-red-500">*</span></label>
                            <input type="text" wire:model="nama_lengkap"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow uppercase">
                            @error('nama_lengkap')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="bg-gray-50 p-4 rounded border border-gray-200 space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Program Studi <span
                                        class="text-red-500">*</span></label>
                                <select wire:model.live="program_studi_id"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                                    <option value="">-- Pilih Prodi --</option>
                                    @foreach ($programStudis as $prodi)
                                        <option value="{{ $prodi->id }}">{{ $prodi->nama_prodi }}</option>
                                    @endforeach
                                </select>
                                @error('program_studi_id')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Kurikulum <span
                                        class="text-red-500">*</span></label>
                                <select wire:model="kurikulum_id"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow"
                                    {{ empty($program_studi_id) ? 'disabled' : '' }}>
                                    <option value="">-- Pilih Kurikulum --</option>
                                    @foreach ($kurikulums as $kur)
                                        <option value="{{ $kur->id }}">{{ $kur->nama_kurikulum }}
                                            {{ $kur->aktif ? '(Aktif)' : '' }}</option>
                                    @endforeach
                                </select>
                                @if (empty($program_studi_id))
                                    <p class="text-xs text-gray-400 mt-1">Pilih Prodi terlebih dahulu.</p>
                                @endif
                                @error('kurikulum_id')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Angkatan <span
                                        class="text-red-500">*</span></label>
                                <input type="number" wire:model="angkatan"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow"
                                    placeholder="YYYY">
                                @error('angkatan')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status <span
                                        class="text-red-500">*</span></label>
                                <select wire:model="status_mahasiswa"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                                    <option value="Aktif">Aktif</option>
                                    <option value="Cuti">Cuti</option>
                                    <option value="Lulus">Lulus</option>
                                    <option value="Drop Out">Drop Out</option>
                                    <option value="Meninggal Dunia">Meninggal Dunia</option>
                                </select>
                                @error('status_mahasiswa')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h4 class="font-bold text-gray-700 uppercase text-xs border-b pb-1 mb-3">Data Pribadi & Kontak
                        </h4>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" wire:model="email"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                                @error('email')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">No HP / WA</label>
                                <input type="text" wire:model="no_hp"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                                @error('no_hp')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                                <input type="text" wire:model="tempat_lahir"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                                @error('tempat_lahir')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                                <input type="date" wire:model="tanggal_lahir"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                                @error('tanggal_lahir')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                            <div class="flex space-x-6">
                                <label class="inline-flex items-center">
                                    <input type="radio" wire:model="jenis_kelamin" value="L"
                                        class="form-radio text-unmaris-blue">
                                    <span class="ml-2">Laki-laki</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" wire:model="jenis_kelamin" value="P"
                                        class="form-radio text-unmaris-blue">
                                    <span class="ml-2">Perempuan</span>
                                </label>
                            </div>
                            @error('jenis_kelamin')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                            <textarea wire:model="alamat" rows="3"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow"></textarea>
                            @error('alamat')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-span-2 border-t pt-4 mt-2">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Foto Profil</label>

                            <div class="flex items-center space-x-6">
                                <div class="shrink-0 relative group">

                                    @if ($foto_profil && !is_string($foto_profil))
                                        <img class="h-24 w-24 object-cover rounded-full border-4 border-white shadow-md"
                                            src="{{ $foto_profil->temporaryUrl() }}" alt="Preview Baru">
                                        <span
                                            class="absolute bottom-0 right-0 bg-green-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full border-2 border-white shadow-sm">
                                            BARU
                                        </span>
                                    @elseif ($isEditing && $old_foto_profil)
                                        {{-- Pastikan di Component saat edit() Anda set: $this->old_foto_profil = $mahasiswa->foto_profil --}}
                                        <img class="h-24 w-24 object-cover rounded-full border-4 border-white shadow-md"
                                            src="{{ asset('storage/' . $old_foto_profil) }}" alt="Foto Lama">
                                    @else
                                        <div
                                            class="h-24 w-24 rounded-full bg-gray-100 flex items-center justify-center border-4 border-white shadow-sm text-gray-400">
                                            <i class="fas fa-camera text-3xl opacity-50"></i>
                                        </div>
                                    @endif

                                    <div wire:loading wire:target="foto_profil"
                                        class="absolute inset-0 bg-black/50 rounded-full flex items-center justify-center">
                                        <svg class="animate-spin h-6 w-6 text-white"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>

                                <div class="flex-1">
                                    <input type="file" wire:model="foto_profil" id="upload_foto"
                                        class="block w-full text-sm text-gray-500
                          file:mr-4 file:py-2.5 file:px-4
                          file:rounded-full file:border-0
                          file:text-sm file:font-semibold
                          file:bg-unmaris-blue/10 file:text-unmaris-blue
                          hover:file:bg-unmaris-blue/20 cursor-pointer transition">

                                    <p class="mt-2 text-xs text-gray-500">
                                        Format: JPG, PNG. Ukuran Maksimal: 2MB.
                                    </p>

                                    @error('foto_profil')
                                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-4 border-t pt-4">
                    <button type="button" wire:click="closeModal"
                        class="bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded hover:bg-gray-300">Batal</button>
                    <button type="submit"
                        class="bg-unmaris-blue text-white font-bold py-2 px-4 rounded hover:bg-unmaris-blue/80">Simpan
                        Data</button>
                </div>
            </form>
        </div>
    </div>

    <div x-data="{ show: @entangle('showDeleteModal') }" x-show="show" x-on:keydown.escape.window="show = false"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" x-cloak>
        <div @click="show = false" class="absolute inset-0"></div>
        <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow-lg" @click.stop>
            <h3 class="text-2xl font-semibold text-red-600 mb-4">Konfirmasi Hapus</h3>
            <div class="mt-2 bg-red-50 p-3 rounded border border-red-100">
                <p class="text-gray-800 font-medium text-center">
                    {{ $deletingMahasiswa?->nama_lengkap }}
                </p>
                <p class="text-gray-500 text-sm text-center font-mono mt-1">
                    NIM: {{ $deletingMahasiswa?->nim }}
                </p>
            </div>
            <p class="text-gray-600 mt-4 text-sm text-center">
                Apakah Anda yakin ingin menghapus data mahasiswa ini? <br>Data yang dihapus tidak dapat dikembalikan.
            </p>
            <div class="mt-6 flex justify-end space-x-4">
                <button type="button" wire:click="closeDeleteModal"
                    class="bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded hover:bg-gray-300">Batal</button>
                <button type="button" wire:click="delete"
                    class="bg-red-600 text-white font-bold py-2 px-4 rounded hover:bg-red-700">Ya, Hapus</button>
            </div>
        </div>
    </div>
</div>
