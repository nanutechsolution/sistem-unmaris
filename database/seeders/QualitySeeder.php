<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\QualityDocument;
use App\Models\QualityAnnouncement;

class QualitySeeder extends Seeder
{
    public function run(): void
    {
        QualityDocument::factory()->count(8)->create();
        QualityAnnouncement::factory()->count(6)->create();
    }
}
