<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;

    protected $table = 'mata_kuliahs';

    protected $fillable = [
        'kode_mk',
        'nama_mk',
        'program_studi_id',
        'sks',
        'semester',
    ];

    /**
     * Relasi ke Program Studi.
     */
    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }


    public function kelas() {
    return $this->hasMany(Kelas::class);
}
}
