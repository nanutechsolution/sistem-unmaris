<?php
namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;

class PostController extends Controller
{
    // Halaman daftar berita
    public function index()
    {
        $posts = Post::with('author', 'category')
                    ->where('status', 'Published')
                    ->orderBy('published_at', 'desc')
                    ->paginate(9); // 9 postingan per halaman

        return view('public.post-index', compact('posts'));
    }

    // Halaman detail berita
    public function show($slug)
    {
        $post = Post::with('author', 'category')
                    ->where('slug', $slug)
                    ->where('status', 'Published')
                    ->firstOrFail();

        return view('public.post-show', compact('post'));
    }



    /**
     * Menampilkan postingan berdasarkan kategori
     */
    public function byCategory($slug)
    {
        // 1. Cari kategori berdasarkan slug
        $category = Category::where('slug', $slug)->firstOrFail();

        // 2. Ambil postingan yang Published & termasuk kategori tsb
        $posts = Post::with('author', 'category')
                    ->where('category_id', $category->id)
                    ->where('status', 'Published')
                    ->orderBy('published_at', 'desc')
                    ->paginate(9);

        // 3. Kirim judul halaman dinamis
        $pageTitle = 'Kategori: ' . $category->name;

        // 4. Kita gunakan view yang sama dengan 'index'
        return view('public.post-index', compact('posts', 'pageTitle'));
    }
}
