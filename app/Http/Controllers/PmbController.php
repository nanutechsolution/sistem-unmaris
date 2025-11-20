<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PmbGelombang;
use Carbon\Carbon;
use Illuminate\View\View;

class PmbController extends Controller
{
    /**
     * Menampilkan Landing Page PMB.
     */
    public function index(): View
    {
        // Set locale Carbon ke Indonesia (opsional, agar nama bulan bahasa Indo)
        Carbon::setLocale('id');

        // 1. Ambil data dari Database & Ubah Formatnya
        $jadwal = PmbGelombang::with('tahunAkademik')
            ->orderBy('tahun_akademik_id', 'desc')
            ->orderBy('tgl_mulai', 'asc')
            ->get()
            ->map(function ($item) {
                $now = Carbon::now();
                
                // A. Tentukan Status (Sesuai logika dummy Anda: Dibuka/Segera/Tutup)
                $status = 'Tutup'; // Default
                
                if (!$item->aktif) {
                    $status = 'Tutup'; // Jika dimatikan manual
                } elseif ($now->between($item->tgl_mulai, $item->tgl_selesai)) {
                    $status = 'Dibuka';
                } elseif ($now->lt($item->tgl_mulai)) {
                    $status = 'Segera';
                }

                // B. Format Periode (Contoh: "Januari - Maret 2025")
                // Pastikan Carbon di-casting di Model agar bisa format()
                $periode = $item->tgl_mulai->translatedFormat('F') . ' - ' . $item->tgl_selesai->translatedFormat('F Y');

                // C. Return sebagai ARRAY agar cocok dengan View Anda ($j['key'])
                return [
                    'gelombang' => $item->nama_gelombang,
                    'periode'   => $periode,
                    'status'    => $status, // Hasilnya: 'Dibuka', 'Segera', atau 'Tutup'
                    'promo'     => $item->promo ?? 'Normal', // Jika null, isi 'Normal'
                ];
            });

        // 2. Data Biaya (Masih Dummy / Statis sesuai request)
        $biaya = [
            'Reguler' => [
                'pendaftaran' => 250000,
                'spp_semester' => 3500000,
                'dpp_awal' => 5000000, 
                'lainnya' => 1000000, 
            ]
        ];

        // Pastikan nama view sesuai dengan file yang ada: 'public.pmb-index'
        // Jika nama file view Anda adalah 'public.pmb.index', ganti di bawah ini
        return view('public.pmb.index', compact('jadwal', 'biaya'));
    }
}