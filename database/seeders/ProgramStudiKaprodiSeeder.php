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
                'dosen_id' => 1,
                'mulai' => '2025-01-01',
                'selesai' => null,
            ],
            [
                'program_studi_id' => 2,
                'dosen_id' => 2,
                'mulai' => '2024-08-01',
                'selesai' => null,
            ],
        ]);
    }
}
