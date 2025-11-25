<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Slider extends Model
{
   // Sesuaikan dengan nama kolom baru di database
   protected $fillable = [
      'title',
      'description',
      'file_path',   // Dulu image_path
      'type',        // 'image' atau 'video'
      'poster_path', // Cover untuk video
      'button_text',
      'button_url',
      'order',
      'active'
   ];

   protected $casts = [
      'active' => 'boolean'
   ];

   /**
    * Accessor: Mengambil URL File secara otomatis.
    * Cara panggil di Blade: {{ $slider->media_url }}
    */
   public function getMediaUrlAttribute()
   {
      // Jika file_path kosong, return null (atau placeholder default)
      if (!$this->file_path) {
         return null;
      }

      // Jika URL eksternal (misal dari link youtube/placehold.co), kembalikan langsung
      if (str_starts_with($this->file_path, 'http')) {
         return $this->file_path;
      }

      // Jika file lokal di storage, generate URL lengkapnya
      return Storage::url($this->file_path);
   }

   /**
    * Scope: Hanya ambil slider yang aktif & urutkan.
    * Cara panggil: Slider::active()->get()
    */
   public function scopeActive($query)
   {
      return $query->where('active', true)->orderBy('order', 'asc');
   }
}
