<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramStudi extends Model
{
    use HasFactory;
    /**
     * Kolom yang boleh diisi massal.
     */
    protected $fillable = [
        'fakultas_id',
        'kode_prodi',
        'nama_prodi',
        'jenjang',
        'akreditasi',
    ];


    /**
     * Relasi ke Fakultas.
     */
    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class);
    }



    /**
     * Relasi ke Dosen (Prodi ini memiliki banyak dosen).
     */
    public function dosens()
    {
        return $this->hasMany(Dosen::class);
    }

   /**
     * Mengambil Kaprodi yang sedang menjabat saat ini.
     * Logika: Cari yang kolom 'selesai'-nya masih NULL.
     */
    public function kaprodiAktif()
    {
        return $this->hasOne(ProgramStudiKaprodi::class)
                    ->whereNull('selesai')
                    ->latest('mulai'); // Ambil yang paling baru dilantik (jaga-jaga)
    }
}
