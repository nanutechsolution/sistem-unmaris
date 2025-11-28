<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Contoh: Juara 1 Lomba Coding Nasional
            $table->string('event_name'); // Contoh: GEMASTIK 2025

            $table->string('winner_name'); // Nama Mahasiswa / Tim
            $table->string('prodi_name')->nullable(); // Asal Prodi

            $table->enum('level', ['Internasional', 'Nasional', 'Provinsi', 'Lokal']);
            $table->enum('category', ['Akademik', 'Olahraga', 'Seni', 'Lainnya']);
            $table->enum('medal', ['Gold', 'Silver', 'Bronze', 'Participant'])->default('Gold'); // Untuk warna badge

            $table->text('description')->nullable();
            $table->string('image_path')->nullable(); // Foto saat menang/pegang piala
            $table->date('date'); // Tanggal kejadian

            $table->boolean('is_featured')->default(false); // Tampil di Home?
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};
