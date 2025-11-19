<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
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
        // 1. Cari halaman yang sedang dibuka
        $page = Page::where('slug', $slug)
                    ->where('status', 'Published')
                    ->firstOrFail();

        // 2. Ambil semua halaman lain untuk sidebar menu "Akses Cepat"
        //    Anda bisa mengurutkan berdasarkan ID atau Title
        $sidebarPages = Page::where('status', 'Published')
                            ->orderBy('id', 'asc')
                            ->get();

        return view('public.pages.show', compact('page', 'sidebarPages'));
    }
}
