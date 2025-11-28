<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Achievement extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'date' => 'date',
        'is_featured' => 'boolean',
    ];

    public function getImageUrlAttribute()
    {
        return $this->image_path
            ? Storage::url($this->image_path)
            : 'https://placehold.co/600x800/003366/FFFFFF/png?text=Prestasi+UNMARIS';
    }

    // Helper warna badge berdasarkan level/medal
    public function getBadgeColorAttribute()
    {
        return match ($this->medal) {
            'Gold' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
            'Silver' => 'bg-gray-100 text-gray-800 border-gray-200',
            'Bronze' => 'bg-orange-100 text-orange-800 border-orange-200',
            default => 'bg-blue-100 text-blue-800 border-blue-200',
        };
    }
}
