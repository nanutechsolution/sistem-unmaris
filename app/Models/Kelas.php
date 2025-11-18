<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'tahun_akademik_id',
        'mata_kuliah_id',
        'dosen_id',
        'nama_kelas',
        'kuota',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'ruangan',
    ];

    protected $casts = [
        'jam_mulai' => 'datetime:H:i', // Format 24-jam
        'jam_selesai' => 'datetime:H:i',
    ];

    public function tahunAkademik()
    {
        return $this->belongsTo(TahunAkademik::class);
    }

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class);
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }


    public function krsDetails() {
    return $this->hasMany(KrsDetail::class);
}
}
