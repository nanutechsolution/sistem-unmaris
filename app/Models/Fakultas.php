<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    use HasFactory;

    protected $table = 'fakultas';

    protected $fillable = [
        'kode_fakultas',
        'nama_fakultas',
    ];


    /**
     * Relasi ke Program Studi.
     */
    public function programStudis()
    {
        return $this->hasMany(ProgramStudi::class);
    }


    public function currentDean()
    {
        // Mengambil dekan yang masa jabatannya belum selesai (selesai = NULL)
        // dan mengambil yang terbaru jika ada data ganda.
        return $this->hasOne(\App\Models\FakultasDekan::class)
            ->whereNull('selesai')
            ->orWhere('selesai', '>=', now())
            ->latest('mulai');
    }

    /**
     * Mengambil Dekan yang sedang menjabat (Aktif).
     * Logic: Cari yang kolom 'selesai' masih NULL.
     */
    public function dekanAktif()
    {
        return $this->hasOne(FakultasDekan::class)->whereNull('selesai')->latest('mulai');
    }
}
