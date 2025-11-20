<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
class Kurikulum extends Model
{
    use HasFactory;
    protected $fillable = ['program_studi_id', 'nama_kurikulum', 'tahun_mulai', 'aktif'];

    public function mataKuliahs() {
        return $this->hasMany(MataKuliah::class);
    }
}
