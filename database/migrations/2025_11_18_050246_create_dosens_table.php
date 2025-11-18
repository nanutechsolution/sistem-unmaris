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
    Schema::create('dosens', function (Blueprint $table) {
        $table->id();
        $table->string('nidn', 20)->unique(); // Nomor Induk Dosen Nasional
        $table->string('nama_lengkap');

        // Dosen Homebase (terdaftar di prodi mana)
        $table->foreignId('program_studi_id')
              ->nullable()
              ->constrained('program_studis')
              ->onDelete('set null');

        $table->enum('status_dosen', ['Aktif', 'Tidak Aktif', 'Tugas Belajar'])
              ->default('Aktif');

        $table->string('email')->unique()->nullable();
        $table->string('no_hp', 20)->nullable();
        $table->string('foto_profil')->nullable(); // Path ke file foto

        // Relasi ke tabel user (untuk login dosen)
        // $table->foreignId('user_id')->nullable()->constrained('users');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosens');
    }
};
