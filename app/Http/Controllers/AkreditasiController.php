<?php

namespace App\Http\Controllers;

use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AkreditasiController extends Controller
{
    /**
     * Menampilkan halaman Akreditasi Institusi (APT).
     */
    public function institusi(): View
    {
        $apt = [
            'status' => 'BAIK SEKALI',
            'sk_number' => 'SK: 1234/SK/BAN-PT/Ak-Inst/XII/2024',
            'valid_until' => '20 Desember 2029',
            'sertifikat_link' => '#', // Link download sertifikat
        ];

        // Ambil data Program Studi untuk ringkasan
        $prodi = ProgramStudi::select('nama_prodi', 'akreditasi')->get();

        return view('public.akreditasi.institusi', compact('apt', 'prodi'));
    }

    /**
     * Menampilkan daftar Akreditasi Program Studi (APS).
     */
    public function programStudi(): View
    {
        // Ambil semua data Program Studi beserta Fakultasnya
        $prodiList = ProgramStudi::with('fakultas')
                                 ->orderBy('fakultas_id')
                                 ->orderBy('nama_prodi')
                                 ->get();

        // Statistik
        $totalProdi = $prodiList->count();
        $totalFakultas = $prodiList->pluck('fakultas_id')->unique()->count();

        return view('public.akreditasi.prodi', compact('prodiList', 'totalProdi', 'totalFakultas'));
    }
}