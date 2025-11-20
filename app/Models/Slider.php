<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
   protected $fillable = ['title', 'description', 'image_path', 'button_text', 'button_url', 'order', 'active'];
protected $casts = ['active' => 'boolean'];
}
