<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PageSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        $pages = [
            // --- HALAMAN UMUM KAMPUS ---
            [
                'title' => 'Visi dan Misi',
                'slug' => 'visi-misi',
                'content' => '
                    <h3>Visi</h3>
                    <p>“Menjadi Pusat Pengembangan Ilmu Pengetahuan dan Teknologi yang Unggul, Beriman, Humanis dan Berdaya Saing”</p>

                    <hr>

                    <h3>Misi</h3>
                    <ul>
                        <li>Menyelenggarakan tridharma pendidikan berbasis SN-DIKTI</li>
                        <li>Menyelenggarakan pendidikan yang bermutu, komprehensif, dan progresif di bidang pendidikan, bisnis, teknik dan kesehatan</li>
                        <li>Menyelenggarakan pendidikan yang menghasilkan sumber daya manusia sesuai kebutuhan pembangunan</li>
                        <li>Menjalin kerjasama dengan stakeholder untuk menunjang pelaksanaan Tri Dharma Perguruan Tinggi</li>
                        <li>Mengembangkan organisasi, kepemimpinan dan manajemen UNMARIS guna beradaptasi dengan perubahan</li>
                    </ul>',
                'status' => 'Published',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Tujuan',
                'slug' => 'tujuan',
                'content' => '<ul>
                    <li>Menyelenggarakan dan mengembangkan program pendidikan yang menghasilkan lulusan beretika</li>
                    <li>Menyelenggarakan, mengembangkan dan membina kehidupan masyarakat akademik secara profesional</li>
                    <li>Menyelenggarakan dan mengembangkan penelitian dan inovasi teknologi untuk memanfaatkan sumber daya lokal secara optimal dan berkelanjutan</li>
                    <li>Mengembangkan fasilitas penunjang pendidikan yang optimal</li>
                    <li>Mengembangkan dan membina kerja sama kemitraan regional, nasional, dan internasional</li>
                </ul>',
                'status' => 'Published',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Sasaran',
                'slug' => 'sasaran',
                'content' => '<ul>
                    <li>Terwujudnya pelaksanaan dan hasil Tridarma PT yang bermutu dan relevan</li>
                    <li>Terwujudnya sistem manajemen dan pelayanan UNMARIS yang andal dan terpercaya</li>
                    <li>Terwujudnya keberlanjutan eksistensi dan relevansi sosial UNMARIS melalui strategi pengembangan kerjasama kelembagaan</li>
                </ul>',
                'status' => 'Published',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Profil',
                'slug' => 'profil',
                'content' => '<p>Universitas Stella Maris Sumba merupakan perubahan dari Sekolah Tinggi Manajemen Informatika Komputer (STIMIKOM) Stella Maris Sumba. Sebelumnya STIMIKOM Stella Maris Sumba yang mendapatkan status terdaftar berdasarkan SK Menteri Pendidikan dan Kebudayaan RI No.566/E/O/2014. Universitas Stella Maris Sumba resmi beralih bentuk dari sekolah tinggi menjadi universitas berdasarkan SK Menteri Pendidikan dan Kebudayaan Riset dan Teknologi RI No.985/E/O/2023. Perubahan ini dilakukan untuk mempermudah mencapai visinya menjadi pusat pengembangan Ilmu Pengetahuan dan Teknologi yang unggul, beriman, humanis dan berdaya saing.</p>',
                'status' => 'Published',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // --- HALAMAN LPM (LEMBAGA PENJAMINAN MUTU) ---
            [
                'title' => 'Visi & Misi LPM',
                'slug' => 'lpm-visi-misi',
                'content' => '
                    <h3>Visi</h3>
                    <p>Menjadi lembaga penjaminan mutu yang unggul dalam membangun budaya mutu di Universitas Stella Maris Sumba pada tahun 2030.</p>
                    <h3>Misi</h3>
                    <ul>
                        <li>Melaksanakan sistem penjaminan mutu internal (SPMI) secara berkelanjutan.</li>
                        <li>Meningkatkan kompetensi auditor mutu internal.</li>
                        <li>Mendorong akreditasi unggul untuk seluruh program studi.</li>
                    </ul>
                ',
                'status' => 'Published',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Struktur Organisasi LPM',
                'slug' => 'lpm-struktur-organisasi',
                'content' => '<p>Isi dengan bagan struktur organisasi LPM di sini (bisa upload gambar lewat editor nanti)...</p>',
                'status' => 'Published',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Kebijakan Mutu',
                'slug' => 'lpm-kebijakan-mutu',
                'content' => '
                    <p>Dokumen Kebijakan Mutu Universitas Stella Maris Sumba merupakan acuan utama dalam pelaksanaan SPMI.</p>
                    <p>Kebijakan ini mencakup standar pendidikan, penelitian, dan pengabdian kepada masyarakat.</p>
                ',
                'status' => 'Published',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // Gunakan upsert atau insert biasa, tetapi pastikan tabel kosong dulu agar tidak duplikat jika di-run ulang tanpa fresh
        // DB::table('pages')->truncate(); // Opsional: hapus data lama jika perlu
        DB::table('pages')->insert($pages);
    }
}