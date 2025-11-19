<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Menampilkan halaman kontak.
     */
    public function index(): View
    {
        return view('public.contact');
    }

    /**
     * Menangani pengiriman pesan (Opsional/Placeholder).
     */
    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            // 'g-recaptcha-response' => 'required|captcha', // Jika pakai captcha nanti
        ]);

        // Logika pengiriman email atau simpan ke database pesan masuk
        // ...

        return back()->with('success', 'Pesan Anda telah terkirim! Tim kami akan segera menghubungi Anda.');
    }
}
