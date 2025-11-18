<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mahasiswa;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nim' => '240101001',
                'nama_lengkap' => 'Radianus Raba Ate',
                'program_studi_id' => 1,
                'status_mahasiswa' => 'Aktif',
                'angkatan' => '2024',
                'email' => 'radianus@example.com',
                'no_hp' => '087750100001',
                'tempat_lahir' => 'Wee Lolo',
                'tanggal_lahir' => '2002-03-11',
                'jenis_kelamin' => 'L',
                'alamat' => 'Desa Lolo Ole, Sumba Barat Daya',
                'foto_profil' => null,
            ],
            [
                'nim' => '240101002',
                'nama_lengkap' => 'Yohana Lede Muda',
                'program_studi_id' => 2,
                'status_mahasiswa' => 'Aktif',
                'angkatan' => '2024',
                'email' => 'yohana@example.com',
                'no_hp' => '087750100002',
                'tempat_lahir' => 'Kodi Balaghar',
                'tanggal_lahir' => '2003-01-20',
                'jenis_kelamin' => 'P',
                'alamat' => 'Kodi Balaghar, Sumba Barat Daya',
                'foto_profil' => null,
            ],
            [
                'nim' => '240101003',
                'nama_lengkap' => 'Mateus Ndapa Rihi',
                'program_studi_id' => 1,
                'status_mahasiswa' => 'Aktif',
                'angkatan' => '2024',
                'email' => 'mateus@example.com',
                'no_hp' => '087750100003',
                'tempat_lahir' => 'Anakalang',
                'tanggal_lahir' => '2002-07-09',
                'jenis_kelamin' => 'L',
                'alamat' => 'Anakalang, Sumba Tengah',
                'foto_profil' => null,
            ],
            [
                'nim' => '240101004',
                'nama_lengkap' => 'Lidia Rambu Duka',
                'program_studi_id' => 3,
                'status_mahasiswa' => 'Aktif',
                'angkatan' => '2024',
                'email' => 'lidia@example.com',
                'no_hp' => '087750100004',
                'tempat_lahir' => 'Tambolaka',
                'tanggal_lahir' => '2003-05-04',
                'jenis_kelamin' => 'P',
                'alamat' => 'Tambolaka, Sumba Barat Daya',
                'foto_profil' => null,
            ],
            [
                'nim' => '240101005',
                'nama_lengkap' => 'Urbanus Gani Ndapa',
                'program_studi_id' => 2,
                'status_mahasiswa' => 'Aktif',
                'angkatan' => '2024',
                'email' => 'urbanus@example.com',
                'no_hp' => '087750100005',
                'tempat_lahir' => 'Kori',
                'tanggal_lahir' => '2002-12-30',
                'jenis_kelamin' => 'L',
                'alamat' => 'Desa Kori, Sumba Barat Daya',
                'foto_profil' => null,
            ],
        ];

        Mahasiswa::insert($data);
    }
}
