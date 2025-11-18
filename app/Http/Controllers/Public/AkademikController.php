<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fakultas; // <-- Panggil Model Fakultas kita

class AkademikController extends Controller
{
    /**
     * Menampilkan daftar Fakultas dan Program Studi.
     */
    public function fakultasProdi()
    {
        // Ambil data Fakultas, dan juga 'programStudis' terkait
        // Ini menggunakan relasi yang sudah kita buat!
        $fakultas = Fakultas::with('programStudis')
                            ->orderBy('nama_fakultas', 'asc')
                            ->get();

        return view('public.fakultas-prodi', compact('fakultas'));
    }
}
