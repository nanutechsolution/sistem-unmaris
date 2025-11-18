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
        Schema::table('program_studis', function (Blueprint $table) {
            // Tambahkan kolom foreign key
            $table->foreignId('fakultas_id')
                  ->nullable() // Kita buat nullable dulu agar tidak error di data lama
                  ->after('id') // Posisikan setelah kolom 'id'
                  ->constrained('fakultas') // Menghubungkan ke tabel 'fakultas'
                  ->onDelete('set null'); // Jika fakultas dihapus, prodi jadi null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('program_studis', function (Blueprint $table) {
            $table->dropForeign(['fakultas_id']);
            $table->dropColumn('fakultas_id');
        });
    }
};
