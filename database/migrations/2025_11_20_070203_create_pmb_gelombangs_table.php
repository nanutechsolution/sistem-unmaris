<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     public function up(): void
{
        
    /**
     * Run the migrations.
     */
     Schema::create('pmb_gelombangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahun_akademik_id')->constrained('tahun_akademiks')->onDelete('cascade');
            $table->string('nama_gelombang'); // e.g., "Gelombang 1", "Jalur Prestasi"
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->boolean('aktif')->default(false); // Status Buka/Tutup manual
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pmb_gelombangs');
    }
};
