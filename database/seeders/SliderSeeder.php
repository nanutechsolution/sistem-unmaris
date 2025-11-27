<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SliderSeeder extends Seeder
{
    public function run(): void
    {
        // Opsional: Kosongkan tabel dulu agar tidak duplikat saat seeding ulang
        DB::table('sliders')->truncate();

        $sliders = [
            // SLIDE 1: VIDEO PROFIL
            [
                'title' => 'Masa Depan <br> <span class="text-unmaris-yellow">Dimulai Di Sini.</span>',
                'description' => 'Bergabunglah dengan universitas berbasis teknologi dan bisnis yang unggul, beriman, dan berdaya saing global.',
                // Pastikan file ini ada di storage/app/public/video/video-1.mp4 atau ganti dummy
                'file_path' => 'video/video-1.mp4',
                'type' => 'video',
                'poster_path' => null, // Bisa diisi path gambar cover video
                'button_text' => 'Daftar Sekarang',
                'button_url' => '/pmb',
                'order' => 1,
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // SLIDE 2: FASILITAS (GAMBAR)
            [
                'title' => 'Kampus Digital <br> <span class="text-unmaris-yellow">Berstandar Global.</span>',
                'description' => 'Dilengkapi fasilitas laboratorium modern dan kurikulum berbasis industri terkini.',
                'file_path' => 'https://placehold.co/1920x1080/003366/FFFFFF/png?text=Smart+Campus+Facilities',
                'type' => 'image',
                'poster_path' => null,
                'button_text' => 'Jelajahi Kampus',
                'button_url' => '/fasilitas',
                'order' => 2,
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // SLIDE 3: BEASISWA (GAMBAR) -> INI YANG BARU
            [
                'title' => 'Beasiswa Prestasi <br> <span class="text-unmaris-yellow">Untuk Generasi Juara.</span>',
                'description' => 'Dapatkan kesempatan kuliah gratis hingga lulus melalui jalur KIP-Kuliah dan Beasiswa Yayasan.',
                'file_path' => 'https://placehold.co/1920x1080/00509d/FFFFFF/png?text=Beasiswa+Prestasi',
                'type' => 'image',
                'poster_path' => null,
                'button_text' => 'Cek Info Beasiswa',
                'button_url' => '/kemahasiswaan',
                'order' => 3,
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('sliders')->insert($sliders);
    }
}
