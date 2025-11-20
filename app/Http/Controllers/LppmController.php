<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class LppmController extends Controller
{
    /**
     * Menampilkan halaman utama LPPM (Penelitian & Pengabdian).
     */
    public function index(): View
    {
        // 1. Mock Data Jurnal (OJS)
        // Data ini nantinya bisa diambil dari database jika sudah ada tabel 'journals'
        $journals = [
            [
                'nama' => 'Jurnal Maritim Teknologi',
                'akreditasi' => 'SINTA 3',
                'bidang' => 'Teknologi & Kelautan',
                'link' => '#', // Ganti dengan link OJS asli
                'cover_color' => 'bg-blue-600'
            ],
            [
                'nama' => 'Jurnal Ekonomi Pesisir',
                'akreditasi' => 'SINTA 4',
                'bidang' => 'Ekonomi & Bisnis',
                'link' => '#',
                'cover_color' => 'bg-yellow-600'
            ],
            [
                'nama' => 'Jurnal Pendidikan Bahari',
                'akreditasi' => 'SINTA 4',
                'bidang' => 'Pendidikan',
                'link' => '#',
                'cover_color' => 'bg-green-600'
            ],
        ];

        // 2. Mock Data Penelitian Terbaru
        // Data ini simulasi judul penelitian dosen
        $researches = [
            [
                'judul' => 'Pengembangan Sistem Deteksi Dini Tsunami Berbasis IoT di Pesisir Sumba',
                'ketua' => 'Dr. Ir. Budi Santoso, M.T.',
                'tahun' => '2024',
                'skema' => 'Hibah Dikti'
            ],
            [
                'judul' => 'Model Pemberdayaan Ekonomi Masyarakat Pesisir Pasca Pandemi',
                'ketua' => 'Siti Aminah, S.E., M.M.',
                'tahun' => '2024',
                'skema' => 'Internal'
            ],
            [
                'judul' => 'Konservasi Terumbu Karang Menggunakan Metode Transplantasi Ramah Lingkungan',
                'ketua' => 'Rian Hidayat, S.Kel., M.Si.',
                'tahun' => '2023',
                'skema' => 'Kerjasama Internasional'
            ],
            [
                'judul' => 'Analisis Dampak Perubahan Iklim Terhadap Hasil Tangkap Nelayan Tradisional',
                'ketua' => 'Dr. Andi Wijaya, S.Pi., M.Si.',
                'tahun' => '2023',
                'skema' => 'Hibah Bersaing'
            ],
        ];

        // Kirim data ke view
        return view('public.lppm.index', compact('journals', 'researches'));
    }
}