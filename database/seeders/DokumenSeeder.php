<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DokumenSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('dokumen')->insert([
            [
                'judul' => 'Formulir Pendaftaran Mahasiswa Baru',
                'slug' => Str::slug('Formulir Pendaftaran Mahasiswa Baru'),
                'deskripsi' => 'Formulir resmi untuk pendaftaran mahasiswa baru.',
                'file_path' => 'dokumen/formulir_pendaftaran.pdf',
                'file_type' => 'pdf',
                'file_size' => 102400, // dalam byte
                'fakultas_id' => 1,
                'program_studi_id' => 1,
                'kategori_id' => 1,
                'akses' => 'Publik',
                'download_count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Panduan Akademik Fakultas Teknik',
                'slug' => Str::slug('Panduan Akademik Fakultas Teknik'),
                'deskripsi' => 'Panduan resmi untuk semua mahasiswa Fakultas Teknik.',
                'file_path' => 'dokumen/panduan_teknik.pdf',
                'file_type' => 'pdf',
                'file_size' => 204800,
                'fakultas_id' => 1,
                'program_studi_id' => null,
                'kategori_id' => 2,
                'akses' => 'Mahasiswa',
                'download_count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Kurikulum Teknik Informatika 2025',
                'slug' => Str::slug('Kurikulum Teknik Informatika 2025'),
                'deskripsi' => 'Kurikulum terbaru program studi Teknik Informatika.',
                'file_path' => 'dokumen/kurikulum_ti_2025.pdf',
                'file_type' => 'pdf',
                'file_size' => 307200,
                'fakultas_id' => 1,
                'program_studi_id' => 1,
                'kategori_id' => 4,
                'akses' => 'Publik',
                'download_count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
