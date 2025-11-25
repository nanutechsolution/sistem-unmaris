<x-layouts.public>
    <div class="max-w-7xl mx-auto px-6 py-10">

        <h1 class="text-3xl font-bold text-unmaris-blue mb-8">Semua Pengumuman</h1>

        <div class="grid md:grid-cols-3 gap-8">
            @foreach ($pengumuman as $item)
                <a href="{{ route('public.pengumuman.show', $item->slug) }}"
                    class="bg-white p-6 rounded-lg border shadow-sm hover:shadow-lg transition">

                    <h2 class="text-xl font-semibold mb-2">
                        {{ Str::limit($item->title, 80) }}
                    </h2>

                    <p class="text-sm text-gray-600 mb-3">
                        {{ Str::limit(strip_tags($item->content), 140) }}
                    </p>

                    <p class="text-xs text-gray-500">
                        {{ $item->published_at->format('d M Y') }}
                    </p>

                </a>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $pengumuman->links() }}
        </div>

    </div>
</x-layouts.public>
