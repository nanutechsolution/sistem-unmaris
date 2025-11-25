<x-layouts.public :title="$post->title">

    {{-- READING PROGRESS BAR --}}
    <div class="fixed top-0 left-0 h-1 bg-unmaris-yellow z-[60]" id="progressBar" style="width: 0%"></div>

    {{-- HEADER SECTION --}}
    <section class="bg-unmaris-blue text-white pt-32 pb-32 relative overflow-hidden">
        {{-- Dekorasi Background --}}
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-unmaris-yellow/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 rounded-full bg-white/10 blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            {{-- Breadcrumb --}}
            <nav class="flex justify-center items-center text-sm text-unmaris-yellow/80 mb-6 font-medium space-x-2">
                <a href="/" class="hover:text-white transition">Home</a>
                <span>/</span>
                <a href="{{ route('posts.index') }}" class="hover:text-white transition">Kabar Kampus</a>
                <span>/</span>
                @if ($post->category)
                    <a href="{{ route('posts.index', ['category' => $post->category->slug]) }}"
                        class="hover:text-white transition">{{ $post->category->name }}</a>
                @else
                    <span>Detail</span>
                @endif
            </nav>

            <h1 class="text-3xl md:text-5xl font-extrabold mb-8 tracking-tight leading-tight">
                {{ $post->title }}
            </h1>

            {{-- Meta Info Header --}}
            <div class="flex flex-wrap justify-center items-center gap-4 md:gap-8 text-blue-100 text-sm">
                <div class="flex items-center bg-white/10 rounded-full px-4 py-1.5 backdrop-blur-sm">
                    <i class="far fa-user mr-2 text-unmaris-yellow"></i>
                    <span>{{ $post->user->name ?? 'Redaksi' }}</span>
                </div>
                <div class="flex items-center bg-white/10 rounded-full px-4 py-1.5 backdrop-blur-sm">
                    <i class="far fa-calendar-alt mr-2 text-unmaris-yellow"></i>
                    <span>{{ $post->published_at->format('d F Y') }}</span>
                </div>
                <div class="flex items-center bg-white/10 rounded-full px-4 py-1.5 backdrop-blur-sm">
                    <i class="far fa-clock mr-2 text-unmaris-yellow"></i>
                    <span>{{ ceil(str_word_count(strip_tags($post->content)) / 200) }} Menit Baca</span>
                </div>
            </div>
        </div>
    </section>

    {{-- MAIN CONTENT (Overlapping Card) --}}
    <div class="max-w-4xl mx-auto px-6 pb-16 -mt-20 relative z-20">
        <div class="bg-white p-6 md:p-12 rounded-3xl shadow-2xl border border-gray-100">

            {{-- Featured Image --}}
            @if ($post->featured_image)
                <div class="rounded-2xl overflow-hidden shadow-lg mb-10 -mx-2 md:-mx-4">
                    <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}"
                        class="w-full h-auto object-cover">
                </div>
            @endif

            {{-- Share & Category Bar (FUNCTIONAL) --}}
            <div class="flex flex-col md:flex-row justify-between items-center border-b border-gray-100 pb-8 mb-8 gap-4"
                x-data="{
                    copied: false,
                    url: '{{ route('public.posts.show', $post->slug) }}',
                    title: '{{ $post->title }}',
                    shareTo(platform) {
                        let shareUrl = '';
                        const text = encodeURIComponent(this.title);
                        const link = encodeURIComponent(this.url);
                
                        if (platform === 'facebook') {
                            shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${link}`;
                        } else if (platform === 'twitter') {
                            shareUrl = `https://twitter.com/intent/tweet?text=${text}&url=${link}`;
                        } else if (platform === 'whatsapp') {
                            shareUrl = `https://wa.me/?text=${text}%20${link}`;
                        }
                
                        window.open(shareUrl, '_blank', 'width=600,height=400');
                    },
                    copyLink() {
                        navigator.clipboard.writeText(this.url);
                        this.copied = true;
                        setTimeout(() => this.copied = false, 2000);
                    }
                }">

                @if ($post->category)
                    <a href="{{ route('posts.index', ['category' => $post->category->slug]) }}"
                        class="px-4 py-1.5 rounded-full bg-blue-50 text-unmaris-blue font-bold uppercase text-xs tracking-wide hover:bg-unmaris-blue hover:text-white transition">
                        {{ $post->category->name }}
                    </a>
                @else
                    <div></div> {{-- Spacer --}}
                @endif

                <div class="flex space-x-2 items-center">
                    <span class="text-gray-400 text-xs font-bold mr-2 uppercase tracking-wide">Bagikan</span>

                    {{-- Facebook --}}
                    <button @click="shareTo('facebook')"
                        class="w-9 h-9 rounded-full bg-gray-50 flex items-center justify-center text-gray-600 hover:bg-[#1877F2] hover:text-white transition shadow-sm"
                        title="Share to Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </button>

                    {{-- Twitter/X --}}
                    <button @click="shareTo('twitter')"
                        class="w-9 h-9 rounded-full bg-gray-50 flex items-center justify-center text-gray-600 hover:bg-black hover:text-white transition shadow-sm"
                        title="Share to X">
                        <i class="fab fa-twitter"></i>
                    </button>

                    {{-- WhatsApp --}}
                    <button @click="shareTo('whatsapp')"
                        class="w-9 h-9 rounded-full bg-gray-50 flex items-center justify-center text-gray-600 hover:bg-[#25D366] hover:text-white transition shadow-sm"
                        title="Share to WhatsApp">
                        <i class="fab fa-whatsapp"></i>
                    </button>

                    {{-- Copy Link --}}
                    <button @click="copyLink()"
                        class="w-9 h-9 rounded-full bg-gray-50 flex items-center justify-center text-gray-600 hover:bg-gray-600 hover:text-white transition shadow-sm relative"
                        title="Copy Link">
                        <i class="fas fa-link" x-show="!copied"></i>
                        <i class="fas fa-check" x-show="copied" x-cloak></i>

                        {{-- Tooltip Copied --}}
                        <span x-show="copied" x-transition
                            class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-black text-white text-[10px] px-2 py-1 rounded shadow-lg"
                            x-cloak>
                            Tersalin!
                        </span>
                    </button>
                </div>
            </div>

            {{-- Article Content --}}
            <article class="prose prose-lg prose-blue max-w-none text-gray-700 leading-relaxed font-serif">
                {!! $post->content !!}
            </article>

            {{-- Author Box (Bottom) --}}
            <div class="mt-12 pt-8 border-t border-gray-100 flex items-center gap-4 bg-gray-50 p-6 rounded-2xl">
                <div
                    class="w-14 h-14 rounded-full bg-unmaris-blue text-white flex items-center justify-center font-bold text-2xl shadow-md border-2 border-white">
                    {{ substr($post->user->name ?? 'A', 0, 1) }}
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-0.5">Ditulis Oleh</p>
                    <p class="font-bold text-gray-900 text-lg">{{ $post->user->name ?? 'Admin Redaksi' }}</p>
                </div>
            </div>

        </div>
    </div>

    {{-- RELATED POSTS --}}
    @if ($relatedPosts->count() > 0)
        <section class="py-20 bg-gray-50 border-t border-gray-200">
            <div class="max-w-7xl mx-auto px-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
                    <div>
                        <h3 class="text-3xl font-extrabold text-gray-900">Artikel Terkait</h3>
                        <p class="text-gray-500 mt-1">Baca berita lain dalam kategori yang sama.</p>
                    </div>
                    <a href="{{ route('posts.index') }}"
                        class="inline-flex items-center font-bold text-unmaris-blue hover:text-unmaris-yellow transition">
                        Lihat Semua Berita <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    @foreach ($relatedPosts as $related)
                        <a href="{{ route('public.posts.show', $related->slug) }}"
                            class="group flex flex-col h-full bg-white rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-2 transition duration-300 overflow-hidden border border-gray-100">
                            <div class="h-52 overflow-hidden relative">
                                <img src="{{ $related->featured_image ? Storage::url($related->featured_image) : 'https://placehold.co/600x400/003366/FFFFFF/png?text=UNMARIS' }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-60 group-hover:opacity-40 transition">
                                </div>

                                <div class="absolute bottom-4 left-4 text-white text-xs font-bold flex items-center">
                                    <i class="far fa-calendar-alt mr-1.5"></i>
                                    {{ $related->published_at->format('d M Y') }}
                                </div>
                            </div>
                            <div class="p-6 flex flex-col flex-grow">
                                <h4
                                    class="font-bold text-lg text-gray-800 mb-3 group-hover:text-unmaris-blue transition leading-snug line-clamp-2">
                                    {{ $related->title }}
                                </h4>
                                <p class="text-gray-500 text-sm line-clamp-2 mb-4 flex-grow">
                                    {!! Str::limit(strip_tags($related->content), 80) !!}
                                </p>
                                <span
                                    class="mt-auto text-sm font-bold text-unmaris-blue flex items-center group-hover:underline decoration-unmaris-yellow decoration-2 underline-offset-4">
                                    Baca Artikel <i
                                        class="fas fa-chevron-right ml-1 text-xs transition-transform group-hover:translate-x-1"></i>
                                </span>
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
