<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StructuralPosition;

class StructuralSeeder extends Seeder
{
    public function run(): void
    {
        $positions = [
            // YAYASAN (Grup Atas)
            ['name' => 'Ketua Pembina', 'group' => 'Yayasan', 'urutan' => 1],
            ['name' => 'Ketua Yayasan', 'group' => 'Yayasan', 'urutan' => 2],
            ['name' => 'Sekretaris Yayasan', 'group' => 'Yayasan', 'urutan' => 3],
            ['name' => 'Bendahara Yayasan', 'group' => 'Yayasan', 'urutan' => 4],

            // REKTORAT (Eksekutif)
            ['name' => 'Rektor', 'group' => 'Rektorat', 'urutan' => 10],
            ['name' => 'Wakil Rektor I (Akademik)', 'group' => 'Rektorat', 'urutan' => 11],
            ['name' => 'Wakil Rektor II (Keuangan)', 'group' => 'Rektorat', 'urutan' => 12],
            ['name' => 'Wakil Rektor III (Kemahasiswaan)', 'group' => 'Rektorat', 'urutan' => 13],
        ];

        foreach ($positions as $pos) {
            StructuralPosition::create($pos);
        }
    }
} 