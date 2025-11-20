<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FakultasDekan extends Model
{
    use HasFactory;

    protected $table = 'fakultas_dekan';
    
    protected $fillable = [
        'fakultas_id',
        'dosen_id',
        'mulai',
        'selesai',
    ];

    protected $casts = [
        'mulai' => 'date',
        'selesai' => 'date',
    ];

    /**
     * Relasi ke data Dosen yang menjabat.
     */
    public function dosen()
    {
        // Asumsi model Dosen ada di App\Models\Dosen
        return $this->belongsTo(\App\Models\Dosen::class, 'dosen_id');
    }
}