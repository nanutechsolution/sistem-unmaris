<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramStudiKaprodi extends Model
{
    protected $table = 'program_studi_kaprodi';
    protected $guarded = ['id'];

    // Agar Laravel tahu kolom tanggal (biar bisa diformat)
    protected $casts = [
        'mulai' => 'date',
        'selesai' => 'date',
    ];

    // Relasi ke Dosen (Siapa orangnya)
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }


    /**
     * Relasi ke Program Studi (Menjabat di prodi mana)
     */
    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }
}
