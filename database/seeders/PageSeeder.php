<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pages')->insert([

            [
                'title' => 'Profil Kampus',
                'slug' => 'profil-kampus',
                'content' => '<p>Universitas Stela Maris Sumba merupakan institusi pendidikan tinggi yang berkomitmen mencetak sumber daya manusia unggul di wilayah Sumba dan Nusa Tenggara Timur. Kami berdiri dengan semangat pelayanan, integritas, dan pengabdian kepada masyarakat.</p>',
                'status' => 'Published',
            ],

            [
                'title' => 'Visi dan Misi',
                'slug' => 'visi-dan-misi',
                'content' =>
                '<h3>Visi</h3>
                <p>Menjadi perguruan tinggi unggul yang berakar pada nilai kemanusiaan, berdaya saing global, dan berkontribusi bagi pembangunan bangsa.</p>

                <h3>Misi</h3>
                <ul>
                    <li>Menyelenggarakan pendidikan berkualitas berbasis nilai-nilai moral.</li>
                    <li>Melaksanakan penelitian yang relevan dengan kebutuhan masyarakat.</li>
                    <li>Melakukan pengabdian kepada masyarakat untuk pemberdayaan lokal.</li>
                    <li>Membangun kemitraan strategis dengan lembaga regional, nasional, dan internasional.</li>
                </ul>',
                'status' => 'Published',
            ],

            [
                'title' => 'Sejarah Kampus',
                'slug' => 'sejarah-kampus',
                'content' =>
                '<p>Universitas Stela Maris Sumba berdiri untuk menjawab kebutuhan pendidikan tinggi di Pulau Sumba. Dengan dukungan para tokoh masyarakat dan yayasan, institusi ini berkembang menjadi pusat pendidikan yang memajukan generasi muda dan mempersiapkan tenaga profesional masa depan.</p>',
                'status' => 'Published',
            ],

            [
                'title' => 'Struktur Organisasi',
                'slug' => 'struktur-organisasi',
                'content' =>
                '<p>Struktur organisasi kampus terdiri dari Rektor, Wakil Rektor, Dekan Fakultas, Ketua Program Studi, serta unit-unit pendukung seperti LPPM, BAAK, Biro Administrasi Umum, dan perpustakaan.</p>',
                'status' => 'Published',
            ],

            [
                'title' => 'Kontak',
                'slug' => 'kontak',
                'content' =>
                '<p>Alamat: Jl. Marokota, Desa Lolo Ole, Sumba Barat Daya</p>
                <p>Email: info@stmaris.ac.id</p>
                <p>Telepon: 0387 - 123456</p>
                <p>Jam Layanan: Senin - Jumat, 08:00 - 16:00 WITA</p>',
                'status' => 'Published',
            ],

        ]);
    }
}
