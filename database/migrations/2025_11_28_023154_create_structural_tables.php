<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. MASTER JABATAN (Definisi Posisi)
        // Contoh isi: "Rektor", "Wakil Rektor I", "Ketua Yayasan"
        Schema::create('structural_positions', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama Jabatan
            $table->enum('group', ['Rektorat', 'Yayasan', 'Senat', 'Lainnya'])->default('Rektorat');
            $table->integer('urutan')->default(0); // Untuk sorting hierarki
            $table->timestamps();
        });

        // 2. RIWAYAT PENUGASAN (Siapa menjabat apa & kapan)
        Schema::create('structural_assignments', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke Jabatan
            $table->foreignId('structural_position_id')
                  ->constrained('structural_positions')
                  ->cascadeOnDelete();

            // Sumber SDM: Internal (Dosen)
            $table->foreignId('dosen_id')->nullable()
                  ->constrained('dosens')
                  ->nullOnDelete();

            // Sumber SDM: Eksternal (Manual)
            $table->string('name_custom')->nullable(); // Jika bukan dosen
            $table->string('photo_custom')->nullable(); // Path foto khusus jabatan ini

            // Periode Menjabat (PENTING UNTUK SEJARAH)
            $table->date('start_date');
            $table->date('end_date')->nullable(); // Null = Masih Menjabat (Aktif)
            $table->boolean('is_active')->default(true); // Helper flag

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('structural_assignments');
        Schema::dropIfExists('structural_positions');
    }
};