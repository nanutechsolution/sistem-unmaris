<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class FasilitasController extends Controller
{
    /**
     * Menampilkan halaman galeri fasilitas kampus.
     */
    public function index(): View
    {
        // Mock Data Fasilitas
        $facilities = [
            [
                'name' => 'Perpustakaan Digital',
                'category' => 'Akademik',
                'image' => 'https://placehold.co/800x600/003366/FFF?text=Library',
                'description' => 'Akses ribuan e-book dan jurnal internasional dengan ruang baca yang nyaman dan ber-AC.'
            ],
            [
                'name' => 'Laboratorium Komputer',
                'category' => 'Akademik',
                'image' => 'https://placehold.co/800x600/222/FFF?text=Lab+Komputer',
                'description' => 'Dilengkapi PC spesifikasi tinggi untuk praktikum pemrograman dan desain grafis.'
            ],
            [
                'name' => 'Laboratorium Bahasa',
                'category' => 'Akademik',
                'image' => 'https://placehold.co/800x600/333/FFF?text=Lab+Bahasa',
                'description' => 'Sarana multimedia interaktif untuk meningkatkan kemampuan bahasa asing mahasiswa.'
            ],
            [
                'name' => 'Auditorium Utama',
                'category' => 'Umum',
                'image' => 'https://placehold.co/800x600/444/FFF?text=Auditorium',
                'description' => 'Kapasitas 1000 orang untuk wisuda, seminar nasional, dan pertunjukan seni.'
            ],
            [
                'name' => 'Lapangan Futsal & Basket',
                'category' => 'Olahraga',
                'image' => 'https://placehold.co/800x600/555/FFF?text=Sport+Center',
                'description' => 'Fasilitas olahraga standar nasional untuk menjaga kebugaran civitas akademika.'
            ],
            [
                'name' => 'Kantin Sehat',
                'category' => 'Penunjang',
                'image' => 'https://placehold.co/800x600/666/FFF?text=Kantin',
                'description' => 'Menyediakan makanan higienis dan halal dengan harga terjangkau.'
            ],
            [
                'name' => 'Klinik Kampus',
                'category' => 'Penunjang',
                'image' => 'https://placehold.co/800x600/777/FFF?text=Klinik',
                'description' => 'Layanan kesehatan dasar gratis bagi mahasiswa dan staf.'
            ],
            [
                'name' => 'Masjid Kampus',
                'category' => 'Ibadah',
                'image' => 'https://placehold.co/800x600/888/FFF?text=Masjid',
                'description' => 'Pusat kegiatan kerohanian Islam yang luas dan nyaman.'
            ],
            [
                'name' => 'Kapel Oikumene',
                'category' => 'Ibadah',
                'image' => 'https://placehold.co/800x600/999/FFF?text=Kapel',
                'description' => 'Ruang ibadah yang tenang untuk mahasiswa Nasrani.'
            ],
        ];

        // Ambil list kategori unik untuk filter
        $categories = collect($facilities)->pluck('category')->unique()->values();

        return view('public.fasilitas.index', compact('facilities', 'categories'));
    }
}