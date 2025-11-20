<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class KemahasiswaanController extends Controller
{
    public function index(): View
    {
        // Mock Data UKM (Unit Kegiatan Mahasiswa)
        $ukms = [
            [
                'nama' => 'BEM Universitas',
                'kategori' => 'Organisasi',
                'deskripsi' => 'Badan Eksekutif Mahasiswa sebagai lembaga eksekutif tertinggi.',
                'icon' => 'fas fa-users',
                'color' => 'bg-blue-600'
            ],
            [
                'nama' => 'Mapala "Maritim"',
                'kategori' => 'Minat Bakat',
                'deskripsi' => 'Mahasiswa Pecinta Alam yang fokus pada pelestarian lingkungan pesisir.',
                'icon' => 'fas fa-mountain',
                'color' => 'bg-green-600'
            ],
            [
                'nama' => 'Paduan Suara',
                'kategori' => 'Seni',
                'deskripsi' => 'Mengembangkan bakat tarik suara dan tampil di acara wisuda/nasional.',
                'icon' => 'fas fa-music',
                'color' => 'bg-purple-600'
            ],
            [
                'nama' => 'E-Sport UNMARIS',
                'kategori' => 'Olahraga',
                'deskripsi' => 'Komunitas kompetitif Mobile Legends, PUBG, dan Valorant.',
                'icon' => 'fas fa-gamepad',
                'color' => 'bg-indigo-600'
            ],
            [
                'nama' => 'LDK Al-Bahar',
                'kategori' => 'Kerohanian',
                'deskripsi' => 'Lembaga Dakwah Kampus untuk pembinaan karakter Islami.',
                'icon' => 'fas fa-mosque',
                'color' => 'bg-emerald-600'
            ],
            [
                'nama' => 'PMK (Persekutuan Mahasiswa Kristen)',
                'kategori' => 'Kerohanian',
                'deskripsi' => 'Wadah persekutuan dan pelayanan mahasiswa Kristen.',
                'icon' => 'fas fa-church',
                'color' => 'bg-cyan-600'
            ],
        ];

        // Mock Data Prestasi
        $prestasi = [
            ['judul' => 'Juara 1 Lomba Debat Nasional 2024', 'mhs' => 'Siti Aminah (Hukum)', 'img' => 'https://placehold.co/400x300/003366/fff?text=Debat'],
            ['judul' => 'Gold Medal Robotik Regional', 'mhs' => 'Tim Elektro', 'img' => 'https://placehold.co/400x300/003366/fff?text=Robotik'],
            ['judul' => 'Juara 2 Futsal Antar Universitas', 'mhs' => 'UKM Olahraga', 'img' => 'https://placehold.co/400x300/003366/fff?text=Futsal'],
        ];

        return view('public.kemahasiswaan.index', compact('ukms', 'prestasi'));
    }
}