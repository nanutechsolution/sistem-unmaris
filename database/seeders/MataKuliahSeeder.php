<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MataKuliahSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('mata_kuliahs')->insert([

            // ====================================================
            // ==================== TEKNIK INFORMATIKA =============
            // ====================================================

            // SEMESTER 1
            [
                'kode_mk' => 'TI101',
                'nama_mk' => 'Pengantar Teknologi Informasi',
                'program_studi_id' => 1,
                'sks' => 3,
                'semester' => 1,
            ],
            [
                'kode_mk' => 'TI102',
                'nama_mk' => 'Algoritma dan Pemrograman',
                'program_studi_id' => 1,
                'sks' => 4,
                'semester' => 1,
            ],
            [
                'kode_mk' => 'TI103',
                'nama_mk' => 'Matematika Dasar',
                'program_studi_id' => 1,
                'sks' => 3,
                'semester' => 1,
            ],
            [
                'kode_mk' => 'TI104',
                'nama_mk' => 'Bahasa Indonesia',
                'program_studi_id' => 1,
                'sks' => 2,
                'semester' => 1,
            ],

            // SEMESTER 2
            [
                'kode_mk' => 'TI201',
                'nama_mk' => 'Struktur Data',
                'program_studi_id' => 1,
                'sks' => 4,
                'semester' => 2,
            ],
            [
                'kode_mk' => 'TI202',
                'nama_mk' => 'Arsitektur Komputer',
                'program_studi_id' => 1,
                'sks' => 3,
                'semester' => 2,
            ],
            [
                'kode_mk' => 'TI203',
                'nama_mk' => 'Matematika Diskrit',
                'program_studi_id' => 1,
                'sks' => 3,
                'semester' => 2,
            ],
            [
                'kode_mk' => 'TI204',
                'nama_mk' => 'Pancasila & Kewarganegaraan',
                'program_studi_id' => 1,
                'sks' => 2,
                'semester' => 2,
            ],

            // SEMESTER 3
            [
                'kode_mk' => 'TI301',
                'nama_mk' => 'Basis Data',
                'program_studi_id' => 1,
                'sks' => 4,
                'semester' => 3,
            ],
            [
                'kode_mk' => 'TI302',
                'nama_mk' => 'Pemrograman Berorientasi Objek',
                'program_studi_id' => 1,
                'sks' => 4,
                'semester' => 3,
            ],
            [
                'kode_mk' => 'TI303',
                'nama_mk' => 'Sistem Operasi',
                'program_studi_id' => 1,
                'sks' => 3,
                'semester' => 3,
            ],
            [
                'kode_mk' => 'TI304',
                'nama_mk' => 'Jaringan Komputer',
                'program_studi_id' => 1,
                'sks' => 3,
                'semester' => 3,
            ],

            // SEMESTER 4
            [
                'kode_mk' => 'TI401',
                'nama_mk' => 'Analisis dan Desain Sistem',
                'program_studi_id' => 1,
                'sks' => 3,
                'semester' => 4,
            ],
            [
                'kode_mk' => 'TI402',
                'nama_mk' => 'Pemrograman Web',
                'program_studi_id' => 1,
                'sks' => 4,
                'semester' => 4,
            ],
            [
                'kode_mk' => 'TI403',
                'nama_mk' => 'Interaksi Manusia dan Komputer',
                'program_studi_id' => 1,
                'sks' => 3,
                'semester' => 4,
            ],

            // SEMESTER 5
            [
                'kode_mk' => 'TI501',
                'nama_mk' => 'Rekayasa Perangkat Lunak',
                'program_studi_id' => 1,
                'sks' => 4,
                'semester' => 5,
            ],
            [
                'kode_mk' => 'TI502',
                'nama_mk' => 'Keamanan Sistem Informasi',
                'program_studi_id' => 1,
                'sks' => 3,
                'semester' => 5,
            ],
            [
                'kode_mk' => 'TI503',
                'nama_mk' => 'Data Mining',
                'program_studi_id' => 1,
                'sks' => 3,
                'semester' => 5,
            ],

            // SEMESTER 6
            [
                'kode_mk' => 'TI601',
                'nama_mk' => 'Pemrograman Mobile',
                'program_studi_id' => 1,
                'sks' => 3,
                'semester' => 6,
            ],
            [
                'kode_mk' => 'TI602',
                'nama_mk' => 'Kecerdasan Buatan',
                'program_studi_id' => 1,
                'sks' => 3,
                'semester' => 6,
            ],
            [
                'kode_mk' => 'TI603',
                'nama_mk' => 'Manajemen Proyek TI',
                'program_studi_id' => 1,
                'sks' => 3,
                'semester' => 6,
            ],

            // SEMESTER 7
            [
                'kode_mk' => 'TI701',
                'nama_mk' => 'Magang Industri',
                'program_studi_id' => 1,
                'sks' => 3,
                'semester' => 7,
            ],
            [
                'kode_mk' => 'TI702',
                'nama_mk' => 'Sistem Informasi Enterprise',
                'program_studi_id' => 1,
                'sks' => 3,
                'semester' => 7,
            ],

            // SEMESTER 8
            [
                'kode_mk' => 'TI801',
                'nama_mk' => 'Skripsi',
                'program_studi_id' => 1,
                'sks' => 6,
                'semester' => 8,
            ],

            // ====================================================
            // ==================== TEKNIK LINGKUNGAN ==============
            // ====================================================

            // SEMESTER 1
            [
                'kode_mk' => 'TL101',
                'nama_mk' => 'Kimia Dasar',
                'program_studi_id' => 2,
                'sks' => 3,
                'semester' => 1,
            ],
            [
                'kode_mk' => 'TL102',
                'nama_mk' => 'Fisika Dasar',
                'program_studi_id' => 2,
                'sks' => 3,
                'semester' => 1,
            ],

            // SEMESTER 2
            [
                'kode_mk' => 'TL201',
                'nama_mk' => 'Mikrobiologi Lingkungan',
                'program_studi_id' => 2,
                'sks' => 3,
                'semester' => 2,
            ],
            [
                'kode_mk' => 'TL202',
                'nama_mk' => 'Ekologi',
                'program_studi_id' => 2,
                'sks' => 2,
                'semester' => 2,
            ],

            // SEMESTER 3
            [
                'kode_mk' => 'TL301',
                'nama_mk' => 'Hidrologi',
                'program_studi_id' => 2,
                'sks' => 3,
                'semester' => 3,
            ],

            // SEMESTER 4
            [
                'kode_mk' => 'TL401',
                'nama_mk' => 'Teknik Pengolahan Air',
                'program_studi_id' => 2,
                'sks' => 3,
                'semester' => 4,
            ],

            // SEMESTER 5
            [
                'kode_mk' => 'TL501',
                'nama_mk' => 'Pengolahan Limbah Cair',
                'program_studi_id' => 2,
                'sks' => 3,
                'semester' => 5,
            ],

            // SEMESTER 6
            [
                'kode_mk' => 'TL601',
                'nama_mk' => 'Manajemen Lingkungan',
                'program_studi_id' => 2,
                'sks' => 3,
                'semester' => 6,
            ],

            // SEMESTER 7
            [
                'kode_mk' => 'TL701',
                'nama_mk' => 'K3 dan AMDAL',
                'program_studi_id' => 2,
                'sks' => 3,
                'semester' => 7,
            ],

            // SEMESTER 8
            [
                'kode_mk' => 'TL801',
                'nama_mk' => 'Skripsi',
                'program_studi_id' => 2,
                'sks' => 6,
                'semester' => 8,
            ],

        ]);
    }
}
