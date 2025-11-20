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
    Schema::create('mk_prasyarats', function (Blueprint $table) {
        $table->id();
        
        // Mata Kuliah Utama
        $table->foreignId('mata_kuliah_id')->constrained('mata_kuliahs')->onDelete('cascade');
        
        // Mata Kuliah Syaratnya (Prerequisite)
        $table->foreignId('prasyarat_id')->constrained('mata_kuliahs')->onDelete('cascade');
        
        // Syarat nilai minimal (Misal: Harus lulus Algoritma 1 minimal C)
        $table->string('nilai_min', 2)->default('D'); 

        $table->timestamps();
        
        // Mencegah duplikasi
        $table->unique(['mata_kuliah_id', 'prasyarat_id']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mk_prasyarats');
    }
};
