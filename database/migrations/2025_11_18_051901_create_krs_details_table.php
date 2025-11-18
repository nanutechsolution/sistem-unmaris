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
    Schema::create('krs_details', function (Blueprint $table) {
        $table->id();
        $table->foreignId('krs_id')->constrained('krs')->onDelete('cascade');
        $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');

        // Data ini diduplikasi dari 'kelas' untuk kemudahan
        $table->foreignId('mata_kuliah_id')->constrained('mata_kuliahs')->onDelete('cascade');
        $table->integer('sks');

        // Status per-matakuliah, jika Dosen PA bisa menolak 1 MK saja
        $table->enum('status_ambil', ['Pending', 'Approved', 'Rejected'])->default('Pending');

        // Untuk KHS nanti
        $table->string('nilai_huruf', 2)->nullable();
        $table->float('nilai_angka', 5, 2)->nullable();

        $table->timestamps();

        // Mahasiswa tidak bisa ambil kelas yang sama 2x
        $table->unique(['krs_id', 'kelas_id']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('krs_details');
    }
};
