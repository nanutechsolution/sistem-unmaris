<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAkademik extends Model
{
    use HasFactory;

    protected $table = 'tahun_akademiks';

    protected $fillable = [
        'kode_tahun',
        'nama_tahun',
        'semester',
        'status',
        'tgl_mulai_krs',
        'tgl_selesai_krs',
        'tgl_mulai_kuliah',
        'tgl_selesai_kuliah',
    ];

    /**
     * Casts tipe data, terutama untuk tanggal.
     */
    protected $casts = [
        'tgl_mulai_krs' => 'date',
        'tgl_selesai_krs' => 'date',
        'tgl_mulai_kuliah' => 'date',
        'tgl_selesai_kuliah' => 'date',
    ];


    public function kelas() {
    return $this->hasMany(Kelas::class);
}
}
