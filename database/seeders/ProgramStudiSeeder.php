<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramStudiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('program_studis')->insert([
            [
                'fakultas_id'  => 1,
                'kode_prodi'   => 'PGSD',
                'nama_prodi'   => 'Pendidikan Guru Sekolah Dasar',
                'jenjang'      => 'S1',
                'akreditasi'   => 'B',
            ],
            [
                'fakultas_id'  => 1,
                'kode_prodi'   => 'PBI',
                'nama_prodi'   => 'Pendidikan Bahasa Inggris',
                'jenjang'      => 'S1',
                'akreditasi'   => 'B',
            ],
            [
                'fakultas_id'  => 2,
                'kode_prodi'   => 'KEP',
                'nama_prodi'   => 'Keperawatan',
                'jenjang'      => 'D3',
                'akreditasi'   => 'B',
            ],
            [
                'fakultas_id'  => 2,
                'kode_prodi'   => 'KESMAS',
                'nama_prodi'   => 'Kesehatan Masyarakat',
                'jenjang'      => 'S1',
                'akreditasi'   => 'B',
            ],
            [
                'fakultas_id'  => 3,
                'kode_prodi'   => 'MANAJ',
                'nama_prodi'   => 'Manajemen',
                'jenjang'      => 'S1',
                'akreditasi'   => 'B',
            ],
        ]);
    }
}
