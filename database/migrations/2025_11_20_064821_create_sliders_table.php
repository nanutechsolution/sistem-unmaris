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
    Schema::create('sliders', function (Blueprint $table) {
        $table->id();
        $table->string('title')->nullable(); // Judul besar
        $table->text('description')->nullable(); // Sub-judul
        $table->string('image_path'); // Gambar background
        $table->string('button_text')->nullable(); // Teks tombol (misal: Daftar)
        $table->string('button_url')->nullable(); // Link tombol
        $table->integer('order')->default(0); // Urutan tampil
        $table->boolean('active')->default(true); // Status aktif/tidak
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
