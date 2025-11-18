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
    Schema::create('krs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->onDelete('cascade');
        $table->foreignId('tahun_akademik_id')->constrained('tahun_akademiks')->onDelete('cascade');

        // Dosen PA yang menyetujui (bisa diisi nanti)
        $table->foreignId('dosen_pa_id')->nullable()->constrained('dosens')->onDelete('set null');

        $table->integer('total_sks')->default(0);
        $table->enum('status', ['Draft', 'Submitted', 'Approved', 'Rejected'])->default('Draft');

        $table->timestamps();

        // Seorang mahasiswa hanya boleh punya 1 KRS per tahun akademik
        $table->unique(['mahasiswa_id', 'tahun_akademik_id']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('krs');
    }
};
