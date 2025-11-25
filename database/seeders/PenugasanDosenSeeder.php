<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenugasanDosenSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil ID Tahun Akademik yang Aktif (Sesuai tabel baru: tahun_akademiks)
        // Perhatikan: Kolom status pakai Enum 'Aktif', bukan boolean true
        $tahunAktif = DB::table('tahun_akademiks')->where('status', 'Aktif')->first();

        if (!$tahunAktif) {
            $this->command->error("Tahun akademik aktif tidak ditemukan! Jalankan TahunAkademikSeeder dulu dan set satu semester menjadi Aktif.");
            return;
        }

        // 2. Ambil Semua Dosen yang punya Homebase
        $semuaDosen = DB::table('dosens')->whereNotNull('program_studi_id')->get();

        $count = 0;
        foreach ($semuaDosen as $dosen) {

            // 3. Masukkan ke Tabel Penugasan (History)
            DB::table('penugasan_dosens')->updateOrInsert(
                [
                    // Kunci Unik: Dosen + Prodi + Tahun Akademik
                    'dosen_id' => $dosen->id,
                    'program_studi_id' => $dosen->program_studi_id, // Sesuai Homebase
                    'tahun_akademik_id' => $tahunAktif->id, // <-- PERUBAHAN DISINI
                ],
                [
                    'status_penugasan' => 'Tetap', 
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
            $count++;
        }

        // Pakai nama_tahun sesuai tabel baru
        $this->command->info("Berhasil menugaskan {$count} dosen ke Tahun Akademik {$tahunAktif->nama_tahun}");

        // --- BONUS: SIMULASI DOSEN MENGAJAR LINTAS PRODI (DOSEN LB) ---
        
        // Contoh: Pak ADELBERTUS (TI) bantu mengajar di Bisnis Digital
        $pakAdel = DB::table('dosens')->where('nama_lengkap', 'like', '%ADELBERTUS%')->first();
        $prodiBD = DB::table('program_studis')->where('kode_prodi', 'BD')->first();

        if ($pakAdel && $prodiBD) {
            DB::table('penugasan_dosens')->insertOrIgnore([
                'dosen_id' => $pakAdel->id,
                'program_studi_id' => $prodiBD->id, // Mengajar di BD
                'tahun_akademik_id' => $tahunAktif->id, // <-- PERUBAHAN DISINI
                'status_penugasan' => 'LB', // Statusnya LB
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $this->command->info("Simulasi: Pak Adelbertus ditambahkan sebagai Dosen LB di Bisnis Digital.");
        }
    }
}