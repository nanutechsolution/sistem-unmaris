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
    Schema::create('posts', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('slug')->unique();
        $table->longText('content'); // Dari Trix Editor

        // Relasi
        $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
        $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Penulis

        $table->string('featured_image')->nullable(); // Path ke gambar
        $table->enum('status', ['Published', 'Draft'])->default('Draft');
        $table->timestamp('published_at')->nullable(); // Kapan dipublikasikan

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
