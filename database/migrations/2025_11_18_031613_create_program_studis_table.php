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
       Schema::create('program_studis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_prodi', 10)->unique(); // Kode unik (misal: 'TI-S1')
            $table->string('nama_prodi');
            $table->enum('jenjang', ['D3', 'S1', 'S2', 'S3']);

            // Kolom 'fakultas' akan kita buat sebagai tabel terpisah nanti
            // Untuk sekarang, kita buat sederhana dulu.
            // $table->foreignId('fakultas_id')->constrained();

            $table->string('akreditasi', 5)->nullable(); // Misal: 'A', 'B', 'Baik'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_studis');
    }
};
