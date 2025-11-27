<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class Setting extends Model
{
    protected $guarded = ['id'];

    /**
     * Helper untuk mengambil value setting berdasarkan Key.
     * Contoh Pakai: \App\Models\Setting::get('site_name')
     */
    public static function get($key, $default = null)
    {
        // Gunakan Cache agar tidak query database terus menerus setiap refresh halaman
        $setting = Cache::rememberForever("setting_{$key}", function () use ($key) {
            return self::where('key', $key)->first();
        });

        if (!$setting) {
            return $default;
        }

        // Jika tipe gambar, kembalikan URL lengkap
        if ($setting->type === 'image' && $setting->value) {
            return Storage::url($setting->value);
        }

        return $setting->value;
    }
}