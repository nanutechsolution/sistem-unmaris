<div>
    <!-- Slot Header -->
    <x-slot:header>Pengaturan Website</x-slot:header>

    <!-- Notifikasi Sukses -->
    @if (session()->has('message'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('message') }}</span>
    </div>
    @endif

    <div class="bg-white shadow-md rounded-lg p-6">
        <form wire:submit="save">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Kolom Kiri: Info Kontak -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-unmaris-blue">Info Kontak</h3>
                    <div>
                        <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat Kampus</label>
                        <textarea wire:model="alamat" id="alamat" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow"></textarea>
                    </div>
                    <div>
                        <label for="telepon" class="block text-sm font-medium text-gray-700">Telepon</label>
                        <input type="text" wire:model="telepon" id="telepon" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Resmi</label>
                        <input type="email" wire:model="email" id="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                    </div>
                </div>

                <!-- Kolom Kanan: Media Sosial -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-unmaris-blue">Media Sosial</h3>
                    <div>
                        <label for="link_facebook" class="block text-sm font-medium text-gray-700">Link Facebook</label>
                        <input type="url" wire:model="link_facebook" id="link_facebook" placeholder="https://facebook.com/unmaris" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                    </div>
                    <div>
                        <label for="link_instagram" class="block text-sm font-medium text-gray-700">Link Instagram</label>
                        <input type="url" wire:model="link_instagram" id="link_instagram" placeholder="https://instagram.com/unmaris" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-unmaris-yellow focus:border-unmaris-yellow">
                    </div>
                    <!-- Anda bisa tambahkan Link Twitter/X, Youtube, dll di sini -->
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="mt-6 pt-6 border-t text-right">
                <button type="submit" class="bg-unmaris-blue text-white font-bold py-2 px-4 rounded hover:bg-unmaris-blue/80">
                    <span wire:loading.remove wire:target="save">Simpan Pengaturan</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </button>
            </div>
        </form>
    </div>
</div>
