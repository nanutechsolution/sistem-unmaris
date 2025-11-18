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
    Schema::create('mata_kuliahs', function (Blueprint $table) {
        $table->id();
        $table->string('kode_mk', 20)->unique(); // Kode Mata Kuliah, misal: TIF-101
        $table->string('nama_mk'); // Nama Mata Kuliah, misal: Algoritma & Pemrograman

        // Relasi ke Prodi (Mata Kuliah ini milik prodi mana)
        $table->foreignId('program_studi_id')
              ->nullable()
              ->constrained('program_studis')
              ->onDelete('set null');

        $table->integer('sks'); // Jumlah SKS
        $table->integer('semester'); // Ditawarkan di semester berapa

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mata_kuliahs');
    }
};
