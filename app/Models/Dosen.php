<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $fillable = [
        'nidn',
        'nama_lengkap',
        'program_studi_id',
        'status_dosen',
        'email',
        'no_hp',
        'foto_profil',
        // 'user_id',
    ];

    /**
     * Relasi ke Program Studi (Dosen ini homebase-nya di prodi apa).
     */
    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    public function kelasYangDiampu() { // 'kelas' sudah dipakai, jadi kita ganti
    return $this->hasMany(Kelas::class);
}
}
