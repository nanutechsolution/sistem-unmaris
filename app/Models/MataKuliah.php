<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;

    protected $table = 'mata_kuliahs';

    protected $fillable = [
        'kode_mk', 'nama_mk', 'kurikulum_id', 'program_studi_id', 
        'sks', 'semester', 'sifat', 'syarat_sks_lulus'
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

    public function kurikulum() {
        return $this->belongsTo(Kurikulum::class);
    }
    public function prasyarats() {
        return $this->belongsToMany(MataKuliah::class, 'mk_prasyarats', 'mata_kuliah_id', 'prasyarat_id')
                    ->withPivot('nilai_min');
    }
}
