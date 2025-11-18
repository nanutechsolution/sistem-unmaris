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
    Schema::create('kelas', function (Blueprint $table) {
        $table->id();

        // Relasi
        $table->foreignId('tahun_akademik_id')->constrained('tahun_akademiks')->onDelete('cascade');
        $table->foreignId('mata_kuliah_id')->constrained('mata_kuliahs')->onDelete('cascade');
        $table->foreignId('dosen_id')->nullable()->constrained('dosens')->onDelete('set null');

        $table->string('nama_kelas'); // e.g., "A", "B", "Malam"
        $table->integer('kuota');

        // Info Jadwal
        $table->string('hari')->nullable();
        $table->time('jam_mulai')->nullable();
        $table->time('jam_selesai')->nullable();
        $table->string('ruangan')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
