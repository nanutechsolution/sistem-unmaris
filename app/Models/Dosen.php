<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosens'; // Pastikan nama tabel benar

    // 1. Update Fillable sesuai struktur tabel baru
    protected $fillable = [
        'nidn',
        'nuptk',            // Baru
        'nama_lengkap',
        'program_studi_id', // Homebase
        'jenis_kelamin',    // Baru
        'tempat_lahir',     // Baru
        'tanggal_lahir',    // Baru
        'agama',            // Baru
        'status_kepegawaian', // Aktif/Tugas Belajar/Keluar/Pensiun
        'email',
        'no_hp',
        'foto_profil',
    ];

    // 2. Casting agar Tanggal Lahir otomatis jadi Objek Date (Carbon)
    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    /**
     * Relasi ke Program Studi (Homebase Administrasi).
     */
    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }

    /**
     * Relasi ke Riwayat Penugasan Mengajar (Tabel Scalable yang kita buat).
     * Ini mencatat sejarah dosen mengajar di prodi mana saja per semester.
     */
    // public function penugasan()
    // {
    //     return $this->hasMany(PenugasanDosen::class, 'dosen_id');
    // }

    /**
     * (Opsional) Relasi jika masih pakai tabel Kelas lama
     */
    public function kelasYangDiampu()
    {
        return $this->hasMany(Kelas::class);
    }
}
