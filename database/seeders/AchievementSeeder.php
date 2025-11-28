<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Achievement;

class AchievementSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'title' => 'Juara 1 Web Design Competition',
                'event_name' => 'IT Fest Nusa Tenggara 2024',
                'winner_name' => 'Tim Cyber Unmaris',
                'prodi_name' => 'Teknik Informatika',
                'level' => 'Provinsi',
                'category' => 'Akademik',
                'medal' => 'Gold',
                'date' => '2024-10-15',
            ],
            [
                'title' => 'Gold Medal Pencak Silat',
                'event_name' => 'POMNAS XVII',
                'winner_name' => 'Budi Santoso',
                'prodi_name' => 'Manajemen',
                'level' => 'Nasional',
                'category' => 'Olahraga',
                'medal' => 'Gold',
                'date' => '2024-08-20',
            ],
            [
                'title' => 'Best Paper Award',
                'event_name' => 'International Conference on Tech',
                'winner_name' => 'Siti Aminah',
                'prodi_name' => 'Sistem Informasi',
                'level' => 'Internasional',
                'category' => 'Akademik',
                'medal' => 'Gold',
                'date' => '2025-01-10',
            ],
            [
                'title' => 'Juara 2 Paduan Suara',
                'event_name' => 'Festival Seni Mahasiswa',
                'winner_name' => 'UKM Voca Maris',
                'prodi_name' => 'Lintas Prodi',
                'level' => 'Lokal',
                'category' => 'Seni',
                'medal' => 'Silver',
                'date' => '2024-12-05',
            ],
        ];

        foreach ($data as $item) {
            Achievement::create($item);
        }
    }
}