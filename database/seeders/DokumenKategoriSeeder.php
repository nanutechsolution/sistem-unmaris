<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DokumenKategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            'Formulir Akademik',
            'Panduan Fakultas',
            'Publikasi & Penelitian',
            'Kurikulum & Silabus'
        ];

        foreach ($kategoris as $kategori) {
            DB::table('dokumen_kategori')->insert([
                'nama' => $kategori,
                'slug' => Str::slug($kategori),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
