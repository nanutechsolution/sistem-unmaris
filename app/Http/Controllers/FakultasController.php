<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FakultasController extends Controller
{
    /**
     * Menampilkan detail fakultas dan daftar program studinya.
     */
    public function show($id): View
    {
        // Ambil fakultas beserta program studinya
        $fakultas = Fakultas::with(['programStudis', 'currentDean'])->findOrFail($id);
        return view('public.fakultas.show', compact('fakultas'));
    }
}