<x-layouts.public>
    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="bg-white p-8 md:p-12 rounded-lg shadow-lg">

            <h1 class="text-4xl font-bold text-unmaris-blue mb-4">
                {{ $post->title }}
            </h1>
            <div class="text-gray-500 mb-6">
                Dipublikasikan oleh <span class="font-medium text-unmaris-blue">{{ $post->author?->name ?? 'Admin' }}</span>
                pada <span class="font-medium">{{ $post->published_at->format('d F Y') }}</span>
                di Kategori <span class="font-medium text-unmaris-yellow">{{ $post->category?->name ?? 'Umum' }}</span>
            </div>

            @if($post->featured_image)
                <img class="w-full h-auto max-h-[500px] object-cover rounded-lg mb-8"
                     src="{{ Storage::url($post->featured_image) }}"
                     alt="{{ $post->title }}">
            @endif

            <div class="prose lg:prose-xl max-w-none">
                {!! $post->content !!}
            </div>
        </div>
    </div>
</x-layouts.public>
