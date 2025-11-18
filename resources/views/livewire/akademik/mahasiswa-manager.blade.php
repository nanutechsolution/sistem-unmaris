<div>
    <x-slot:header>
        Manajemen Mahasiswa
    </x-slot:header>

    <div class="flex justify-between items-center mb-4">
        <button wire:click="openCreateModal" class="bg-unmaris-yellow text-unmaris-blue font-bold py-2 px-4 rounded hover:bg-yellow-400">
            + Tambah Mahasiswa
        </button>

        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari NIM atau Nama..." class="border-gray-300 rounded-md shadow-sm w-1/3">
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIM</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lengkap</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Program Studi</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-m edium text-gray-500 uppercase tracking-wider">Angkatan</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($mahasiswas as $mhs)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $mhs->nim }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $mhs->nama_lengkap }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $mhs->programStudi?->nama_prodi ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $mhs->angkatan }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $mhs->status_mahasiswa == 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $mhs->status_mahasiswa }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button wire:click="openEditModal({{ $mhs->id }})" class="text-indigo-600 hover:text-indigo-900">
                            Edit
                        </button>
                        <button wire:click="openDeleteModal({{ $mhs->id }})" class="text-red-600 hover:text-red-900 ml-4">
                            Hapus
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
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

    <div x-data="{ show: @entangle('showDeleteModal') }" x-show="show" x-on:keydown.escape.window="show = false" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" x-cloak>

        <div @click="show = false" class="absolute inset-0"></div>

        <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow-lg" @click.stop>

            <h3 class="text-2xl font-semibold text-unmaris-blue">Konfirmasi Hapus</h3>

            <div class="mt-4">
                <p class="text-gray-600">
                    Anda yakin ingin menghapus mahasiswa: <br>
                    <span class="font-bold">{{ $deletingMahasiswa?->nama_lengkap ?? '...' }}</span>
                    ({{ $deletingMahasiswa?->nim ?? '...' }}) ?
                </p>
                <p class="mt-2 text-sm text-gray-500">
                    Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>

            <div class="mt-6 flex justify-end space-x-4">
                <button type="button" wire:click="closeDeleteModal" class="bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded hover:bg-gray-300">
                    Batal
                </button>

                <button type="button" wire:click="delete" class="bg-red-600 text-white font-bold py-2 px-4 rounded hover:bg-red-700">
                    <span wire:loading.remove wire:target="delete">Ya, Hapus</span>
                    <span wire:loading wire:target="delete">Menghapus...</span>
                </button>
            </div>
        </div>
    </div>

    <div x-data="{ show: @entangle('showModal') }" x-show="show" x-on:keydown.escape.window="show = false" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" x-cloak>

        <div @click="show = false" class="absolute inset-0"></div>

        <div class="relative w-full max-w-3xl bg-white rounded-lg shadow-lg" @click.stop>

            <form wire:submit="save">

                <div class="p-6 border-b">
                    <h3 class="text-2xl font-semibold text-unmaris-blue">
                        {{ $isEditing ? 'Edit Mahasiswa' : 'Tambah Mahasiswa Baru' }}
                    </h3>
                </div>

                <div class="p-6 max-h-[70vh] overflow-y-auto">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div class="space-y-4">
                            <div>
                                <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
                                <input type="text" wire:model="nim" id="nim" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                @error('nim') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                <input type="text" wire:model="nama_lengkap" id="nama_lengkap" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                @error('nama_lengkap') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="program_studi_id" class="block text-sm font-medium text-gray-700">Program Studi</label>
                                <select wire:model="program_studi_id" id="program_studi_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">-- Pilih Prodi --</option>
                                    @foreach($programStudis as $prodi)
                                    <option value="{{ $prodi->id }}">{{ $prodi->nama_prodi }}</option>
                                    @endforeach
                                </select>
                                @error('program_studi_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="angkatan" class="block text-sm font-medium text-gray-700">Angkatan (Tahun)</label>
                                    <input type="number" wire:model="angkatan" id="angkatan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Contoh: 2023">
                                    @error('angkatan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="status_mahasiswa" class="block text-sm font-medium text-gray-700">Status</label>
                                    <select wire:model="status_mahasiswa" id="status_mahasiswa" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                        <option value="Aktif">Aktif</option>
                                        <option value="Cuti">Cuti</option>
                                        <option value="Lulus">Lulus</option>
                                        <option value="Drop Out">Drop Out</option>
                                        <option value="Meninggal Dunia">Meninggal Dunia</option>
                                    </select>
                                    @error('status_mahasiswa') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="tempat_lahir" class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                                    <input type="text" wire:model="tempat_lahir" id="tempat_lahir" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    @error('tempat_lahir') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                                    <input type="date" wire:model="tanggal_lahir" id="tanggal_lahir" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    @error('tanggal_lahir') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div>
                                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                                <select wire:model="jenis_kelamin" id="jenis_kelamin" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                                @error('jenis_kelamin') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" wire:model="email" id="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="no_hp" class="block text-sm font-medium text-gray-700">No. HP</label>
                                <input type="text" wire:model="no_hp" id="no_hp" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                @error('no_hp') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                                <textarea wire:model="alamat" id="alamat" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                                @error('alamat') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                    </div>
                </div>

                <div class="p-6 flex justify-end space-x-4 bg-gray-50 border-t">
                    <button type="button" wire:click="closeModal" class="bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded hover:bg-gray-300">
                        Batal
                    </button>

                    <button type="submit" class="bg-unmaris-blue text-white font-bold py-2 px-4 rounded hover:bg-unmaris-blue/80">
                        <span wire:loading.remove wire:target="save">Simpan</span>
                        <span wire:loading wire:target="save">Menyimpan...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
