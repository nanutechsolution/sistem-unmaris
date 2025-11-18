<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Krs extends Model
{
    use HasFactory;
    protected $table = 'krs';
    protected $fillable = [
        'mahasiswa_id', 'tahun_akademik_id', 'dosen_pa_id', 'total_sks', 'status'
    ];

    public function mahasiswa() {
        return $this->belongsTo(Mahasiswa::class);
    }
    public function tahunAkademik() {
        return $this->belongsTo(TahunAkademik::class);
    }
    public function details() { // Satu Krs punya banyak detail
        return $this->hasMany(KrsDetail::class);
    }
}
