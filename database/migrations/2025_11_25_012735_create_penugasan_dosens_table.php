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
        Schema::create('penugasan_dosens', function (Blueprint $table) {
            $table->id();

            // 1. Relasi ke Dosen (Siapa yg ditugaskan)
            // cascadeOnDelete artinya jika data dosen dihapus, riwayat mengajar ikut hilang (biar bersih)
            $table->foreignId('dosen_id')
                ->constrained('dosens')
                ->cascadeOnDelete();

            // 2. Relasi ke Prodi (Dimana dia mengajar semester ini)
            $table->foreignId('program_studi_id')
                ->constrained('program_studis')
                ->cascadeOnDelete();

            // 3. Relasi ke Waktu (Kapan dia mengajar)
            $table->foreignId('tahun_akademik_id')
                ->constrained('tahun_akademiks') // Nyambung ke tabel baru Bapak
                ->cascadeOnDelete();

            // 4. Status Penugasan (Penting untuk PDDIKTI)
            // Tetap = Dosen Homebase/Tetap di prodi itu
            // LB = Dosen Luar Biasa (bantu mengajar)
            // Tamu = Dosen Tamu
            $table->enum('status_penugasan', ['Tetap', 'LB', 'Tamu'])
                ->default('Tetap');

            $table->timestamps();

            // 5. Mencegah Double Input
            // Logic: 1 Dosen tidak boleh diinput 2 kali di Prodi yg sama pada Semester yg sama
            $table->unique(['dosen_id', 'program_studi_id', 'tahun_akademik_id'], 'unique_penugasan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penugasan_dosens');
    }
};
