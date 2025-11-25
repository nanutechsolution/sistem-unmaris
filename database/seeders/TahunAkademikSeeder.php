<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TahunAkademikSeeder extends Seeder
{
    public function run(): void
    {
        $startYear = 2023; // Mulai dari tahun lalu
        $yearsToGenerate = 5; // Generate sampai 5 tahun ke depan

        for ($i = 0; $i < $yearsToGenerate; $i++) {
            $currentYear = $startYear + $i;
            $nextYear = $currentYear + 1;

            // --- SEMESTER GANJIL (Kode: 20231) ---
            // Biasanya: Agustus - Januari
            DB::table('tahun_akademiks')->insert([
                'kode_tahun' => $currentYear . '1',
                'nama_tahun' => $currentYear . '/' . $nextYear,
                'semester' => 'Ganjil',
                'status' => 'Tidak Aktif',
                'tgl_mulai_krs' => "$currentYear-08-01",
                'tgl_selesai_krs' => "$currentYear-08-15",
                'tgl_mulai_kuliah' => "$currentYear-09-01",
                'tgl_selesai_kuliah' => "$nextYear-01-31",
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // --- SEMESTER GENAP (Kode: 20232) ---
            // Biasanya: Februari - Juli
            DB::table('tahun_akademiks')->insert([
                'kode_tahun' => $currentYear . '2',
                'nama_tahun' => $currentYear . '/' . $nextYear,
                'semester' => 'Genap',
                'status' => 'Tidak Aktif', // Nanti aktifkan manual 1 saja
                'tgl_mulai_krs' => "$nextYear-02-01",
                'tgl_selesai_krs' => "$nextYear-02-15",
                'tgl_mulai_kuliah' => "$nextYear-03-01",
                'tgl_selesai_kuliah' => "$nextYear-07-31",
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Set 1 Tahun Aktif (Misal Ganjil 2025/2026)
        DB::table('tahun_akademiks')
            ->where('kode_tahun', '20251')
            ->update(['status' => 'Aktif']);
    }
}
