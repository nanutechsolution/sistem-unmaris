<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\ProgramStudi;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke()
    {
        // 1. Data Statistik
        $totalProdi = ProgramStudi::count();
        $totalFakultas = Fakultas::count();

        // 2. Data Fakultas & Prodi (Untuk Program Finder)
        // Menggunakan 'with' untuk Eager Loading agar hemat query
        $faculties = Fakultas::with('programStudis')->get();

        // 3. Berita Terbaru (Hanya yang Published)
        $latestPosts = Post::where('status', 'Published')
            ->whereNotNull('published_at')
            ->orderBy('published_at', 'desc')
            ->take(3) // Ambil 3 berita terbaru
            ->get();

        return view('public.home', compact('totalProdi', 'totalFakultas', 'faculties', 'latestPosts'));
    }
}
