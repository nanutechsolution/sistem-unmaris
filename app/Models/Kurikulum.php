<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurikulum extends Model
{
    use HasFactory;

    protected $table = 'kurikulums';

    protected $fillable = [
        'program_studi_id',
        'nama_kurikulum',
        'tahun_mulai',
        'aktif'
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    /**
     * Relasi ke Program Studi (Milik Prodi siapa)
     */
    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    /**
     * Relasi ke Mata Kuliah (Punya banyak MK)
     */
    public function mataKuliahs()
    {
        return $this->hasMany(MataKuliah::class);
    }
}