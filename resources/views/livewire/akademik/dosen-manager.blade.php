    <div>
        <x-slot:header>
            Manajemen Dosen
        </x-slot:header>

        @if (session()->has('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-4">
            <button wire:click="openCreateModal"
                class="bg-unmaris-yellow text-unmaris-blue font-bold py-2 px-4 rounded hover:bg-yellow-400 w-full md:w-auto shadow-sm transition">
                + Tambah Dosen
            </button>

            <div class="relative w-full md:w-1/3">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari Nama, NIDN, atau NUPTK..."
                    class="border-gray-300 rounded-md shadow-sm w-full pl-10 focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Dosen
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                            Identitas
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                            Homebase
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status
                        </th>
                        <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($dosens as $dosen)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        @if ($dosen->foto_profil)
                                            <img class="h-12 w-12 rounded-full object-cover border border-gray-200"
                                                src="{{ asset('storage/' . $dosen->foto_profil) }}" alt="">
                                        @else
                                            <img class="h-12 w-12 rounded-full"
                                                src="https://ui-avatars.com/api/?name={{ urlencode($dosen->nama_lengkap) }}&background=0D8ABC&color=fff&size=128"
                                                alt="">
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-gray-900">{{ $dosen->nama_lengkap }}</div>
                                        <div class="text-xs text-gray-500">{{ $dosen->email ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-xs text-gray-900"><span class="font-semibold">NIDN:</span>
                                    {{ $dosen->nidn ?? '-' }}</div>
                                <div class="text-xs text-gray-500"><span class="font-semibold">NUPTK:</span>
                                    {{ $dosen->nuptk ?? '-' }}</div>
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $dosen->tempat_lahir ?? '' }}
                                    {{ $dosen->tanggal_lahir ? ', ' . $dosen->tanggal_lahir->format('d M Y') : '' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $dosen->programStudi?->nama_prodi ?? 'Belum Set' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @php
                                    $statusClass = match ($dosen->status_kepegawaian) {
                                        'Aktif' => 'bg-green-100 text-green-800',
                                        'Tugas Belajar' => 'bg-blue-100 text-blue-800',
                                        'Pensiun' => 'bg-gray-100 text-gray-800',
                                        'Keluar' => 'bg-red-100 text-red-800',
                                        default => 'bg-yellow-100 text-yellow-800',
                                    };
                                @endphp
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                    {{ $dosen->status_kepegawaian }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <button wire:click="openEditModal({{ $dosen->id }})"
                                    class="text-indigo-600 hover:text-indigo-900 font-bold">Edit</button>
                                <button wire:click="openDeleteModal({{ $dosen->id }})"
                                    class="text-red-600 hover:text-red-900 font-bold">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="h-10 w-10 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <p>Tidak ada data dosen ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $dosens->links() }}
        </div>

        <div x-data="{ show: @entangle('showModal') }" x-show="show" x-on:keydown.escape.window="show = false"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" x-cloak>
            <div @click="show = false" class="absolute inset-0"></div>
            <div class="relative w-full max-w-4xl p-6 bg-white rounded-xl shadow-2xl max-h-[90vh] overflow-y-auto"
                @click.stop>
                <form wire:submit="save">
                    <div class="flex justify-between items-center border-b pb-4 mb-6">
                        <h3 class="text-2xl font-bold text-unmaris-blue">
                            {{ $isEditing ? 'Edit Data Dosen' : 'Tambah Dosen Baru' }}
                        </h3>
                        <button type="button" wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                        <div class="space-y-5">
                            <h4 class="text-sm font-bold text-gray-500 uppercase tracking-wider border-b pb-1">Data
                                Utama
                            </h4>

                            <div class="flex items-center space-x-4">
                                <div class="shrink-0">
                                    @if ($foto_profil)
                                        <img class="h-20 w-20 object-cover rounded-full border-2 border-unmaris-yellow"
                                            src="{{ $foto_profil->temporaryUrl() }}">
                                    @elseif ($old_foto_profil)
                                        <img class="h-20 w-20 object-cover rounded-full border-2 border-gray-200"
                                            src="{{ asset('storage/' . $old_foto_profil) }}">
                                    @else
                                        <div
                                            class="h-20 w-20 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 border-2 border-dashed border-gray-300">
                                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Foto Profil</label>
                                    <input type="file" wire:model="foto_profil"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                    <div wire:loading wire:target="foto_profil" class="text-xs text-blue-500 mt-1">
                                        Mengupload...</div>
                                    @error('foto_profil')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700">Nama Lengkap <span
                                        class="text-red-500">*</span></label>
                                <input type="text" wire:model="nama_lengkap"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow uppercase">
                                @error('nama_lengkap')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="grid grid-cols-4 gap-2">
                                <div class="col-span-1">
                                    <label class="text-xs">Gelar Depan</label>
                                    <input type="text" wire:model="gelar_depan" placeholder="Dr."      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow uppercase">
                           
                                </div>
                                <div class="col-span-2">
                                    <label class="text-xs">Nama Lengkap (Tanpa Gelar)</label>
                                    <input type="text" wire:model="nama" placeholder="Budi Santoso"
                                             class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow uppercase">
                           
                                </div>
                                <div class="col-span-1">
                                    <label class="text-xs">Gelar Belakang</label>
                                    <input type="text" wire:model="gelar_belakang" placeholder="M.Kom"
                                             class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow uppercase">
                           
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">NIDN</label>
                                    <input type="text" wire:model="nidn"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                                    @error('nidn')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">NUPTK</label>
                                    <input type="text" wire:model="nuptk"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                                    @error('nuptk')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                                <div class="flex space-x-6">
                                    <label class="inline-flex items-center">
                                        <input type="radio" wire:model="jenis_kelamin" value="L"
                                            class="form-radio text-unmaris-blue focus:ring-unmaris-yellow">
                                        <span class="ml-2 text-sm text-gray-700">Laki-laki</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" wire:model="jenis_kelamin" value="P"
                                            class="form-radio text-unmaris-blue focus:ring-unmaris-yellow">
                                        <span class="ml-2 text-sm text-gray-700">Perempuan</span>
                                    </label>
                                </div>
                                @error('jenis_kelamin')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="space-y-5">
                            <h4 class="text-sm font-bold text-gray-500 uppercase tracking-wider border-b pb-1">
                                Kepegawaian
                                & Kontak</h4>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Homebase Prodi</label>
                                <select wire:model="program_studi_id"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                                    <option value="">-- Tidak Ada / Belum Set --</option>
                                    @foreach ($programStudis as $prodi)
                                        <option value="{{ $prodi->id }}">{{ $prodi->nama_prodi }}
                                            ({{ $prodi->jenjang }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('program_studi_id')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status Kepegawaian <span
                                        class="text-red-500">*</span></label>
                                <select wire:model="status_kepegawaian"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                                    <option value="Aktif">Aktif</option>
                                    <option value="Tugas Belajar">Tugas Belajar</option>
                                    <option value="Keluar">Keluar</option>
                                    <option value="Pensiun">Pensiun</option>
                                </select>
                                @error('status_kepegawaian')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                                    <input type="text" wire:model="tempat_lahir"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                                    <input type="date" wire:model="tanggal_lahir"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" wire:model="email"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    @error('email')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">No. HP</label>
                                    <input type="text" wire:model="no_hp"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    @error('no_hp')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Agama</label>
                                <select wire:model="agama"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                                    <option value="">-- Pilih Agama --</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen (Protestan)</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                    <option value="Konghucu">Konghucu</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                @error('agama')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end space-x-4 border-t pt-4">
                        <button type="button" wire:click="closeModal"
                            class="bg-gray-200 text-gray-700 font-bold py-2 px-6 rounded-lg hover:bg-gray-300 transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="bg-unmaris-blue text-white font-bold py-2 px-6 rounded-lg hover:bg-blue-800 transition flex items-center">
                            <span wire:loading.remove wire:target="save">Simpan Data</span>
                            <span wire:loading wire:target="save">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Menyimpan...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div x-data="{ show: @entangle('showDeleteModal') }" x-show="show" x-on:keydown.escape.window="show = false"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" x-cloak>
            <div @click="show = false" class="absolute inset-0"></div>
            <div class="relative w-full max-w-md p-6 bg-white rounded-xl shadow-lg" @click.stop>
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Konfirmasi Hapus</h3>
                    <p class="text-sm text-gray-500 mb-6">
                        Apakah Anda yakin ingin menghapus data dosen <br>
                        <span class="font-bold text-gray-800">{{ $deletingDosen?->nama_lengkap }}</span>?
                        <br>Data yang dihapus tidak dapat dikembalikan.
                    </p>
                </div>

                <div class="flex justify-center space-x-4">
                    <button type="button" wire:click="closeDeleteModal"
                        class="bg-gray-200 text-gray-700 font-bold py-2 px-6 rounded-lg hover:bg-gray-300 transition">
                        Batal
                    </button>
                    <button type="button" wire:click="delete"
                        class="bg-red-600 text-white font-bold py-2 px-6 rounded-lg hover:bg-red-700 transition flex items-center">
                        <span wire:loading.remove wire:target="delete">Ya, Hapus</span>
                        <span wire:loading wire:target="delete">Menghapus...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
