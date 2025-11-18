<?php

namespace App\Livewire\KRS;

use App\Models\TahunAkademik;
use App\Models\Mahasiswa;
use App\Models\Kelas;
use App\Models\Krs;
use App\Models\KrsDetail;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

#[Layout('layouts.app')]
#[Title('Pengisian Kartu Rencana Studi')]
class PengisianKrs extends Component
{
    public $activeTahunAkademik;
    public $mahasiswa;
    public $krsHeader;

    public $kelasList = []; // Daftar kelas yang ditawarkan
    public $krsDetails = []; // Daftar kelas yang sudah diambil

    public $totalSks = 0;
    public $maxSks = 24; // Nanti bisa dinamis

    public function mount()
    {
        // 1. Dapatkan Tahun Akademik Aktif
        $this->activeTahunAkademik = TahunAkademik::where('status', 'Aktif')->first();
        if (!$this->activeTahunAkademik) {
            // Jika tidak ada TA Aktif, hentikan
            return;
        }

        // 2. SIMULASI MAHASISWA LOGIN
        // Kita ambil mahasiswa pertama di database sebagai contoh
        // Nanti ini akan diganti dengan Auth::user()->mahasiswa
        $this->mahasiswa = Mahasiswa::first();
        if (!$this->mahasiswa) {
            // Jika tidak ada mahasiswa, hentikan
            return;
        }

        // 3. Cari atau Buat "Keranjang" KRS (Header)
        $this->krsHeader = Krs::firstOrCreate(
            [
                'mahasiswa_id' => $this->mahasiswa->id,
                'tahun_akademik_id' => $this->activeTahunAkademik->id,
            ],
            [
                'program_studi_id' => $this->mahasiswa->program_studi_id,
                'status' => 'Draft',
            ]
        );

        // 4. Load datanya
        $this->loadData();
    }

    public function loadData()
    {
        // 4a. Load kelas yang sudah diambil
        $this->krsDetails = KrsDetail::with('kelas', 'mataKuliah')
            ->where('krs_id', $this->krsHeader->id)
            ->get();

        // 4b. Hitung SKS yang sudah diambil
        $this->totalSks = $this->krsDetails->sum('sks');

        // 4c. Load kelas yang ditawarkan (sesuai prodi mahasiswa)
        $kelasDiambilIds = $this->krsDetails->pluck('kelas_id');

        $this->kelasList = Kelas::with('mataKuliah', 'dosen')
            ->where('tahun_akademik_id', $this->activeTahunAkademik->id)
            // Filter by prodi mahasiswa
            ->whereHas('mataKuliah', function ($query) {
                $query->where('program_studi_id', $this->mahasiswa->program_studi_id);
            })
            // Jangan tampilkan kelas yang sudah diambil
            ->whereNotIn('id', $kelasDiambilIds)
            ->get();
    }

    // Fungsi untuk MENGAMBIL KELAS
    public function ambilKelas(Kelas $kelas)
    {
        // 1. Cek SKS
        $sksCalon = $this->totalSks + $kelas->mataKuliah->sks;
        if ($sksCalon > $this->maxSks) {
            session()->flash('error', 'Batas SKS ('.$this->maxSks.') akan terlampaui.');
            return;
        }

        // 2. Cek Kuota (Nanti, setelah kita implementasi 'jumlah_pendaftar')
        // if ($kelas->jumlah_pendaftar >= $kelas->kuota) { ... }

        // 3. Cek Bentrok Jadwal (Nanti)

        // 4. Simpan ke database
        DB::transaction(function () use ($kelas) {
            KrsDetail::create([
                'krs_id' => $this->krsHeader->id,
                'kelas_id' => $kelas->id,
                'mata_kuliah_id' => $kelas->mata_kuliah_id,
                'sks' => $kelas->mataKuliah->sks,
                'status_ambil' => 'Pending',
            ]);

            // 5. Update SKS di Header
            $this->krsHeader->total_sks = $this->krsHeader->details->sum('sks');
            $this->krsHeader->save();
        });

        // 6. Muat ulang data
        $this->loadData();
    }

    // Fungsi untuk MEMBATALKAN KELAS
    public function hapusKelas(KrsDetail $krsDetail)
    {
        DB::transaction(function () use ($krsDetail) {
            $krsDetail->delete();

            // Update SKS di Header
            $this->krsHeader->total_sks = $this->krsHeader->details->sum('sks');
            $this->krsHeader->save();
        });

        $this->loadData();
    }

    public function render()
    {
        // Jika mount() gagal (misal tidak ada TA Aktif)
        if (!$this->activeTahunAkademik) {
            return view('livewire.krs.pengisian-krs-error', ['message' => 'Saat ini tidak ada Tahun Akademik yang aktif untuk pengisian KRS.']);
        }
        if (!$this->mahasiswa) {
            return view('livewire.krs.pengisian-krs-error', ['message' => 'Data mahasiswa tidak ditemukan.']);
        }

        return view('livewire.krs.pengisian-krs');
    }
}
