<div class="p-6">
    <x-slot:header>Manajemen Role & Permission</x-slot:header>

    {{-- Flash Messages --}}
    @if (session()->has('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 shadow-sm">{{ session('success') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 shadow-sm">{{ session('error') }}</div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <button wire:click="create"
            class="bg-unmaris-blue text-white font-bold py-2 px-4 rounded hover:bg-blue-800 shadow-md transition flex items-center gap-2">
            <i class="fas fa-shield-alt"></i> Tambah Role Baru
        </button>

        <div class="relative w-1/3">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari role..."
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow pl-10">
            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
        </div>
    </div>

    {{-- TABEL ROLE --}}
    <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Role
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Hak Akses
                        (Permissions)</th>
                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($roles as $role)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-user-tag text-gray-400"></i> {{ $role->name }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1">
                                @forelse($role->permissions as $perm)
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                        {{ $perm->name }}
                                    </span>
                                @empty
                                    <span class="text-xs text-gray-400 italic">Tidak ada permission khusus.</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            @if ($role->name !== 'super_admin')
                                <button wire:click="edit({{ $role->id }})"
                                    class="text-indigo-600 hover:text-indigo-900 font-bold mr-3">Edit</button>
                                <button wire:click="confirmDelete({{ $role->id }})"
                                    class="text-red-600 hover:text-red-900 font-bold">Hapus</button>
                            @else
                                <span class="text-xs text-gray-400 italic bg-gray-100 px-2 py-1 rounded"><i
                                        class="fas fa-lock"></i> Locked</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-gray-500">Belum ada role.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $roles->links() }}</div>

    {{-- MODAL FORM --}}
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4 backdrop-blur-sm" x-data
            @click.self="$wire.set('showModal', false)">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                <div class="px-6 py-4 border-b flex justify-between items-center sticky top-0 bg-white z-10">
                    <h3 class="text-xl font-bold text-gray-800">{{ $isEditing ? 'Edit Role' : 'Buat Role Baru' }}</h3>
                    <button wire:click="$set('showModal', false)" class="text-gray-400 hover:text-gray-600"><i
                            class="fas fa-times"></i></button>
                </div>

                <form wire:submit="save" class="p-6 space-y-6">

                    {{-- Nama Role --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Nama Role (Jabatan)</label>
                        <input type="text" wire:model="name" placeholder="Contoh: admin_keuangan"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-unmaris-blue focus:border-unmaris-blue">
                        @error('name')
                            <span class="text-red-500 text-xs font-bold">{{ $message }}</span>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Gunakan huruf kecil dan underscore (snake_case)
                            disarankan.</p>
                    </div>

                    {{-- Permission Checkbox --}}
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <label class="block text-sm font-bold text-gray-700 mb-3">Pilih Hak Akses (Permissions)</label>

                        <div
                            class="grid grid-cols-1 md:grid-cols-2 gap-3 max-h-60 overflow-y-auto custom-scrollbar pr-2">
                            @foreach ($allPermissions as $perm)
                                <label
                                    class="flex items-center space-x-3 p-2 rounded hover:bg-white transition cursor-pointer border border-transparent hover:border-gray-200">
                                    <input type="checkbox" wire:model="selectedPermissions" value="{{ $perm->name }}"
                                        class="rounded text-unmaris-blue focus:ring-unmaris-yellow h-4 w-4">
                                    <span class="text-sm text-gray-700">{{ $perm->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        @if (count($allPermissions) == 0)
                            <p class="text-xs text-red-500 italic">Belum ada permission di database. Jalankan seeder
                                dulu.</p>
                        @endif
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t">
                        <button type="button" wire:click="$set('showModal', false)"
                            class="bg-gray-200 px-4 py-2 rounded-lg font-bold hover:bg-gray-300 text-gray-700">Batal</button>
                        <button type="submit"
                            class="bg-unmaris-blue text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-800 flex items-center shadow-md">
                            <span wire:loading.remove wire:target="save">Simpan Role</span>
                            <span wire:loading wire:target="save"><i class="fas fa-spinner animate-spin mr-2"></i>
                                Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- MODAL DELETE --}}
    @if ($showDeleteModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4 backdrop-blur-sm">
            <div class="bg-white rounded-xl shadow-lg p-6 text-center max-w-sm w-full">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Hapus Role?</h3>
                <p class="text-sm text-gray-500 mb-6">User dengan role ini akan kehilangan hak aksesnya.</p>
                <div class="flex justify-center gap-4">
                    <button wire:click="$set('showDeleteModal', false)"
                        class="bg-gray-200 px-4 py-2 rounded-lg font-bold text-sm hover:bg-gray-300">Batal</button>
                    <button wire:click="delete"
                        class="bg-red-600 text-white px-4 py-2 rounded-lg font-bold text-sm hover:bg-red-700">Ya,
                        Hapus</button>
                </div>
            </div>
        </div>
    @endif
</div>
