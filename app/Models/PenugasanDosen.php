<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenugasanDosen extends Model
{
    use HasFactory;

    protected $table = 'penugasan_dosens';

    protected $fillable = [
        'dosen_id',
        'program_studi_id', // Prodi tempat dia DITUGASKAN (bukan homebase)
        'tahun_akademik_id',
        'status_penugasan', // Tetap, LB, Tamu
    ];

    // Relasi ke Dosen
    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    // Relasi ke Prodi TUJUAN
    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    // Ganti nama fungsi dan target modelnya
    public function tahunAkademik()
    {
        return $this->belongsTo(TahunAkademik::class, 'tahun_akademik_id');
    }
}
