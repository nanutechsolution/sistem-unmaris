<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenKategori extends Model
{
    use HasFactory;

    protected $table = 'dokumen_kategori';

    protected $fillable = [
        'nama',
        'slug',
    ];

    // Relasi: satu kategori bisa punya banyak dokumen
    public function dokumens()
    {
        return $this->hasMany(Dokumen::class, 'kategori_id');
    }
}
