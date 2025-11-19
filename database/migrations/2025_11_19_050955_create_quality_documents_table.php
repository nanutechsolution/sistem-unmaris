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
        Schema::create('quality_documents', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20)->unique();
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('category', ['SOP','Kebijakan Mutu','Manual Mutu','Panduan','Formulir','Instruksi Kerja'])->default('SOP');
            $table->string('file_path'); // path ke storage/app/public/...
            $table->text('description')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quality_documents');
    }
};
