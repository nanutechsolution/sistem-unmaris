<x-layouts.public>
    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="bg-white p-8 rounded-lg shadow-lg">
            <h1 class="text-3xl font-bold text-unmaris-blue mb-8">
                Berita & Pengumuman
            </h1>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($posts as $post)
                    <div class="flex flex-col rounded-lg shadow-lg overflow-hidden">
                        <a href="{{ route('public.posts.show', $post->slug) }}">
                            <img class="h-48 w-full object-cover"
                                 src="{{ $post->featured_image ? Storage::url($post->featured_image) : 'https://via.placeholder.com/400x250' }}"
                                 alt="{{ $post->title }}">
                        </a>
                        <div class="flex-1 bg-white p-6 flex flex-col justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-unmaris-yellow">
                                    {{ $post->category?->name ?? 'Kategori' }}
                                </p>
                                <a href="{{ route('public.posts.show', $post->slug) }}" class="block mt-2">
                                    <p class="text-xl font-semibold text-unmaris-blue">{{ $post->title }}</p>
                                    {{-- <p class="mt-3 text-base text-gray-500">{{ Str::limit(strip_tags($post->content), 100) }}</p> --}}
                                </a>
                            </div>
                            <div class="mt-4 text-sm text-gray-500">
                                <span>{{ $post->author?->name ?? 'Admin' }}</span> |
                                <span>{{ $post->published_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 md:col-span-3 text-center">Belum ada berita yang dipublikasikan.</p>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $posts->links() }}
            </div>
        </div>

    </div>
</x-layouts.public>
