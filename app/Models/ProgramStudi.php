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
            ->latest('mulai');
    }

    // Relasi ke Kaprodi (History)
    public function kaprodiHistories()
    {
        return $this->hasMany(ProgramStudiKaprodi::class, 'program_studi_id');
    }

    public function mahasiswas()
    {
        return $this->hasMany(Mahasiswa::class, 'program_studi_id');
    }

    // Relasi ke Keuangan (Tarif Biaya Kuliah)
    public function financeRates()
    {
        return $this->hasMany(FinanceRate::class, 'program_studi_id');
    }
}
