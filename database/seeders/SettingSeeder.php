<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // GROUP: GENERAL
            [
                'key' => 'site_name',
                'value' => 'Universitas Stella Maris Sumba',
                'label' => 'Nama Kampus',
                'type' => 'text',
                'group' => 'general',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'site_short_name',
                'value' => 'UNMARIS',
                'label' => 'Nama Singkatan',
                'type' => 'text',
                'group' => 'general',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'site_slogan',
                'value' => 'Unggul, Beriman, dan Berdaya Saing',
                'label' => 'Slogan / Tagline',
                'type' => 'text',
                'group' => 'general',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'site_description',
                'value' => 'Kampus teknologi dan bisnis terbaik di Sumba yang berdedikasi mencetak generasi unggul.',
                'label' => 'Deskripsi Singkat (SEO)',
                'type' => 'textarea',
                'group' => 'general',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'site_logo',
                'value' => null,
                'label' => 'Logo Kampus',
                'type' => 'image',
                'group' => 'general',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // GROUP: CONTACT
            [
                'key' => 'contact_email',
                'value' => 'info@unmaris.ac.id',
                'label' => 'Email Resmi',
                'type' => 'email',
                'group' => 'contact',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'contact_phone',
                'value' => '+62 812-3456-7890',
                'label' => 'Nomor Telepon / WA',
                'type' => 'textarea',
                'group' => 'contact',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'contact_address',
                'value' => "Jl. Karya Kasih No. 5, Tambolaka,\nSumba Barat Daya, Nusa Tenggara Timur,\nIndonesia - 87113",
                'label' => 'Alamat Lengkap',
                'type' => 'textarea',
                'group' => 'contact',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'contact_google_map',
                'value' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3942.636379589761!2d119.123456!3d-9.123456!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zOcKwMDcnMjQuNCJTIDExOcKwMDcnMjQuNCJF!5e0!3m2!1sid!2sid!4v1625000000000!5m2!1sid!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
                'label' => 'Embed Google Maps',
                'type' => 'textarea',
                'group' => 'contact',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // GROUP: SOSMED
            [
                'key' => 'social_facebook',
                'value' => 'https://facebook.com/unmaris',
                'label' => 'Link Facebook',
                'type' => 'text',
                'group' => 'social_media',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'social_instagram',
                'value' => 'https://instagram.com/unmaris',
                'label' => 'Link Instagram',
                'type' => 'text',
                'group' => 'social_media',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'social_youtube',
                'value' => 'https://youtube.com/@unmaris',
                'label' => 'Link Youtube',
                'type' => 'text',
                'group' => 'social_media',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'social_linkedin',
                'value' => 'https://linkedin.com/school/unmaris',
                'label' => 'Link LinkedIn',
                'type' => 'text',
                'group' => 'social_media',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'social_tiktok',
                'value' => 'https://tiktok.com/school/unmaris',
                'label' => 'Link Tiktok',
                'type' => 'text',
                'group' => 'social_media',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Upsert: Insert jika belum ada, Update jika key sudah ada
        DB::table('settings')->upsert($settings, ['key'], ['value', 'label', 'type', 'group', 'updated_at']);
    }
}
