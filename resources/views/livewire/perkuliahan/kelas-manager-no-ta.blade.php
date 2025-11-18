<div>
    <x-slot:header>
        Penawaran Kelas
    </x-slot:header>

    <div class="bg-white shadow-md rounded-lg p-6">
        <h3 class="text-xl font-semibold text-unmaris-blue">Tahun Akademik Belum Aktif</h3>
        <p class="mt-2 text-gray-600">
            Tidak ada Tahun Akademik yang disetel sebagai "Aktif".
        </p>
        <p class="mt-4">
            Silakan pergi ke <a href="{{ route('tahun-akademik.index') }}" class="text-unmaris-blue hover:underline font-medium">Manajemen Tahun Akademik</a> untuk mengaktifkan satu periode terlebih dahulu.
        </p>
    </div>
</div>
