<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\ProgramStudi;
use App\Models\Post;
use App\Models\TahunAkademik;
use App\Models\Dokumen; // Asumsi ada model Dokumen Publik
use App\Models\QualityDocument; // Asumsi ada model Dokumen LPM

#[Layout('layouts.app')]
#[Title('Dashboard Sistem')]
class Dashboard extends Component
{
    public $stats = [];
    public $prodiStats = [];
    public $latestPosts = [];
    public $activeSemester;
    public $userRole;

    public function mount()
    {
        $user = Auth::user();
        $this->userRole = $user->getRoleNames()->first() ?? 'user'; // Ambil role pertama

        // 1. Ambil Tahun Akademik Aktif
        $this->activeSemester = TahunAkademik::where('status', 'Aktif')->first();

        // 2. Siapkan Data Berdasarkan Role
        if ($user->hasRole(['super_admin', 'baak'])) {
            $this->loadBaakStats();
        } elseif ($user->hasRole('lpm')) {
            $this->loadLpmStats();
        } elseif ($user->hasRole('dosen')) {
            $this->loadDosenStats();
        } else {
            // Default / Mahasiswa / CMS Admin
            $this->loadGeneralStats();
        }
    }

    // --- LOGIC PER ROLE ---

    private function loadBaakStats()
    {
        // Statistik Utama
        $this->stats = [
            'mahasiswa_aktif' => Mahasiswa::where('status_mahasiswa', 'Aktif')->count(),
            'dosen_tetap' => Dosen::where('status_kepegawaian', 'Aktif')->count(),
            'total_prodi' => ProgramStudi::count(),
            'berita_pub' => Post::where('status', 'Published')->count(),
        ];

        // Statistik Mahasiswa per Prodi (Untuk Grafik Batang)
        $this->prodiStats = ProgramStudi::withCount(['mahasiswas as total' => function($q){
            $q->where('status_mahasiswa', 'Aktif');
        }])->orderByDesc('total')->take(5)->get();

        // Berita Terbaru
        $this->latestPosts = Post::latest()->take(4)->get();
    }

    private function loadLpmStats()
    {
        $this->stats = [
            'dokumen_mutu' => QualityDocument::count(),
            'prodi_terakreditasi' => ProgramStudi::whereNotNull('akreditasi')->count(),
            // Tambahkan stat lain jika ada (misal: Temuan Audit)
        ];
        
        // Ambil list prodi untuk status akreditasi
        $this->prodiStats = ProgramStudi::orderBy('nama_prodi')->get();
    }

    private function loadDosenStats()
    {
        // Logic khusus dosen (misal: kelas yang diajar) - Sementara pakai umum
        $this->loadGeneralStats();
    }

    private function loadGeneralStats()
    {
        $this->stats = [
            'berita' => Post::count(),
            'dokumen' => Dokumen::count(),
        ];
        $this->latestPosts = Post::latest()->take(5)->get();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}