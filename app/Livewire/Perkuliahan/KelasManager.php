<?php

namespace App\Livewire\Perkuliahan;

use App\Models\Kelas;
use App\Models\TahunAkademik;
use App\Models\ProgramStudi;
use App\Models\MataKuliah;
use App\Models\Dosen;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Validation\Rule as ValidationRule;

#[Layout('layouts.app')]
#[Title('Manajemen Penawaran Kelas')]
class KelasManager extends Component
{
    use WithPagination;

    // --- Filter & Search ---
    public $search = '';
    public $filterProdi; // ID Prodi yang difilter
    public $activeTahunAkademik;

    // --- Data Dropdown ---
    public $programStudis = [];
    public $mataKuliahs = []; // Akan diisi dinamis
    public $dosens = []; // Akan diisi dinamis

    // --- Modal & Form ---
    public $showModal = false;
    public $isEditing = false;
    public ?Kelas $editingKelas = null;

    // --- Form Properties ---
    public $prodi_id_form; // Untuk memfilter dropdown MK & Dosen
    public $mata_kuliah_id;
    public $dosen_id;
    public $nama_kelas;
    public $kuota;
    public $hari;
    public $jam_mulai;
    public $jam_selesai;
    public $ruangan;

    // Aturan validasi
    protected function rules()
    {
        return [
            'prodi_id_form' => 'required|exists:program_studis,id',
            'mata_kuliah_id' => 'required|exists:mata_kuliahs,id',
            'dosen_id' => 'required|exists:dosens,id',
            'nama_kelas' => 'required|string|max:10',
            'kuota' => 'required|integer|min:1',
            'hari' => 'nullable|string|max:20',
            'jam_mulai' => 'nullable|date_format:H:i',
            'jam_selesai' => 'nullable|date_format:H:i|after:jam_mulai',
            'ruangan' => 'nullable|string|max:50',
        ];
    }

    public function mount()
    {
        // 1. Cari Tahun Akademik yang aktif
        $this->activeTahunAkademik = TahunAkademik::where('status', 'Aktif')->first();

        // 2. Load data filter
        $this->programStudis = ProgramStudi::orderBy('nama_prodi')->get();
    }

    // --- FUNGSI DINAMIS UNTUK FORM ---
    // Dipanggil setiap kali $prodi_id_form di modal berubah
    public function updatedProdiIdForm($prodiId)
    {
        if ($prodiId) {
            // Isi dropdown MK & Dosen berdasarkan prodi yang dipilih
            $this->mataKuliahs = MataKuliah::where('program_studi_id', $prodiId)->orderBy('semester')->get();
            $this->dosens = Dosen::where('program_studi_id', $prodiId)->orderBy('nama_lengkap')->get();
        } else {
            $this->mataKuliahs = [];
            $this->dosens = [];
        }
        // Reset pilihan lama
        $this->reset(['mata_kuliah_id', 'dosen_id']);
    }

    public function resetForm()
    {
        $this->reset([
            'prodi_id_form', 'mata_kuliah_id', 'dosen_id', 'nama_kelas', 'kuota',
            'hari', 'jam_mulai', 'jam_selesai', 'ruangan', 'isEditing', 'editingKelas'
        ]);
        $this->mataKuliahs = [];
        $this->dosens = [];
        $this->resetErrorBag();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function openEditModal(Kelas $kelas)
    {
        $this->resetForm();
        $this->isEditing = true;
        $this->editingKelas = $kelas;

        // Isi data dropdown dulu
        $this->prodi_id_form = $kelas->mataKuliah->program_studi_id;
        $this->updatedProdiIdForm($this->prodi_id_form); // Load data dinamis

        // Isi form
        $this->mata_kuliah_id = $kelas->mata_kuliah_id;
        $this->dosen_id = $kelas->dosen_id;
        $this->nama_kelas = $kelas->nama_kelas;
        $this->kuota = $kelas->kuota;
        $this->hari = $kelas->hari;
        $this->jam_mulai = $kelas->jam_mulai ? $kelas->jam_mulai->format('H:i') : null;
        $this->jam_selesai = $kelas->jam_selesai ? $kelas->jam_selesai->format('H:i') : null;
        $this->ruangan = $kelas->ruangan;

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function save()
    {
        $validatedData = $this->validate();

        // Tambahkan tahun akademik aktif ke data
        $validatedData['tahun_akademik_id'] = $this->activeTahunAkademik->id;

        if ($this->isEditing) {
            $this->editingKelas->update($validatedData);
        } else {
            Kelas::create($validatedData);
        }

        $this->closeModal();
        $this->resetPage();
    }

    // --- Logika Hapus ---
    public $showDeleteModal = false;
    public ?Kelas $deletingKelas = null;

    public function openDeleteModal(Kelas $kelas)
    {
        $this->deletingKelas = $kelas;
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->deletingKelas = null;
    }

    public function delete()
    {
        if ($this->deletingKelas) {
            $this->deletingKelas->delete();
            $this->closeDeleteModal();
            $this->resetPage();
        }
    }
    // --- Akhir Logika Hapus ---

    public function render()
    {
        // Jika tidak ada TA Aktif, jangan tampilkan apa-apa
        if (!$this->activeTahunAkademik) {
            return view('livewire.perkuliahan.kelas-manager-no-ta');
        }

        $query = Kelas::with(['mataKuliah', 'dosen', 'mataKuliah.programStudi'])
            ->where('tahun_akademik_id', $this->activeTahunAkademik->id)
            ->when($this->filterProdi, function ($q) {
                // Filter berdasarkan prodi
                $q->whereHas('mataKuliah', function ($subQ) {
                    $subQ->where('program_studi_id', $this->filterProdi);
                });
            })
            ->when($this->search, function ($q) {
                // Filter pencarian
                $q->where(function ($subQ) {
                    $subQ->whereHas('mataKuliah', function ($mkQ) {
                            $mkQ->where('nama_mk', 'like', '%' . $this->search . '%')
                                ->orWhere('kode_mk', 'like', '%' . $this->search . '%');
                        })
                        ->orWhereHas('dosen', function ($dQ) {
                            $dQ->where('nama_lengkap', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->orderBy('id', 'desc');

        $kelasList = $query->paginate(10);

        return view('livewire.perkuliahan.kelas-manager', [
            'kelasList' => $kelasList,
            'tahunAkademikAktif' => $this->activeTahunAkademik,
        ]);
    }
}
