<x-layouts.public :title="$post->title">

    {{-- READING PROGRESS BAR (Optional UI UX Feature) --}}
    <div class="fixed top-0 left-0 h-1 bg-unmaris-yellow z-[60]" id="progressBar" style="width: 0%"></div>

    <section class="bg-white pt-28 pb-12">
        <div class="max-w-4xl mx-auto px-6">

            {{-- Meta Top --}}
            <div class="flex items-center gap-4 text-sm text-gray-500 mb-6">
                @if($post->category)
                <a href="{{ route('public.posts.category', ['slug' => $post->category->slug]) }}" class="px-3 py-1 rounded-full bg-blue-50 text-unmaris-blue font-bold uppercase text-xs tracking-wide hover:bg-unmaris-blue hover:text-white transition">
                    {{ $post->category->name }}
                </a>
                @endif
                <span class="flex items-center"><i class="far fa-clock mr-2"></i> {{ $post->published_at->format('d M Y') }}</span>
            </div>

            {{-- Title --}}
            <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 leading-tight mb-6">
                {{ $post->title }}
            </h1>

            {{-- Author --}}
            <div class="flex items-center justify-between border-b border-gray-100 pb-8 mb-8">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-unmaris-blue text-white flex items-center justify-center font-bold text-lg">
                        {{ substr($post->user->name ?? 'A', 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-900">{{ $post->user->name ?? 'Admin Redaksi' }}</p>
                        <p class="text-xs text-gray-500">Penulis Konten</p>
                    </div>
                </div>

                {{-- Share Icons --}}
                <div class="flex space-x-2">
                    <button class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-blue-600 hover:text-white transition"><i class="fab fa-facebook-f"></i></button>
                    <button class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-sky-500 hover:text-white transition"><i class="fab fa-twitter"></i></button>
                    <button class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-green-500 hover:text-white transition"><i class="fab fa-whatsapp"></i></button>
                </div>
            </div>

            {{-- Featured Image --}}
            @if($post->featured_image)
            <div class="rounded-2xl overflow-hidden shadow-lg mb-10">
                <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-auto object-cover">
            </div>
            @endif

            {{-- Content Article --}}
            <article class="prose prose-lg prose-blue max-w-none text-gray-800 leading-relaxed font-serif">
                {!! $post->content !!}
            </article>

        </div>
    </section>
    {{-- RELATED POSTS --}}
    @if($relatedPosts->count() > 0)
    <section class="py-16 bg-gray-50 border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-6">
            <h3 class="text-2xl font-bold text-gray-900 mb-8">Baca Juga</h3>

            <div class="grid md:grid-cols-3 gap-8">
                @foreach($relatedPosts as $related)
                <a href="{{ route('posts.show', $related->slug) }}" class="group block bg-white rounded-xl shadow-sm hover:shadow-md transition overflow-hidden">
                    <div class="h-48 overflow-hidden">
                        <img src="{{ $related->featured_image ? Storage::url($related->featured_image) : 'https://placehold.co/600x400/eee/ccc?text=No+Image' }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    </div>
                    <div class="p-5">
                        <h4 class="font-bold text-gray-800 mb-2 group-hover:text-unmaris-blue transition line-clamp-2">{{ $related->title }}</h4>
                        <p class="text-xs text-gray-500">{{ $related->published_at->format('d M Y') }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Simple Script for Progress Bar --}}
    <script>
        window.onscroll = function() {
            let winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            let scrolled = (winScroll / height) * 100;
            document.getElementById("progressBar").style.width = scrolled + "%";
        };

    </script>

</x-layouts.public>
