<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image_path'); // Foto Fasilitas

            // Kategori agar rapi
            $table->enum('category', ['Laboratorium', 'Gedung', 'Olahraga', 'Penunjang', 'Lainnya'])->default('Lainnya');

            $table->integer('order')->default(0); // Untuk urutan tampilan
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facilities');
    }
};
