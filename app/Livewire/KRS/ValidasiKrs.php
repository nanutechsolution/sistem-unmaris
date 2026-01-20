<?php

namespace App\Livewire\KRS;

use App\Models\Krs;
use App\Models\KrsDetail;
use App\Models\TahunAkademik;
use App\Models\ProgramStudi;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Validasi Kartu Rencana Studi')]
class ValidasiKrs extends Component
{
    use WithPagination;

    public $activeTahunAkademik;
    public $programStudis = [];

    // --- Filter & Search ---
    public $filterProdi;
    public $filterStatus = 'Submitted'; // Default tampilkan yang 'Submitted'
    public $search = '';

    // --- Detail ---
    public ?Krs $selectedKrs = null;
    public $krsDetails = [];

    public function mount()
    {
        $this->activeTahunAkademik = TahunAkademik::where('status', 'Aktif')->first();
        $this->programStudis = ProgramStudi::orderBy('nama_prodi')->get();
    }

    // Fungsi untuk menampilkan detail
    public function selectKrs(Krs $krs)
    {
        $this->selectedKrs = $krs->load('mahasiswa', 'mahasiswa.programStudi');
        $this->krsDetails = KrsDetail::with('mataKuliah', 'kelas', 'kelas.dosen')
            ->where('krs_id', $this->selectedKrs->id)
            ->get();
    }

    // Hapus detail jika filter/halaman berubah
    public function updating($property)
    {
        if (in_array($property, ['filterProdi', 'filterStatus', 'search', 'page'])) {
            $this->selectedKrs = null;
            $this->krsDetails = [];
            $this->resetPage();
        }
    }

    // --- Aksi Validasi ---

    // Aksi untuk menyetujui KRS
    public function approveKrs()
    {
        if ($this->selectedKrs) {
            $this->selectedKrs->update(['status' => 'Approved']);
            // Setujui juga semua detailnya
            KrsDetail::where('krs_id', $this->selectedKrs->id)->update(['status_ambil' => 'Approved']);

            // Tutup detail
            $this->selectedKrs = null;
            $this->krsDetails = [];
            session()->flash('message', 'KRS berhasil disetujui.');
        }
    }

    // Aksi untuk menolak KRS
    public function rejectKrs()
    {
        if ($this->selectedKrs) {
            $this->selectedKrs->update(['status' => 'Rejected']);
            // Tolak juga semua detailnya
            KrsDetail::where('krs_id', $this->selectedKrs->id)->update(['status_ambil' => 'Rejected']);

            // Tutup detail
            $this->selectedKrs = null;
            $this->krsDetails = [];
            session()->flash('message', 'KRS berhasil ditolak.');
        }
    }

    // Aksi untuk mengembalikan status ke Draft (revisi)
    public function returnToDraft()
    {
         if ($this->selectedKrs) {
            $this->selectedKrs->update(['status' => 'Draft']);
            KrsDetail::where('krs_id', $this->selectedKrs->id)->update(['status_ambil' => 'Pending']);

            // Tutup detail
            $this->selectedKrs = null;
            $this->krsDetails = [];
            // session()->flash('message', 'KRS dikembalikan ke draft mahasiswa.');
        }
    }

    public function render()
    {
        // Handle jika tidak ada TA Aktif
        if (!$this->activeTahunAkademik) {
            return view('livewire.krs.pengisian-krs-error', ['message' => 'Tidak ada Tahun Akademik aktif.'])
                   ->layoutData(['header' => 'Validasi KRS']); // Kirim header ke layout
        }

        // Query daftar KRS
        $krsQuery = Krs::with(['mahasiswa', 'mahasiswa.programStudi'])
            ->where('tahun_akademik_id', $this->activeTahunAkademik->id)
            ->when($this->filterProdi, function ($q) {
                // Filter by prodi
                $q->whereHas('mahasiswa.programStudi', function ($subQ) {
                    $subQ->where('id', $this->filterProdi);
                });
            })
            ->when($this->filterStatus, function ($q) {
                // Filter by status
                $q->where('status', $this->filterStatus);
            })
            ->when($this->search, function ($q) {
                // Filter pencarian
                $q->whereHas('mahasiswa', function ($subQ) {
                    $subQ->where('nama_lengkap', 'like', '%' . $this->search . '%')
                         ->orWhere('nim', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('updated_at', 'desc');

        $krsList = $krsQuery->paginate(15);

        return view('livewire.krs.validasi-krs', [
            'krsList' => $krsList,
        ]);
    }
}
