<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_organizations', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // BEM, Mapala
            $table->string('kategori'); // Organisasi, Seni, Olahraga
            $table->text('deskripsi');
            $table->string('logo')->nullable(); // Path gambar logo
            
            // Styling (Bisa diatur admin atau default)
            $table->string('icon')->default('fas fa-users'); // FontAwesome Class
            $table->string('warna')->default('bg-blue-600'); // Tailwind Class
            
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_organizations');
    }
};