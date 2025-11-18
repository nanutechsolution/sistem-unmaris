<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MataKuliahSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('mata_kuliahs')->insert([

            // ======================
            // PRODI 1 — PGSD
            // ======================
            [
                'kode_mk'          => 'PGSD101',
                'nama_mk'          => 'Pengantar Pendidikan',
                'program_studi_id' => 1,
                'sks'              => 3,
                'semester'         => 1,
            ],
            [
                'kode_mk'          => 'PGSD102',
                'nama_mk'          => 'Psikologi Pendidikan',
                'program_studi_id' => 1,
                'sks'              => 2,
                'semester'         => 1,
            ],
            [
                'kode_mk'          => 'PGSD201',
                'nama_mk'          => 'Perkembangan Anak',
                'program_studi_id' => 1,
                'sks'              => 3,
                'semester'         => 2,
            ],

            // ======================
            // PRODI 2 — Pendidikan Bahasa Inggris
            // ======================
            [
                'kode_mk'          => 'PBI101',
                'nama_mk'          => 'Basic Grammar',
                'program_studi_id' => 2,
                'sks'              => 3,
                'semester'         => 1,
            ],
            [
                'kode_mk'          => 'PBI102',
                'nama_mk'          => 'Introduction to Linguistics',
                'program_studi_id' => 2,
                'sks'              => 2,
                'semester'         => 1,
            ],
            [
                'kode_mk'          => 'PBI201',
                'nama_mk'          => 'Speaking I',
                'program_studi_id' => 2,
                'sks'              => 3,
                'semester'         => 2,
            ],

            // ======================
            // PRODI 3 — D3 Keperawatan
            // ======================
            [
                'kode_mk'          => 'KEP101',
                'nama_mk'          => 'Dasar-dasar Keperawatan',
                'program_studi_id' => 3,
                'sks'              => 3,
                'semester'         => 1,
            ],
            [
                'kode_mk'          => 'KEP102',
                'nama_mk'          => 'Keterampilan Klinik Dasar',
                'program_studi_id' => 3,
                'sks'              => 2,
                'semester'         => 1,
            ],
            [
                'kode_mk'          => 'KEP201',
                'nama_mk'          => 'Keperawatan Medikal Bedah I',
                'program_studi_id' => 3,
                'sks'              => 3,
                'semester'         => 2,
            ],

            // ======================
            // PRODI 4 — Kesehatan Masyarakat
            // ======================
            [
                'kode_mk'          => 'KES101',
                'nama_mk'          => 'Pengantar Kesehatan Masyarakat',
                'program_studi_id' => 4,
                'sks'              => 3,
                'semester'         => 1,
            ],
            [
                'kode_mk'          => 'KES102',
                'nama_mk'          => 'Biostatistik I',
                'program_studi_id' => 4,
                'sks'              => 2,
                'semester'         => 1,
            ],
            [
                'kode_mk'          => 'KES201',
                'nama_mk'          => 'Epidemiologi Dasar',
                'program_studi_id' => 4,
                'sks'              => 3,
                'semester'         => 2,
            ],

            // ======================
            // PRODI 5 — Manajemen
            // ======================
            [
                'kode_mk'          => 'MAN101',
                'nama_mk'          => 'Pengantar Manajemen',
                'program_studi_id' => 5,
                'sks'              => 3,
                'semester'         => 1,
            ],
            [
                'kode_mk'          => 'MAN102',
                'nama_mk'          => 'Pengantar Akuntansi',
                'program_studi_id' => 5,
                'sks'              => 3,
                'semester'         => 1,
            ],
            [
                'kode_mk'          => 'MAN201',
                'nama_mk'          => 'Manajemen Pemasaran',
                'program_studi_id' => 5,
                'sks'              => 3,
                'semester'         => 2,
            ],

        ]);
    }
}
