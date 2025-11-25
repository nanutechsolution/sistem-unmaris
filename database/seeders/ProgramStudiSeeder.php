<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProgramStudiSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('program_studis')->insert([
            [
                'fakultas_id' => 1, // Pastikan ID Fakultas 1 ada
                'kode_prodi'  => 'TI',
                'nama_prodi'  => 'Teknik Informatika',
                'jenjang'     => 'S1', // Sesuai Excel
                'akreditasi'  => 'B',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'fakultas_id' => 1,
                'kode_prodi'  => 'TL',
                'nama_prodi'  => 'Teknik Lingkungan',
                'jenjang'     => 'S1', // Sesuai Excel
                'akreditasi'  => 'B',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                // PERBAIKAN: Di Excel Bapak, K3 itu S1 (bukan D3)
                // Cek data: ANASTASIA YASHINTA THEEDENS
                'fakultas_id' => 2,
                'kode_prodi'  => 'K3',
                'nama_prodi'  => 'Keselamatan dan Kesehatan Kerja',
                'jenjang'     => 'S1', 
                'akreditasi'  => 'B',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'fakultas_id' => 2,
                'kode_prodi'  => 'ARS',
                'nama_prodi'  => 'Administrasi Rumah Sakit',
                'jenjang'     => 'S1', // Sesuai Excel
                'akreditasi'  => 'B',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'fakultas_id' => 3,
                'kode_prodi'  => 'PTI',
                'nama_prodi'  => 'Pendidikan Teknologi Informasi',
                'jenjang'     => 'S1', // Sesuai Excel
                'akreditasi'  => 'B',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                // PERBAIKAN: Di Excel Bapak, MI itu D3 (bukan S1)
                // Cek data: ALEXANDER ADIS
                'fakultas_id' => 4,
                'kode_prodi'  => 'MI',
                'nama_prodi'  => 'Manajemen Informatika',
                'jenjang'     => 'D3',
                'akreditasi'  => 'B',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'fakultas_id' => 4,
                'kode_prodi'  => 'BD',
                'nama_prodi'  => 'Bisnis Digital',
                'jenjang'     => 'S1', // Sesuai Excel
                'akreditasi'  => 'B',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ]);
    }
}