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
    Schema::table('mata_kuliahs', function (Blueprint $table) {
        // 1. Tambahkan Relasi ke Kurikulum
        $table->foreignId('kurikulum_id')
              ->nullable() // Kita buat nullable dulu agar data lama tidak error
              ->after('id')
              ->constrained('kurikulums')
              ->onDelete('cascade');

        // 2. Tambahkan Sifat Mata Kuliah (Penting!)
        // Wajib: Harus diambil.
        // Pilihan: Boleh diambil boleh tidak.
        // MKDU: Wajib Nasional (Agama, Pancasila).
        $table->enum('sifat', ['Wajib', 'Pilihan', 'MKDU'])->default('Wajib')->after('nama_mk');
        
        // 3. Syarat Minimal SKS Lulus (Opsional, fitur advanced)
        // Misal: Skripsi hanya bisa diambil jika sudah lulus 110 SKS
        $table->integer('syarat_sks_lulus')->default(0)->after('sks');
    });
}

public function down(): void
{
    Schema::table('mata_kuliahs', function (Blueprint $table) {
        $table->dropForeign(['kurikulum_id']);
        $table->dropColumn(['kurikulum_id', 'sifat', 'syarat_sks_lulus']);
    });
}

 
};
