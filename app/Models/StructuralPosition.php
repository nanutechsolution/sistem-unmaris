<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StructuralPosition extends Model
{
    protected $guarded = ['id'];

    // Relasi ke semua sejarah pejabat di posisi ini
    public function assignments()
    {
        return $this->hasMany(StructuralAssignment::class);
    }

    // Helper: Ambil pejabat yang SEDANG AKTIF sekarang
    public function currentOfficial()
    {
        return $this->hasOne(StructuralAssignment::class)
                    ->where('is_active', true)
                    ->whereNull('end_date')
                    ->latest('start_date');
    }
}