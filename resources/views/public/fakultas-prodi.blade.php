<x-layouts.public>
    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="bg-white p-8 rounded-lg shadow-lg">
            <h1 class="text-3xl font-bold text-unmaris-blue mb-8">
                Fakultas & Program Studi
            </h1>

            <div class="space-y-10">
                @forelse ($fakultas as $fak)
                    <div class="border-b pb-6">
                        <h2 class="text-2xl font-semibold text-unmaris-blue">{{ $fak->nama_fakultas }}</h2>

                        <ul class="mt-4 list-disc list-inside space-y-2">
                            @forelse ($fak->programStudis as $prodi)
                                <li class="text-lg text-gray-700">
                                    {{ $prodi->nama_prodi }} ({{ $prodi->jenjang }})
                                </li>
                            @empty
                                <li class="text-gray-500">Belum ada program studi.</li>
                            @endforelse
                        </ul>
                    </div>
                @empty
                    <p class="text-gray-500">Belum ada data fakultas yang dimasukkan ke sistem.</p>
                @endforelse
            </div>
        </div>

    </div>
</x-layouts.public>
