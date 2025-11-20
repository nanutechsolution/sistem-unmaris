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
    Schema::create('kurikulums', function (Blueprint $table) {
        $table->id();
        $table->foreignId('program_studi_id')->constrained('program_studis')->onDelete('cascade');
        $table->string('nama_kurikulum'); // e.g. "Kurikulum 2024 MBKM"
        $table->year('tahun_mulai'); // 2024
        $table->boolean('aktif')->default(false); // Hanya 1 kurikulum yg aktif per prodi biasanya
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kurikulums');
    }
};
