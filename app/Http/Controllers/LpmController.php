<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QualityDocument;
use App\Models\QualityAnnouncement;

class LpmController extends Controller
{
    /**
     * Menampilkan halaman utama LPM (Dashboard Publik).
     * Memuat daftar dokumen terbaru dan pengumuman terbaru.
     */
    public function index()
    {
        // Mengambil dokumen mutu, diurutkan dari yang terbaru, dipaginasi 8 per halaman
        $documents = QualityDocument::whereNotNull('published_at')
            ->orderBy('published_at', 'desc')
            ->paginate(8);

        // Mengambil 5 pengumuman terbaru untuk sidebar
        $announcements = QualityAnnouncement::whereNotNull('published_at')
            ->orderBy('published_at', 'desc')
            ->take(5)
            ->get();

        return view('public.lpm.index', compact('documents', 'announcements'));
    }

    /**
     * Menampilkan halaman detail untuk satu Dokumen Mutu.
     */
    public function document($slug)
    {
        $doc = QualityDocument::where('slug', $slug)->firstOrFail();
        return view('public.lpm.document', compact('doc'));
    }

    /**
     * Menampilkan halaman detail untuk satu Pengumuman.
     */
    public function announcement($slug)
    {
        $ann = QualityAnnouncement::where('slug', $slug)->firstOrFail();
        return view('public.lpm.announcement', compact('ann'));
    }

    /**
     * Menampilkan halaman daftar semua pengumuman (Arsip Pengumuman).
     * Diakses melalui tombol "Lihat Semua Pengumuman".
     */
    public function announcementsIndex()
    {
        $announcements = QualityAnnouncement::whereNotNull('published_at')
            ->orderBy('published_at', 'desc')
            ->paginate(12); // Menampilkan 12 pengumuman per halaman

        return view('public.lpm.announcements', compact('announcements'));
    }

    /**
     * Menampilkan halaman Profil LPM (Visi, Misi, Struktur).
     * Diakses melalui tombol "Selengkapnya tentang Visi & Misi".
     */
    public function profile()
    {
        $profileData = [
            'visi' => 'Menjadi pusat unggulan penjaminan mutu internal yang terdepan dalam mewujudkan Budaya Mutu di seluruh Tri Dharma Perguruan Tinggi pada tahun 2030.',
            'misi' => [
                'Menetapkan standar mutu yang melampaui Standar Nasional Pendidikan Tinggi (SN Dikti).',
                'Mengkoordinasikan pelaksanaan, pengendalian, dan evaluasi (AMI) mutu secara konsisten dan objektif.',
                'Mendorong perbaikan berkelanjutan (Continuous Improvement) berdasarkan hasil audit dan evaluasi kinerja.',
                'Melakukan sosialisasi dan internalisasi budaya mutu kepada seluruh sivitas akademika UNMARIS.',
                'Meningkatkan kompetensi auditor mutu internal secara berkala.'
            ],
            'struktur_img' => 'https://placehold.co/800x400/003366/FFD700?text=Bagan+Struktur+Organisasi+LPM',
        ];

        return view('public.lpm.profile', compact('profileData'));
    }
}
