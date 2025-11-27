<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Menampilkan halaman statis berdasarkan slug.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function show(string $slug): View
    {
        // 1. Cari halaman yang sedang dibuka (Bisa halaman Umum atau LPM)
        $page = Page::where('slug', $slug)
            ->where('status', 'Published')
            ->firstOrFail();

        // 2. Ambil semua halaman lain untuk sidebar menu "Akses Cepat" / "Profil Kampus"
        //    FILTER: Hanya ambil halaman Kampus (bukan LPM)
        $sidebarPages = Page::where('status', 'Published')
            ->where('slug', 'not like', 'lpm-%') // <-- INI FILTERNYA (Exclude LPM)
            ->orderBy('id', 'asc')
            ->get();

        return view('public.pages.show', compact('page', 'sidebarPages'));
    }
}