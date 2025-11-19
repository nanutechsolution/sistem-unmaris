<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class PublicAnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $pengumuman = Announcement::with('category', 'author')
            ->where('status', 'Published')
            ->where(function ($q) {
                $q->whereNull('expired_at')
                  ->orWhere('expired_at', '>', now());
            })
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        // Untuk sidebar
        $latest = Announcement::where('status', 'Published')
            ->orderBy('published_at', 'desc')
            ->limit(5)
            ->get();
        return view('public.pengumuman-index', compact('pengumuman', 'latest'));
    }

    public function show($slug)
    {
        $pengumuman = Announcement::with('category', 'author')
            ->where('slug', $slug)
            ->where('status', 'Published')
            ->firstOrFail();

        // Related announcements
        $related = Announcement::where('id', '!=', $pengumuman->id)
            ->orderBy('published_at', 'desc')
            ->limit(4)
            ->get();

        return view('public.pengumuman-show', compact('pengumuman', 'related'));
    }
}
