<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi massal.
     */
    protected $fillable = [
        'nim',
        'nama_lengkap',
        'program_studi_id',
        'kurikulum_id',
        'status_mahasiswa',
        'angkatan',
        'email',
        'no_hp',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'foto_profil',
        // 'user_id',
    ];

    /**
     * Tipe data (Casting) untuk kolom tertentu.
     */
    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    /**
     * Relasi ke Program Studi (Mahasiswa ini milik prodi apa).
     */
    public function programStudi(){return $this->belongsTo(ProgramStudi::class);}
    public function krs() {return $this->hasMany(Krs::class);}
    /**
     * Relasi ke Kurikulum (Mahasiswa ini ikut kurikulum versi mana)
     */
    public function kurikulum(){return $this->belongsTo(Kurikulum::class);}
}
