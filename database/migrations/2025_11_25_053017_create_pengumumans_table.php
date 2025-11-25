<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengumumans', function (Blueprint $table) {
            $table->id();

            // SEO & Identitas
            $table->string('judul');
            $table->string('slug')->unique(); // Untuk URL cantik

            // Konten
            $table->text('ringkasan')->nullable(); // Untuk preview di card
            $table->longText('konten'); // Isi lengkap (HTML/Rich Text)
            $table->string('thumbnail')->nullable(); // Gambar cover (opsional)
            $table->string('file_lampiran')->nullable(); // File PDF/Docx

            // Metadata
            $table->enum('kategori', ['Akademik', 'Kemahasiswaan', 'Beasiswa', 'Umum'])->default('Umum');
            $table->string('penulis')->default('Humas UNMARIS');
            $table->unsignedBigInteger('views')->default(0); // Hitung jumlah pembaca

            // Logic Tayang (Scalable)
            $table->boolean('is_pinned')->default(false); // Sticky post
            $table->enum('status', ['Draft', 'Published', 'Archived'])->default('Draft');
            $table->dateTime('published_at')->nullable(); // Kapan mulai tayang otomatis

            $table->timestamps();
            $table->softDeletes(); // Jangan langsung hapus permanen (Safety)

            // Indexing untuk performa (Scalability)
            $table->index(['status', 'published_at']);
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengumumans');
    }
};
