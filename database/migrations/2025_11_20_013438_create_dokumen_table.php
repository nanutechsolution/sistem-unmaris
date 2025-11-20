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
       Schema::create('dokumen', function (Blueprint $table) {
    $table->id();
    $table->string('judul', 255);
    $table->string('slug', 255)->unique();
    $table->text('deskripsi')->nullable();
    $table->string('file_path', 500);
    $table->string('file_type', 50);
    $table->bigInteger('file_size');
    $table->foreignId('fakultas_id')->nullable()->constrained('fakultas')->onDelete('set null');
    $table->foreignId('program_studi_id')->nullable()->constrained('program_studis')->onDelete('set null');
    $table->foreignId('kategori_id')->nullable()->constrained('dokumen_kategori')->onDelete('set null');
    $table->enum('akses', ['Publik', 'Mahasiswa', 'Dosen', 'Admin'])->default('Publik');
    $table->integer('download_count')->default(0);
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen');
    }
};
