<?php

namespace App\Livewire\Perkuliahan;

use App\Models\TahunAkademik;
use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\KrsDetail;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;

#[Layout('layouts.app')]
#[Title('Input Nilai Perkuliahan')]
class InputNilai extends Component
{
    public $activeTahunAkademik;
    public $dosen;
    public $kelasList = []; // Daftar kelas yang diampu

    // --- Detail ---
    public ?Kelas $selectedKelas = null;
    public $mahasiswaDiKelas = []; // Daftar mahasiswa (KrsDetail)

    // Properti untuk menampung input nilai
    // Format: $nilai[krs_detail_id]['huruf'] = 'A'
    public $nilai = [];

    public function mount()
    {
        // 1. Dapatkan Tahun Akademik Aktif
        $this->activeTahunAkademik = TahunAkademik::where('status', 'Aktif')->first();
        if (!$this->activeTahunAkademik) {
            return; // Hentikan jika T.A. tidak aktif
        }

        // 2. SIMULASI DOSEN LOGIN
        // Kita ambil dosen pertama di database sebagai contoh
        // Nanti ini akan diganti dengan Auth::user()->dosen
        $this->dosen = Dosen::first();
        if (!$this->dosen) {
            return; // Hentikan jika tidak ada data dosen
        }

        // 3. Load daftar kelas yang diampu dosen ini di T.A. aktif
        $this->kelasList = Kelas::with('mataKuliah', 'mataKuliah.programStudi')
            ->where('dosen_id', $this->dosen->id)
            ->where('tahun_akademik_id', $this->activeTahunAkademik->id)
            ->get();
    }

    // Fungsi saat dosen memilih kelas
    public function selectKelas(Kelas $kelas)
    {
        $this->selectedKelas = $kelas;

        // Ambil semua mahasiswa di kelas ini yang KRS-nya sudah disetujui
        $this->mahasiswaDiKelas = KrsDetail::with('krs', 'krs.mahasiswa')
            ->where('kelas_id', $kelas->id)
            ->whereHas('krs', function ($query) {
                $query->where('status', 'Approved');
            })
            ->join('mahasiswas', 'krs.mahasiswa_id', '=', 'mahasiswas.id') // Join untuk sorting
            ->orderBy('mahasiswas.nama_lengkap', 'asc')
            ->select('krs_details.*') // Hindari ambiguitas
            ->get();

        // Reset array nilai dan isi dengan data yang ada
        $this->nilai = [];
        foreach ($this->mahasiswaDiKelas as $mahasiswa) {
            $this->nilai[$mahasiswa->id] = [
                'huruf' => $mahasiswa->nilai_huruf,
                'angka' => $mahasiswa->nilai_angka,
            ];
        }
    }

    // Fungsi untuk kembali ke daftar kelas
    public function backToList()
    {
        $this->selectedKelas = null;
        $this->mahasiswaDiKelas = [];
        $this->nilai = [];
    }

    // Fungsi untuk menyimpan semua nilai di kelas terpilih
    public function saveNilai()
    {
        // Validasi bisa ditambahkan di sini
        // e.g., $this->validate(['nilai.*.huruf' => 'required|in:A,B,C,D,E'])

        DB::transaction(function () {
            foreach ($this->nilai as $krsDetailId => $data) {
                KrsDetail::where('id', $krsDetailId)->update([
                    'nilai_huruf' => $data['huruf'],
                    'nilai_angka' => $data['angka'],
                ]);
            }
        });

        // Muat ulang data untuk menampilkan nilai yang tersimpan
        $this->selectKelas($this->selectedKelas);

        session()->flash('message', 'Nilai berhasil disimpan.');
    }

    public function render()
    {
        // Handle error
        if (!$this->activeTahunAkademik) {
            return view('livewire.krs.pengisian-krs-error', ['message' => 'Tidak ada Tahun Akademik aktif.'])
                   ->layoutData(['header' => 'Input Nilai']);
        }
        if (!$this->dosen) {
            return view('livewire.krs.pengisian-krs-error', ['message' => 'Data Dosen tidak ditemukan.'])
                   ->layoutData(['header' => 'Input Nilai']);
        }

        return view('livewire.perkuliahan.input-nilai');
    }
}
