<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Master Komponen Biaya (Jenis-jenis tagihan)
        Schema::create('finance_components', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Contoh: SPP, Uang Gedung, Wisuda
            $table->enum('tipe', ['Per Semester', 'Sekali Bayar', 'SKS'])->default('Per Semester');
            $table->boolean('is_wajib')->default(true); // Wajib dibayar semua mahasiswa?
            $table->timestamps();
        });

        // 2. Master Tarif (Nominal harga per Angkatan & Prodi)
        Schema::create('finance_rates', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke jenis biaya
            $table->foreignId('finance_component_id')
                  ->constrained('finance_components')
                  ->onDelete('cascade');

            // Relasi ke Prodi (Jika NULL = Berlaku Umum untuk semua prodi)
            $table->foreignId('program_studi_id')
                  ->nullable()
                  ->constrained('program_studis')
                  ->onDelete('cascade');

            $table->string('angkatan', 4); // Contoh: 2024, 2025
            $table->decimal('nominal', 15, 2); // Angka uang (Max 15 digit, 2 desimal)
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('finance_rates');
        Schema::dropIfExists('finance_components');
    }
};