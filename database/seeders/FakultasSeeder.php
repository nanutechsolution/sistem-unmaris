<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FakultasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('fakultas')->insert([
            [
                'kode_fakultas' => 'FKIP',
                'nama_fakultas' => 'Fakultas Keguruan dan Ilmu Pendidikan',
            ],
            [
                'kode_fakultas' => 'FKES',
                'nama_fakultas' => 'Fakultas Kesehatan',
            ],
            [
                'kode_fakultas' => 'FEKON',
                'nama_fakultas' => 'Fakultas Ekonomi dan Bisnis',
            ],
        ]);
    }
}
