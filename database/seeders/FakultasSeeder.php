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
            'kode_fakultas' => 'FT', 
            'nama_fakultas' => 'Fakultas Teknik',
            'deskripsi' => 'Selamat datang di Fakultas Teknik. Kami berkomitmen memberikan pendidikan terbaik berbasis karakter dan teknologi.'
        ],
        [
            'kode_fakultas' => 'FKES', 
            'nama_fakultas' => 'Fakultas Kesehatan',
            'deskripsi' => 'Fakultas Kesehatan berfokus pada pengembangan ilmu kesehatan dan pelayanan masyarakat melalui pendidikan profesional dan riset inovatif.'
        ],
        [
            'kode_fakultas' => 'FKIP', 
            'nama_fakultas' => 'Fakultas Keguruan',
            'deskripsi' => 'Fakultas Keguruan mencetak tenaga pendidik profesional yang siap menghadapi tantangan pendidikan modern dan berbasis karakter.'
        ],
        [
            'kode_fakultas' => 'FEB', 
            'nama_fakultas' => 'Fakultas Ekonomi dan Bisnis',
            'deskripsi' => 'FEB mengembangkan keahlian mahasiswa di bidang ekonomi, manajemen, dan bisnis, dengan penekanan pada inovasi dan kewirausahaan.'
        ],
    ]);
}

}
