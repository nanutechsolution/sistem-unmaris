<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DosenSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('dosens')->insert([
            [
                'nidn' => '1234567801',
                'nama_lengkap' => 'Dr. Yustinus Lende, M.Pd',
                'program_studi_id' => 1, // PGSD
                'status_dosen' => 'Aktif',
                'email' => 'yustinus.lende@example.com',
                'no_hp' => '087750120001',
                'foto_profil' => null,
            ],
            [
                'nidn' => '1234567802',
                'nama_lengkap' => 'Maria Rambu Pani, S.Pd., M.Pd',
                'program_studi_id' => 2, // PBI
                'status_dosen' => 'Aktif',
                'email' => 'maria.pani@example.com',
                'no_hp' => '087750120002',
                'foto_profil' => null,
            ],
            [
                'nidn' => '1234567803',
                'nama_lengkap' => 'Urbanus Ndiku, S.Kep., M.Kep',
                'program_studi_id' => 3, // Keperawatan
                'status_dosen' => 'Aktif',
                'email' => 'urbanus.ndiku@example.com',
                'no_hp' => '087750120003',
                'foto_profil' => null,
            ],
            [
                'nidn' => '1234567804',
                'nama_lengkap' => 'Kristina Dappa, S.KM., M.Kes',
                'program_studi_id' => 4, // KESMAS
                'status_dosen' => 'Aktif',
                'email' => 'kristina.dappa@example.com',
                'no_hp' => '087750120004',
                'foto_profil' => null,
            ],
            [
                'nidn' => '1234567805',
                'nama_lengkap' => 'Benardus Rato Wulla, S.E., M.M',
                'program_studi_id' => 5, // Manajemen
                'status_dosen' => 'Aktif',
                'email' => 'benardus.wulla@example.com',
                'no_hp' => '087750120005',
                'foto_profil' => null,
            ],
        ]);
    }
}
