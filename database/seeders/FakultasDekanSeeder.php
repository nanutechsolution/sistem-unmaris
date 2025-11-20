<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FakultasDekanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('fakultas_dekan')->insert([
            [
                'fakultas_id' => 1, // FT
                'dosen_id' => 1,    // asumsi ID dosen dari tabel dosens
                'mulai' => '2025-01-01',
                'selesai' => null
            ],
            [
                'fakultas_id' => 2, // FKES
                'dosen_id' => 2,
                'mulai' => '2024-08-01',
                'selesai' => null
            ],
            [
                'fakultas_id' => 3, // FKIP
                'dosen_id' => 3,
                'mulai' => '2025-01-01',
                'selesai' => null
            ],
            [
                'fakultas_id' => 4, // FEB
                'dosen_id' => 4,
                'mulai' => '2025-01-01',
                'selesai' => null
            ],
        ]);
    }
}
