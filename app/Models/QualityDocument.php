<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualityDocument extends Model
{
    use HasFactory;

    protected $fillable = [
       'kode', 'title','slug','category','file_path','description','published_at','created_by'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function author()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

//     protected static function booted()
// {
//     static::creating(function ($doc) {
//         $doc->kode = 'DOC-' . strtoupper(uniqid());
//     });
// }

}
