<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class LibraryController extends Controller
{
    /**
     * Menampilkan halaman utama Perpustakaan Digital (E-Library).
     */
    public function index(): View
    {
        // Mock Data Koleksi Digital
        $collections = [
            [
                'title' => 'E-Book Perpustakaan',
                'description' => 'Ribuan judul buku digital yang dapat diakses secara penuh oleh civitas akademika.',
                'icon' => 'fas fa-book-reader',
                'link' => '#', // Ganti dengan link E-Book asli
                'stats' => '20.000+ Koleksi'
            ],
            [
                'title' => 'Repository Institusi',
                'description' => 'Arsip Tugas Akhir, Tesis, Disertasi, dan Laporan Penelitian Dosen.',
                'icon' => 'fas fa-archive',
                'link' => '#', // Ganti dengan link Repository asli
                'stats' => 'Open Access'
            ],
            [
                'title' => 'Jurnal Internasional',
                'description' => 'Akses ke database jurnal terakreditasi internasional (ProQuest, EBSCO, dll).',
                'icon' => 'fas fa-globe',
                'link' => '#', // Ganti dengan link Proxy Jurnal
                'stats' => 'Berlangganan'
            ],
            [
                'title' => 'OPAC (Katalog Online)',
                'description' => 'Cari koleksi fisik dan digital perpustakaan dengan cepat.',
                'icon' => 'fas fa-search',
                'link' => '#', // Ganti dengan link OPAC
                'stats' => '100% Terintegrasi'
            ]
        ];
        
        // Mock Statistik
        $stats = [
            ['value' => '10.000+', 'label' => 'Total Anggota Aktif', 'icon' => 'fas fa-users'],
            ['value' => '95%', 'label' => 'Kepuasan Pengguna', 'icon' => 'fas fa-smile-beam'],
            ['value' => '24/7', 'label' => 'Akses Non-Stop', 'icon' => 'fas fa-clock'],
        ];

        return view('public.library.index', compact('collections', 'stats'));
    }
}