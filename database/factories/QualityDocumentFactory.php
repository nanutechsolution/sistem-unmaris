<?php

namespace Database\Factories;

use App\Models\QualityDocument;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class QualityDocumentFactory extends Factory
{
    protected $model = QualityDocument::class;

    public function definition(): array
    {
        $categories = [
            'SOP',
            'Kebijakan Mutu',
            'Manual Mutu',
            'Panduan',
            'Formulir',
            'Instruksi Kerja',
        ];

        // Judul realistis seperti dokumen mutu
        $realisticTitles = [
            'Prosedur Pengendalian Dokumen',
            'Prosedur Manajemen Risiko',
            'Instruksi Kerja Penggunaan APD',
            'Panduan Audit Internal Mutu',
            'Prosedur Pelayanan Mahasiswa Baru',
            'Manual Mutu Sistem Manajemen Universitas',
            'Kebijakan Mutu Fakultas Teknik',
        ];

        $title = fake()->randomElement($realisticTitles);

        return [
            'title'           => $title,
            'slug'            => Str::slug($title) . '-' . Str::random(5),

            // nomor dokumen realistis ISO 9001
            'kode' => 'DOC-' . fake()->numerify('###/SMK/##'),

            // kategori sesuai ENUM
            'category'        => fake()->randomElement($categories),

            // versi realistis
            // 'version'         => fake()->randomElement(['1.0', '1.1', '2.0', '2.1']),

            // tanggal penerbitan
            'published_at'     => fake()->dateTimeBetween('-2 years', 'now'),

            // user yang membuat (ambil acak dari tabel user)
            // 'user_id'         => User::inRandomOrder()->first()->id ?? User::factory(),

            // file dummy yang tampak seperti dokumen asli
            'file_path'       => 'documents/' . Str::random(10) . '.pdf',

            // deskripsi realistis
            'description'     => fake()->sentence(10),
        ];
    }
}
