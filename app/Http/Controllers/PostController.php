<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Menampilkan daftar berita (News Hub).
     */
    public function index(Request $request): View
    {
        $query = Post::where('status', 'Published')
                     ->whereNotNull('published_at');

        // Fitur Pencarian
        if ($request->has('q')) {
            $query->where('title', 'like', '%' . $request->q . '%')
                  ->orWhere('content', 'like', '%' . $request->q . '%');
        }

        // Filter Kategori (Jika ada relasi category)
        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Ambil data dengan pagination
        // 'with' digunakan untuk mencegah N+1 query pada relasi user dan category
        $posts = $query->orderBy('published_at', 'desc')
                       ->with(['author', 'category'])
                       ->paginate(9);

        // Ambil berita utama (Headline) - Opsional: Ambil 1 berita terbaru khusus
        $headline = Post::where('status', 'Published')
                        ->whereNotNull('published_at')
                        ->orderBy('published_at', 'desc')
                        ->first();

        // Ambil daftar kategori untuk sidebar filter
        $categories = Category::withCount('posts')->get();

        return view('public.posts.index', compact('posts', 'headline', 'categories'));
    }

    /**
     * Menampilkan detail berita.
     */
    public function show($slug): View
    {
        $post = Post::where('slug', $slug)
                    ->where('status', 'Published')
                    ->with(['author', 'category'])
                    ->firstOrFail();

        // Berita Terkait (Berdasarkan kategori yang sama, kecuali berita ini sendiri)
        $relatedPosts = Post::where('category_id', $post->category_id)
                            ->where('id', '!=', $post->id)
                            ->where('status', 'Published')
                            ->limit(3)
                            ->get();
        return view('public.posts.show', compact('post', 'relatedPosts'));
    }

    public function byCategory($slug): View
{
    $category = Category::where('slug', $slug)->firstOrFail();

    $posts = Post::where('category_id', $category->id)
                 ->where('status', 'Published')
                 ->with(['author', 'category'])
                 ->orderBy('published_at', 'desc')
                 ->paginate(9);

    return view('public.posts.index', [
        'posts' => $posts,
        'headline' => $posts->first(),
        'categories' => Category::withCount('posts')->get(),
    ]);
}

}
