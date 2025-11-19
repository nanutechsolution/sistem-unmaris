<?php

namespace Database\Factories;

use App\Models\QualityDocument;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QualityDocument>
 */
class QualityDocumentFactory extends Factory
{
    /**
     * Nama model yang sesuai dengan factory ini.
     *
     * @var string
     */
    protected $model = QualityDocument::class;

    /**
     * Definisikan status default model.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Daftar kategori yang valid sesuai dengan enum di Migration
        $categories = ['SOP', 'Kebijakan Mutu', 'Manual Mutu', 'Panduan', 'Formulir', 'Instruksi Kerja'];

        $title = fake()->sentence(5, true);
        $category = fake()->randomElement($categories);

        return [
            // Kode Dokumen: Contoh format [Kategori]-[Nomor Unik]
            'kode' => Str::upper(Str::substr($category, 0, 3)) . '-' . fake()->unique()->numerify('###'),

            // Judul Dokumen
            'title' => $title,

            // Slug dibuat dari judul + unik ID untuk menghindari duplikasi
            'slug' => Str::slug($title) . '-' . fake()->unique()->uuid(),

            // Kategori dari daftar enum yang telah ditentukan
            'category' => $category,

            // Simulasikan file path (di storage/app/public/quality-docs/...)
            'file_path' => 'quality-docs/' . Str::slug($title) . '-' . fake()->randomLetter() . '.pdf',

            // Deskripsi
            'description' => fake()->paragraph(2),

            // Tanggal Publikasi (dapat berupa null atau tanggal 7 hari terakhir)
            'published_at' => fake()->optional(0.8)->dateTimeBetween('-1 year', 'now'),

            // ID Pengguna yang membuat. Asumsi User ID 1 atau acak dari User model.
            'created_by' => User::inRandomOrder()->first()->id ?? 1,

            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'updated_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
