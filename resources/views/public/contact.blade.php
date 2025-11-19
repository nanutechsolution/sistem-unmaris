<x-layouts.public title="Hubungi Kami">

    {{-- HEADER SECTION --}}
    <section class="bg-unmaris-blue text-white pt-28 pb-24 relative overflow-hidden">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-unmaris-yellow/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 rounded-full bg-white/10 blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4 tracking-tight">Hubungi Kami</h1>
            <p class="text-blue-100 text-lg max-w-2xl mx-auto">
                Punya pertanyaan tentang pendaftaran, akademik, atau kerjasama? Tim UNMARIS siap membantu Anda.
            </p>
        </div>
    </section>

    {{-- MAIN CONTACT GRID (Overlapping Effect) --}}
    <div class="max-w-7xl mx-auto px-6 pb-16 -mt-16 relative z-20">

        <div class="grid lg:grid-cols-3 gap-8">

            {{-- LEFT COLUMN: Contact Info Card --}}
            <div class="lg:col-span-1 space-y-8">
                <div class="bg-unmaris-yellow text-unmaris-blue p-8 rounded-2xl shadow-xl relative overflow-hidden">
                    {{-- Decoration --}}
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/20 rounded-full blur-xl"></div>

                    <h3 class="text-2xl font-extrabold mb-6">Informasi Kontak</h3>

                    <div class="space-y-6">
                        <div class="flex items-start space-x-4">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0 text-unmaris-blue">
                                <i class="fas fa-map-marker-alt text-lg"></i>
                            </div>
                            <div>
                                <p class="font-bold text-sm uppercase tracking-wide opacity-70 mb-1">Alamat Kampus</p>
                                <p class="font-medium leading-snug">Jl. R. Suprapto No. 35, Waingapu, Sumba Timur, Nusa Tenggara Timur</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0 text-unmaris-blue">
                                <i class="fas fa-envelope text-lg"></i>
                            </div>
                            <div>
                                <p class="font-bold text-sm uppercase tracking-wide opacity-70 mb-1">Email Resmi</p>
                                <p class="font-medium">info@unmaris.ac.id</p>
                                <p class="font-medium">pmb@unmaris.ac.id</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0 text-unmaris-blue">
                                <i class="fas fa-phone-alt text-lg"></i>
                            </div>
                            <div>
                                <p class="font-bold text-sm uppercase tracking-wide opacity-70 mb-1">Telepon / WA</p>
                                <p class="font-medium">+62 812-3456-7890</p>
                                <p class="text-sm opacity-80 mt-1">(Senin - Jumat, 08:00 - 16:00 WITA)</p>
                            </div>
                        </div>
                    </div>

                    {{-- Social Media Links --}}
                    <div class="mt-10 pt-6 border-t border-unmaris-blue/10 flex gap-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center hover:bg-white hover:text-unmaris-blue transition"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center hover:bg-white hover:text-unmaris-blue transition"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center hover:bg-white hover:text-unmaris-blue transition"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>

                {{-- Map Embed (Sumba Timur Placeholder) --}}
                <div class="rounded-2xl overflow-hidden shadow-lg border border-gray-200 h-64 lg:h-auto relative group">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3941.568561275984!2d120.2583733147825!3d-9.651944993090942!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2c4b84e333333333%3A0x3333333333333333!2sWaingapu!5e0!3m2!1sen!2sid!4v1625555555555!5m2!1sen!2sid" class="w-full h-full min-h-[300px] border-0 filter grayscale group-hover:grayscale-0 transition duration-700" allowfullscreen="" loading="lazy">
                    </iframe>
                    <div class="absolute inset-0 bg-unmaris-blue/10 pointer-events-none group-hover:bg-transparent transition"></div>
                </div>
            </div>

            {{-- RIGHT COLUMN: Contact Form --}}
            <div class="lg:col-span-2">
                <div class="bg-white p-8 md:p-10 rounded-2xl shadow-xl border border-gray-100">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Kirim Pesan</h2>

                    @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-lg border border-green-200 flex items-center">
                        <i class="fas fa-check-circle mr-2 text-xl"></i>
                        {{ session('success') }}
                    </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                                <input type="text" name="name" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:border-unmaris-blue focus:ring-2 focus:ring-unmaris-blue/20 outline-none transition" placeholder="Masukkan nama Anda" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Alamat Email</label>
                                <input type="email" name="email" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:border-unmaris-blue focus:ring-2 focus:ring-unmaris-blue/20 outline-none transition" placeholder="contoh@email.com" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Subjek</label>
                            <select name="subject" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:border-unmaris-blue focus:ring-2 focus:ring-unmaris-blue/20 outline-none transition">
                                <option value="Informasi PMB">Informasi Pendaftaran Mahasiswa Baru (PMB)</option>
                                <option value="Akademik">Layanan Akademik</option>
                                <option value="Kerjasama">Kerjasama & Kemitraan</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Pesan</label>
                            <textarea name="message" rows="5" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:border-unmaris-blue focus:ring-2 focus:ring-unmaris-blue/20 outline-none transition" placeholder="Tuliskan pesan atau pertanyaan Anda di sini..." required></textarea>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="inline-flex items-center justify-center px-8 py-3 bg-unmaris-blue text-white font-bold rounded-lg hover:bg-unmaris-yellow hover:text-unmaris-blue transition transform hover:-translate-y-1 shadow-lg">
                                <span>Kirim Pesan</span>
                                <i class="fas fa-paper-plane ml-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        {{-- FAQ SECTION (Bonus) --}}
        <div class="mt-20 max-w-4xl mx-auto">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-unmaris-blue">Pertanyaan Umum (FAQ)</h2>
                <p class="text-gray-600 mt-2">Jawaban cepat untuk pertanyaan yang sering diajukan.</p>
            </div>

            <div class="space-y-4" x-data="{ active: null }">
                {{-- FAQ Item 1 --}}
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                    <button @click="active === 1 ? active = null : active = 1" class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-bold text-gray-800">Kapan pendaftaran mahasiswa baru dibuka?</span>
                        <i class="fas fa-chevron-down text-gray-400 transition-transform duration-300" :class="active === 1 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="active === 1" x-collapse class="px-6 pb-4 pt-0 text-gray-600">
                        <p>Pendaftaran mahasiswa baru Gelombang 1 dibuka mulai bulan Januari hingga April. Silakan cek menu PMB untuk jadwal lengkap.</p>
                    </div>
                </div>

                {{-- FAQ Item 2 --}}
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                    <button @click="active === 2 ? active = null : active = 2" class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-bold text-gray-800">Apakah tersedia program beasiswa?</span>
                        <i class="fas fa-chevron-down text-gray-400 transition-transform duration-300" :class="active === 2 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="active === 2" x-collapse class="px-6 pb-4 pt-0 text-gray-600">
                        <p>Ya, UNMARIS menyediakan berbagai beasiswa, termasuk KIP-Kuliah, Beasiswa Yayasan, dan Beasiswa Prestasi. Info lebih lanjut hubungi Bagian Kemahasiswaan.</p>
                    </div>
                </div>

                {{-- FAQ Item 3 --}}
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                    <button @click="active === 3 ? active = null : active = 3" class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-bold text-gray-800">Dimana saya bisa melihat biaya kuliah?</span>
                        <i class="fas fa-chevron-down text-gray-400 transition-transform duration-300" :class="active === 3 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="active === 3" x-collapse class="px-6 pb-4 pt-0 text-gray-600">
                        <p>Rincian biaya kuliah dapat diunduh pada brosur PMB di halaman Beranda atau menghubungi admin keuangan kami.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

</x-layouts.public>
