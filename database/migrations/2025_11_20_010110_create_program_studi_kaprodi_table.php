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
        Schema::create('program_studi_kaprodi', function (Blueprint $table) {
    $table->id();
    $table->foreignId('program_studi_id')->constrained('program_studis')->onDelete('cascade');
    $table->foreignId('dosen_id')->constrained('dosens')->onDelete('cascade');
    $table->date('mulai');
    $table->date('selesai')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_studi_kaprodi');
    }
};
