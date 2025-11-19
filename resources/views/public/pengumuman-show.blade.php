<x-layouts.public>
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-3 gap-12">

            <h1 class="text-3xl font-bold text-gray-900 mb-4">
                {{ $pengumuman->title }}
            </h1>

            <p class="text-sm text-gray-500 mb-6">
                Dipublikasikan: {{ $pengumuman->published_at->format('d M Y') }}
            </p>

            <div class="prose max-w-none">
                {!! $pengumuman->content !!}
            </div>

            <!-- Share -->
            <div class="mt-10 flex gap-4">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm shadow">
                    Share Facebook
                </a>

                <a href="https://wa.me/?text={{ urlencode(url()->current()) }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 text-sm shadow">
                    Share WhatsApp
                </a>
            </div>
        </div>
    </section>
</x-layouts.public>
