<x-layouts.public title="404 - Halaman Tidak Ditemukan">

    <div class="min-h-screen flex flex-col items-center justify-center bg-white relative overflow-hidden pt-20 pb-12">
        
        {{-- Decorative Background Elements --}}
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
            <div class="absolute -top-[20%] -right-[10%] w-[70vh] h-[70vh] bg-unmaris-blue/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-[10%] left-[10%] w-[40vh] h-[40vh] bg-unmaris-yellow/10 rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10 px-6 text-center max-w-3xl mx-auto">
            
            {{-- 404 Visual (Kompas Animasi) --}}
            <div class="relative mb-6 inline-block">
                {{-- Angka Besar di Belakang --}}
                <h1 class="text-[10rem] md:text-[16rem] font-black text-gray-50 leading-none select-none">
                    404
                </h1>
                
                {{-- Elemen Tengah (Kompas) --}}
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="relative bg-white p-4 rounded-full shadow-2xl animate-bounce" style="animation-duration: 3s;">
                        <div class="w-24 h-24 md:w-32 md:h-32 bg-unmaris-blue rounded-full flex items-center justify-center text-white text-4xl md:text-5xl shadow-inner border-4 border-blue-50">
                             {{-- Ikon Kompas Berputar Pelan --}}
                             <i class="fas fa-compass fa-spin" style="--fa-animation-duration: 10s;"></i>
                        </div>
                        {{-- Titik Dekoratif --}}
                        <div class="absolute top-0 right-0 w-6 h-6 bg-unmaris-yellow rounded-full border-4 border-white shadow-sm"></div>
                    </div>
                </div>
            </div>

            <h2 class="text-3xl md:text-5xl font-extrabold text-gray-900 mb-4 tracking-tight">
                Halaman Hilang Arah
            </h2>
            
            <p class="text-gray-600 text-lg md:text-xl mb-10 leading-relaxed max-w-2xl mx-auto">
                Maaf, sepertinya halaman yang Anda cari telah berlayar ke tempat lain atau tidak pernah ada. Mari putar haluan kembali ke jalur yang benar.
            </p>

            {{-- Action Buttons --}}
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-12">
                <a href="/" class="group inline-flex items-center justify-center px-8 py-4 bg-unmaris-blue text-white font-bold text-lg rounded-full hover:bg-unmaris-yellow hover:text-unmaris-blue transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:-translate-y-1">
                    <i class="fas fa-home mr-2 group-hover:animate-pulse"></i> 
                    Kembali ke Beranda
                </a>
                
                <a href="{{ route('public.contact') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white text-gray-700 font-bold text-lg rounded-full hover:bg-gray-50 transition duration-300 border border-gray-200 shadow-sm hover:shadow-md text-sm">
                    <i class="far fa-life-ring mr-2 text-unmaris-blue"></i>
                    Pusat Bantuan
                </a>
            </div>

            {{-- Search Box --}}
            <div class="max-w-md mx-auto border-t border-gray-100 pt-8">
                <p class="text-xs text-gray-400 uppercase tracking-widest font-bold mb-4">Atau cari informasi di sini</p>
                <form action="{{ route('public.posts.index') }}" method="GET" class="relative group">
                    <input type="text" name="q" placeholder="Cari berita, pengumuman, atau prodi..." 
                           class="w-full pl-6 pr-12 py-3 bg-gray-50 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-unmaris-blue/20 focus:border-unmaris-blue transition text-sm group-hover:bg-white">
                    <button type="submit" class="absolute right-2 top-1.5 w-9 h-9 bg-white rounded-full shadow-sm flex items-center justify-center text-gray-400 hover:text-unmaris-blue transition border border-gray-100">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>

        </div>

    </div>

</x-layouts.public>