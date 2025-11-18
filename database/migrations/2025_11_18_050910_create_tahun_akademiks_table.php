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
    Schema::create('tahun_akademiks', function (Blueprint $table) {
        $table->id();
        // e.g., "20241" (2024 Ganjil), "20242" (2024 Genap)
        $table->string('kode_tahun', 10)->unique();
        $table->string('nama_tahun'); // e.g., "2024/2025 Ganjil"

        $table->enum('semester', ['Ganjil', 'Genap']);

        // 'Aktif' berarti periode KRS/Kuliah sedang berjalan
        $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Tidak Aktif');

        // Periode penting
        $table->date('tgl_mulai_krs')->nullable();
        $table->date('tgl_selesai_krs')->nullable();
        $table->date('tgl_mulai_kuliah')->nullable();
        $table->date('tgl_selesai_kuliah')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahun_akademiks');
    }
};
