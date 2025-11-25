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
            $table->string('title')->nullable();
            $table->text('description')->nullable();

            // 1. GANTI 'image_path' JADI INI:
            // Kolom ini menampung path gambar (jika type=image) ATAU path video (jika type=video)
            $table->string('file_path');

            // 2. KOLOM BARU: Jenis File
            $table->enum('type', ['image', 'video'])->default('image');

            // 3. KOLOM BARU (Opsional tapi Penting): Cover Video
            // Jika type=video, kita butuh gambar preview (poster) biar tidak hitam saat loading
            $table->string('poster_path')->nullable();

            $table->string('button_text')->nullable();
            $table->string('button_url')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('active')->default(true);
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
