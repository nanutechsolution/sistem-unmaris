<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FinanceRate extends Model
{
    use HasFactory;

    protected $table = 'finance_rates';
    protected $guarded = ['id'];

    /**
     * Relasi ke Komponen Biaya (Induk)
     * Contoh: Tarif ini milik komponen "SPP"
     */
    public function component()
    {
        return $this->belongsTo(FinanceComponent::class, 'finance_component_id');
    }

    /**
     * Relasi ke Program Studi
     * Jika null, berarti tarif ini berlaku untuk semua prodi (Umum)
     */
    public function prodi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }

    /**
     * Helper: Format Rupiah Otomatis
     * Cara pakai di blade: {{ $rate->nominal_rupiah }}
     * Mengubah 5000000 menjadi "Rp 5.000.000"
     */
    public function getNominalRupiahAttribute()
    {
        return "Rp " . number_format($this->nominal, 0, ',', '.');
    }
}
