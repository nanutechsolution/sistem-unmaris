<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;

class PmbController extends Controller
{
    /**
     * Menampilkan Landing Page PMB.
     */
    public function index(): View
    {
        // Simulasi Data Jadwal Gelombang
        $jadwal = [
            [
                'gelombang' => 'Gelombang 1',
                'periode' => 'Januari - Maret 2025',
                'status' => 'Dibuka', // Dibuka, Segera, Tutup
                'promo' => 'Potongan DPP 50%'
            ],
            [
                'gelombang' => 'Gelombang 2',
                'periode' => 'April - Juni 2025',
                'status' => 'Segera',
                'promo' => 'Potongan DPP 25%'
            ],
            [
                'gelombang' => 'Gelombang 3',
                'periode' => 'Juli - Agustus 2025',
                'status' => 'Tutup',
                'promo' => 'Normal'
            ],
        ];

        // Simulasi Data Biaya (Bisa diambil dari DB nantinya)
        $biaya = [
            'Reguler' => [
                'pendaftaran' => 250000,
                'spp_semester' => 3500000,
                'dpp_awal' => 5000000, // Dana Pengembangan Pendidikan (Gedung)
                'lainnya' => 1000000, // Jas, KTM, Orientasi
            ]
        ];

        return view('public.pmb.index', compact('jadwal', 'biaya'));
    }
}