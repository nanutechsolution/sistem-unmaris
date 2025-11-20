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
        'fakultas_id' => 1,
        'kode_prodi'  => 'TI',
        'nama_prodi'  => 'Teknik Informatika',
        'jenjang'     => 'S1',
        'akreditasi'  => 'B',
    ],
    [
        'fakultas_id' => 1,
        'kode_prodi'  => 'TL',
        'nama_prodi'  => 'Teknik Lingkungan',
        'jenjang'     => 'S1',
        'akreditasi'  => 'B',
    ],
    [
        'fakultas_id' => 2,
        'kode_prodi'  => 'K3',
        'nama_prodi'  => 'Keselamatan dan Kesehatan Kerja',
        'jenjang'     => 'D3',
        'akreditasi'  => 'B',
    ],
    [
        'fakultas_id' => 2,
        'kode_prodi'  => 'ARS',
        'nama_prodi'  => 'Administrasi Rumah Sakit',
        'jenjang'     => 'S1',
        'akreditasi'  => 'B',
    ],
    [
        'fakultas_id' => 3,
        'kode_prodi'  => 'PTI',
        'nama_prodi'  => 'Pendidikan Teknologi Informasi',
        'jenjang'     => 'S1',
        'akreditasi'  => 'B',
    ],
    [
        'fakultas_id' => 4,
        'kode_prodi'  => 'MI',
        'nama_prodi'  => 'Manajemen Informatika',
        'jenjang'     => 'S1',
        'akreditasi'  => 'B',
    ],
    [
        'fakultas_id' => 4,
        'kode_prodi'  => 'BD',
        'nama_prodi'  => 'Bisnis Digital',
        'jenjang'     => 'S1',
        'akreditasi'  => 'B',
    ],
]);

    }
}
