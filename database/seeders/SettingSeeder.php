<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('settings')->insert([

            [
                'key'   => 'site_name',
                'value' => 'Universitas Stela Maris Sumba',
            ],

            [
                'key'   => 'site_tagline',
                'value' => 'Unggul, Humanis, dan Berdaya Saing Global',
            ],

            [
                'key'   => 'site_logo',
                'value' => '/uploads/logo/unmaris.png', // bisa kamu ganti nanti
            ],

            [
                'key'   => 'site_email',
                'value' => 'info@stmaris.ac.id',
            ],

            [
                'key'   => 'site_phone',
                'value' => '0387-123456',
            ],

            [
                'key'   => 'site_address',
                'value' => 'Jl. Marokota, Desa Lolo Ole, Sumba Barat Daya, NTT',
            ],

            [
                'key'   => 'footer_text',
                'value' => '© ' . date('Y') . ' Universitas Stela Maris Sumba. All rights reserved.',
            ],

            [
                'key'   => 'facebook_url',
                'value' => 'https://facebook.com/unmaris',
            ],

            [
                'key'   => 'instagram_url',
                'value' => 'https://instagram.com/unmaris',
            ],

            [
                'key'   => 'youtube_url',
                'value' => 'https://youtube.com/@unmaris',
            ],

        ]);
    }
}
