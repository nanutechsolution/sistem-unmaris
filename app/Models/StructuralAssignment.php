<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class StructuralAssignment extends Model
{
    protected $guarded = ['id'];
    
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function position()
    {
        return $this->belongsTo(StructuralPosition::class, 'structural_position_id');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    // --- ACCESSOR PINTAR ---
    
    // Ambil Nama (Prioritas: Dosen -> Custom)
    public function getNameAttribute()
    {
        return $this->dosen ? $this->dosen->nama_lengkap : $this->name_custom;
    }

    // Ambil Foto (Prioritas: Custom Upload -> Foto Dosen -> Placeholder)
    public function getPhotoUrlAttribute()
    {
        if ($this->photo_custom) {
            return Storage::url($this->photo_custom);
        }
        if ($this->dosen && $this->dosen->foto_profil) {
            return Storage::url($this->dosen->foto_profil);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=random';
    }
}