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
        Schema::create('mahasiswas', function (Blueprint $table) {
        $table->id();
        $table->string('nim', 20)->unique(); // Nomor Induk Mahasiswa
        $table->string('nama_lengkap');

        // Relasi ke Program Studi
        $table->foreignId('program_studi_id')
              ->nullable()
              ->constrained('program_studis')
              ->onDelete('set null');

        $table->enum('status_mahasiswa', ['Aktif', 'Cuti', 'Lulus', 'Drop Out', 'Meninggal Dunia'])
              ->default('Aktif');

        $table->string('angkatan', 4); // Misal: "2023", "2024"
        $table->string('email')->unique()->nullable();
        $table->string('no_hp', 20)->nullable();

        // Biodata
        $table->string('tempat_lahir')->nullable();
        $table->date('tanggal_lahir')->nullable();
        $table->enum('jenis_kelamin', ['L', 'P'])->nullable(); // Laki-laki / Perempuan
        $table->text('alamat')->nullable();
        $table->string('foto_profil')->nullable(); // Path ke file foto

        // Relasi ke tabel user (untuk login mahasiswa)
        // $table->foreignId('user_id')->nullable()->constrained('users');

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
