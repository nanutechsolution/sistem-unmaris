<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KrsDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'krs_id', 'kelas_id', 'mata_kuliah_id', 'sks', 'status_ambil'
    ];

    public function krs() {
        return $this->belongsTo(Krs::class);
    }
    public function kelas() {
        return $this->belongsTo(Kelas::class);
    }
    public function mataKuliah() {
        return $this->belongsTo(MataKuliah::class);
    }
}
