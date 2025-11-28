<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\StudentOrganization; // Model Baru
use App\Models\Achievement;         // Model Prestasi yang sudah ada

class KemahasiswaanController extends Controller
{
    public function index(): View
    {
        // 1. Ambil Data UKM dari Database
        $ukms = StudentOrganization::where('is_active', true)->get();

        // 2. Ambil Data Prestasi Terbaru (3 Teratas)
        // Menggunakan model Achievement yang sudah kita buat sebelumnya
        $prestasi = Achievement::orderByDesc('date')
            ->take(3)
            ->get();

        return view('public.kemahasiswaan.index', compact('ukms', 'prestasi'));
    }
}