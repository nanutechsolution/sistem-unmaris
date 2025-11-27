<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
    // Helper: URL File
    public function getUrlAttribute()
    {
        return Storage::url($this->file_path);
    }

    // Helper: Icon FontAwesome
    public function getIconAttribute()
    {
        return match (strtolower($this->file_type)) {
            'pdf' => 'fas fa-file-pdf text-red-500',
            'doc', 'docx' => 'fas fa-file-word text-blue-500',
            'xls', 'xlsx', 'csv' => 'fas fa-file-excel text-green-500',
            'ppt', 'pptx' => 'fas fa-file-powerpoint text-orange-500',
            'zip', 'rar' => 'fas fa-file-archive text-yellow-600',
            default => 'fas fa-file-alt text-gray-500',
        };
    }

    // Helper: Ukuran File (Human Readable)
    // Mengubah bytes (1024) menjadi "1 KB"
    public function getSizeLabelAttribute()
    {
        $bytes = $this->file_size;
        if ($bytes >= 1073741824) return number_format($bytes / 1073741824, 2) . ' GB';
        if ($bytes >= 1048576)    return number_format($bytes / 1048576, 2) . ' MB';
        if ($bytes >= 1024)       return number_format($bytes / 1024, 2) . ' KB';
        return $bytes . ' bytes';
    }

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
