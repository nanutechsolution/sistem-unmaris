<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    use HasFactory;

    protected $table = 'dokumen';

    protected $fillable = [
        'judul',
        'slug',
        'deskripsi',
        'file_path',
        'file_type',
        'file_size',
        'fakultas_id',
        'program_studi_id',
        'kategori_id',
        'akses',
        'download_count',
    ];

    // Relasi ke kategori
    public function kategori()
    {
        return $this->belongsTo(DokumenKategori::class, 'kategori_id');
    }

    // Relasi ke fakultas
    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'fakultas_id');
    }

    // Relasi ke program studi
    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }

    // Increment download count saat diunduh
    public function incrementDownload()
    {
        $this->increment('download_count');
    }
}
