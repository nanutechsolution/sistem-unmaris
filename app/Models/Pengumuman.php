<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Pengumuman extends Model
{

    use SoftDeletes;
    
    protected $table = 'pengumumans';
    protected $guarded = ['id'];

    protected $casts = [
        'published_at' => 'datetime',
        'is_pinned' => 'boolean',
    ];

    // Agar URL pakai Slug, bukan ID (SEO Friendly)
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // --- SCOPE UNTUK QUERY MUDAH ---

    // Ambil hanya yang status Published DAN waktunya sudah lewat (atau sekarang)
    public function scopeTayang(Builder $query)
    {
        return $query->where('status', 'Published')
            ->where('published_at', '<=', now());
    }

    // Urutkan: Pinned duluan, baru Tanggal terbaru
    public function scopeUrutkan(Builder $query)
    {
        return $query->orderByDesc('is_pinned')
            ->orderByDesc('published_at');
    }
}
