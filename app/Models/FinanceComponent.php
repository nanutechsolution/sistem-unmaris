<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FinanceComponent extends Model
{
    use HasFactory;

    protected $table = 'finance_components';
    protected $guarded = ['id'];

    protected $casts = [
        'is_wajib' => 'boolean',
    ];

    /**
     * Relasi: Satu jenis biaya bisa memiliki banyak tarif (beda prodi/angkatan)
     */
    public function rates()
    {
        return $this->hasMany(FinanceRate::class, 'finance_component_id');
    }
}
