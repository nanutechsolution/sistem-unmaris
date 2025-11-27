<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QualityDocument;
use App\Models\QualityAnnouncement;
use App\Models\Page; // Import Model Page

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
     * Mendukung fitur pencarian melalui parameter 'q'.
     */
    public function announcementsIndex(Request $request)
    {
        $query = QualityAnnouncement::whereNotNull('published_at');

        // Filter Pencarian
        if ($request->has('q')) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $announcements = $query->orderBy('published_at', 'desc')
                                ->paginate(12)
                                ->withQueryString();

        return view('public.lpm.announcements', compact('announcements'));
    }

    /**
     * Menampilkan halaman Profil LPM.
     * Mengambil data dari tabel 'pages' dengan slug 'lpm-visi-misi' (default)
     * atau halaman LPM lainnya.
     */
    public function profile($slug = 'lpm-visi-misi')
    {
        // 1. Ambil Halaman LPM yang diminta (Default: lpm-visi-misi)
        $page = Page::where('slug', $slug)
            ->where('status', 'Published')
            ->firstOrFail();

        // 2. Ambil daftar halaman LPM lain untuk Sidebar Navigasi
        // Filter: Ambil semua page yang slug-nya diawali 'lpm-'
        $sidebarPages = Page::where('slug', 'like', 'lpm-%')
            ->where('status', 'Published')
            ->where('id', '!=', $page->id) // Kecuali halaman yang sedang dibuka
            ->orderBy('title', 'asc')
            ->get();

        return view('public.lpm.profile', compact('page', 'sidebarPages'));
    }
}