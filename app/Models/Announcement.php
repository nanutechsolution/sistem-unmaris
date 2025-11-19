<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'body',
        'unit',
        'attachment',
        'category_id',
        'status',
        'published_at',
        'expired_at',
        'created_by',
    ];

    protected $dates = [
        'published_at',
        'expired_at',
    ];

    protected  $casts = [
        'published_at' => 'datetime',
        'expired_at' => 'datetime',
    ];
    // Auto-generate slug
    public static function boot()
    {
        parent::boot();

        static::creating(function ($announcement) {
            if (empty($announcement->slug)) {
                $announcement->slug = Str::slug($announcement->title) . '-' . uniqid();
            }
        });
    }

    /** RELATIONSHIPS */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function isExpired()
    {
        return $this->expired_at && now()->greaterThan($this->expired_at);
    }
}
