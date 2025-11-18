<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
    'title', 'slug', 'content', 'category_id', 'user_id',
    'featured_image', 'status', 'published_at'
];

protected $casts = [ 'published_at' => 'datetime' ];

public function category() {
    return $this->belongsTo(Category::class);
}
public function author() { // Ganti nama relasi ke 'author'
    return $this->belongsTo(User::class, 'user_id');
}
}
