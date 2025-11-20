<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class DokumenController extends Controller
{
    // Tampilkan daftar dokumen
    public function index(Request $request)
{
    $query = Dokumen::with('kategori', 'fakultas', 'programStudi');

    // Filter berdasarkan kategori
    if ($request->filled('kategori_id')) {
        $query->where('kategori_id', $request->kategori_id);
    }

    // Filter berdasarkan fakultas
    if ($request->filled('fakultas_id')) {
        $query->where('fakultas_id', $request->fakultas_id);
    }

    // Filter berdasarkan program studi
    if ($request->filled('program_studi_id')) {
        $query->where('program_studi_id', $request->program_studi_id);
    }

    // Filter berdasarkan kata kunci judul
    if ($request->filled('search')) {
        $query->where('judul', 'like', '%'.$request->search.'%');
    }

    $dokumens = $query->orderBy('created_at', 'desc')->get();

    // Ambil daftar kategori, fakultas, dan prodi untuk dropdown filter
    $kategoris = \App\Models\DokumenKategori::all();
    $fakultas = \App\Models\Fakultas::all();
    $prodis = \App\Models\ProgramStudi::all();

    return view('public.dokumen.index', compact('dokumens', 'kategoris', 'fakultas', 'prodis'));
}

    // Unduh dokumen
    public function download(Dokumen $dokumen)
    {
        // Increment download count
        $dokumen->incrementDownload();

        // Pastikan file ada di storage
        if (!Storage::exists($dokumen->file_path)) {
            abort(Response::HTTP_NOT_FOUND, 'File tidak ditemukan.');
        }

        return Storage::download($dokumen->file_path, $dokumen->judul . '.' . $dokumen->file_type);
    }
}
