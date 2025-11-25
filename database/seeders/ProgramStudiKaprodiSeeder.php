<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramStudiKaprodiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('program_studi_kaprodi')->insert([
            [
                'program_studi_id' => 1,
                'dosen_id' => 32,
                'mulai' => '2025-01-01',
                'selesai' => null,
            ],
            [
                'program_studi_id' => 2,
                'dosen_id' => 32,
                'mulai' => '2024-08-01',
                'selesai' => null,
            ],
            [
                'program_studi_id' => 3,
                'dosen_id' => 35,
                'mulai' => '2024-08-01',
                'selesai' => null,
            ],
            [
                'program_studi_id' => 4,
                'dosen_id' => 16,
                'mulai' => '2024-08-01',
                'selesai' => null,
            ],
            [
                'program_studi_id' => 5,
                'dosen_id' => 48,
                'mulai' => '2024-08-01',
                'selesai' => null,
            ],
            [
                'program_studi_id' => 6,
                'dosen_id' => 68,
                'mulai' => '2024-08-01',
                'selesai' => null,
            ],
        ]);
    }
}
