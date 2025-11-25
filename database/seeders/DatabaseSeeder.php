<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersSeeder::class,
            PageSeeder::class,
            FakultasSeeder::class,
            ProgramStudiSeeder::class,
            CategoriesSeeder::class,
            PostsSeeder::class,
            DosenSeeder::class,
            TahunAkademikSeeder::class,
            PenugasanDosenSeeder::class,
            ProgramStudiKaprodiSeeder::class,
            FakultasDekanSeeder::class,
            QualitySeeder::class,
            DokumenKategoriSeeder::class,
            DokumenSeeder::class,
            MataKuliahSeeder::class,
        ]);
    }
}
