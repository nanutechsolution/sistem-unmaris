<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dosens', function (Blueprint $table) {
            $table->id();

            // --- IDENTITAS UTAMA ---
            // NIDN dibuat nullable karena di Excel ada yang kosong
            $table->string('nidn', 20)->nullable()->unique()->comment('Nomor Induk Dosen Nasional');
            $table->string('nuptk', 50)->nullable()->comment('Nomor Unik Pendidik dan Tenaga Kependidikan');
            $table->string('nama_lengkap');

            // --- HOMEBASE (INDUK) ---
            // Ini adalah Prodi Induk/Homebase Administrasi (Sesuai SK Pengangkatan)
            // BUKAN tempat mengajar semester ini (itu nanti di tabel penugasan)
            $table->foreignId('program_studi_id')
                  ->nullable()
                  ->constrained('program_studis')
                  ->nullOnDelete();

            // --- DATA PRIBADI (Sesuai Excel) ---
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('agama')->nullable();

            // --- KONTAK & AKUN ---
            $table->string('email')->unique()->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->string('foto_profil')->nullable();

            // --- STATUS KEPEGAWAIAN GLOBAL ---
            // Apakah dia masih pegawai di kampus ini?
            $table->enum('status_kepegawaian', ['Aktif', 'Keluar', 'Pensiun', 'Tugas Belajar'])
                  ->default('Aktif');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dosens');
    }
};