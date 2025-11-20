<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PmbGelombang extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun_akademik_id', 
        'nama_gelombang',
        'promo',
        'tgl_mulai',
        'tgl_selesai',
        'aktif'
    ];

    protected $casts = [
        'tgl_mulai' => 'date',
        'tgl_selesai' => 'date',
        'aktif' => 'boolean',
    ];

    public function tahunAkademik()
    {
        return $this->belongsTo(TahunAkademik::class);
    }
    
    // Helper untuk cek apakah gelombang sedang buka berdasarkan tanggal
    public function isOpen()
    {
        $now = now();
        return $this->aktif && $now->between($this->tgl_mulai, $this->tgl_selesai);
    }
}