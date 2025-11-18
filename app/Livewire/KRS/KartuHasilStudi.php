<?php

namespace App\Livewire\KRS;

use App\Models\Mahasiswa;
use App\Models\Krs;
use App\Models\KrsDetail;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Kartu Hasil Studi')]
class KartuHasilStudi extends Component
{
    public $mahasiswa;
    public $krsSemesterList = []; // Daftar semester yg pernah diambil

    // --- Detail KHS ---
    public ?Krs $selectedKrs = null;
    public $krsDetails = [];
    public $ips = 0;
    public $ipk = 0;
    public $totalSksSemester = 0;
    public $totalSksKumulatif = 0;

    // Fungsi konversi nilai
    private function getNilaiBobot($huruf)
    {
        switch ($huruf) {
            case 'A': return 4.0;
            case 'B': return 3.0;
            case 'C': return 2.0;
            case 'D': return 1.0;
            case 'E': return 0.0;
            default: return 0.0;
        }
    }

    public function mount()
    {
        // 1. SIMULASI MAHASISWA LOGIN
        $this->mahasiswa = Mahasiswa::with('programStudi')->first();
        if (!$this->mahasiswa) {
            return;
        }

        // 2. Load semua Krs yang statusnya "Approved"
        $this->krsSemesterList = Krs::with('tahunAkademik')
            ->where('mahasiswa_id', $this->mahasiswa->id)
            ->where('status', 'Approved')
            ->orderBy('id', 'desc')
            ->get();
    }

    // Fungsi saat mahasiswa memilih semester
    public function selectSemester(Krs $krs)
    {
        $this->selectedKrs = $krs;

        // 1. Load detail KHS untuk semester ini
        $this->krsDetails = KrsDetail::with('mataKuliah')
            ->where('krs_id', $krs->id)
            ->where('status_ambil', 'Approved') // Hanya yang disetujui
            ->get();

        // 2. Hitung IPS (Indeks Prestasi Semester)
        $totalBobotSemester = 0;
        $this->totalSksSemester = 0;
        foreach ($this->krsDetails as $detail) {
            $bobot = $this->getNilaiBobot($detail->nilai_huruf);
            $detail->bobot = $bobot * $detail->sks; // Tambah properti 'bobot'

            $totalBobotSemester += $detail->bobot;
            $this->totalSksSemester += $detail->sks;
        }

        $this->ips = $this->totalSksSemester > 0
            ? number_format($totalBobotSemester / $this->totalSksSemester, 2)
            : 0;

        // 3. Hitung IPK (Indeks Prestasi Kumulatif)
        $semuaKrsSelesai = Krs::with('details')
            ->where('mahasiswa_id', $this->mahasiswa->id)
            ->where('status', 'Approved')
            ->where('id', '<=', $krs->id) // Semua Krs sampai semester ini
            ->get();

        $totalBobotKumulatif = 0;
        $this->totalSksKumulatif = 0;

        foreach ($semuaKrsSelesai as $semester) {
            foreach ($semester->details as $detail) {
                $bobot = $this->getNilaiBobot($detail->nilai_huruf);
                $totalBobotKumulatif += $bobot * $detail->sks;
                $this->totalSksKumulatif += $detail->sks;
            }
        }

        $this->ipk = $this->totalSksKumulatif > 0
            ? number_format($totalBobotKumulatif / $this->totalSksKumulatif, 2)
            : 0;
    }

    public function render()
    {
        if (!$this->mahasiswa) {
            return view('livewire.krs.pengisian-krs-error', ['message' => 'Data mahasiswa tidak ditemukan.'])
                   ->layoutData(['header' => 'Kartu Hasil Studi']);
        }

        return view('livewire.krs.kartu-hasil-studi');
    }
}
