<?php

namespace App\Livewire\Akademik;

use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use App\Models\Kurikulum; // <-- Import Kurikulum
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Validation\Rule as ValidationRule;

#[Layout('layouts.app')]
#[Title('Manajemen Mahasiswa')]
class MahasiswaManager extends Component
{
    use WithPagination;

    public $search = '';

    public $showModal = false;
    public $isEditing = false;
    public ?Mahasiswa $editingMahasiswa = null;

    // --- Form Properties ---
    public $nim;
    public $nama_lengkap;
    public $program_studi_id;
    public $kurikulum_id; // <-- FIELD BARU
    public $status_mahasiswa = 'Aktif';
    public $angkatan;
    public $email;
    public $no_hp;
    public $tempat_lahir;
    public $tanggal_lahir;
    public $jenis_kelamin;
    public $alamat;
    
    // Data Dropdown
    public $programStudis = [];
    public $kurikulums = []; // <-- Dropdown Dinamis

    protected function rules()
    {
        return [
            'nim' => [
                'required', 'string', 'max:20',
                $this->isEditing
                    ? ValidationRule::unique('mahasiswas')->ignore($this->editingMahasiswa->id)
                    : ValidationRule::unique('mahasiswas')
            ],
            'nama_lengkap' => 'required|string|max:255',
            'program_studi_id' => 'required|exists:program_studis,id',
            'kurikulum_id' => 'nullable|exists:kurikulums,id', // Boleh kosong tapi sebaiknya diisi
            'status_mahasiswa' => 'required|in:Aktif,Cuti,Lulus,Drop Out,Meninggal Dunia',
            'angkatan' => 'required|numeric|digits:4',
            'email' => ['nullable', 'email', 'max:255', $this->isEditing ? ValidationRule::unique('mahasiswas')->ignore($this->editingMahasiswa->id) : ValidationRule::unique('mahasiswas')],
            'no_hp' => 'nullable|string|max:20',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'alamat' => 'nullable|string',
        ];
    }

    public function mount()
    {
        $this->programStudis = ProgramStudi::orderBy('nama_prodi')->get();
    }

    // --- FUNGSI DINAMIS ---
    public function updatedProgramStudiId($value)
    {
        if ($value) {
            // Ambil kurikulum milik prodi tsb
            $this->kurikulums = Kurikulum::where('program_studi_id', $value)
                                         ->orderBy('tahun_mulai', 'desc')
                                         ->get();
            
            // Otomatis pilih kurikulum yang 'aktif' jika ada
            $activeKurikulum = $this->kurikulums->where('aktif', true)->first();
            if ($activeKurikulum) {
                $this->kurikulum_id = $activeKurikulum->id;
            }
        } else {
            $this->kurikulums = [];
            $this->kurikulum_id = null;
        }
    }

    public function resetForm()
    {
        $this->reset([
            'nim', 'nama_lengkap', 'program_studi_id', 'kurikulum_id', 'status_mahasiswa', 'angkatan',
            'email', 'no_hp', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'alamat',
            'isEditing', 'editingMahasiswa'
        ]);
        $this->status_mahasiswa = 'Aktif';
        $this->kurikulums = [];
        $this->resetErrorBag();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function openEditModal(Mahasiswa $mahasiswa)
    {
        $this->resetForm();
        $this->isEditing = true;
        $this->editingMahasiswa = $mahasiswa;

        $this->nim = $mahasiswa->nim;
        $this->nama_lengkap = $mahasiswa->nama_lengkap;
        $this->program_studi_id = $mahasiswa->program_studi_id;
        
        // Trigger load kurikulum
        $this->updatedProgramStudiId($this->program_studi_id);
        // Set nilai setelah dropdown terisi
        $this->kurikulum_id = $mahasiswa->kurikulum_id;

        $this->status_mahasiswa = $mahasiswa->status_mahasiswa;
        $this->angkatan = $mahasiswa->angkatan;
        $this->email = $mahasiswa->email;
        $this->no_hp = $mahasiswa->no_hp;
        $this->tempat_lahir = $mahasiswa->tempat_lahir;
        $this->tanggal_lahir = $mahasiswa->tanggal_lahir ? $mahasiswa->tanggal_lahir->format('Y-m-d') : null;
        $this->jenis_kelamin = $mahasiswa->jenis_kelamin;
        $this->alamat = $mahasiswa->alamat;
        
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function save()
    {
        $validatedData = $this->validate();

        if ($this->isEditing) {
            $this->editingMahasiswa->update($validatedData);
        } else {
            Mahasiswa::create($validatedData);
        }

        $this->closeModal();
        $this->resetPage();
    }

    // --- Logika Hapus ---
    public $showDeleteModal = false;
    public ?Mahasiswa $deletingMahasiswa = null;

    public function openDeleteModal(Mahasiswa $mahasiswa)
    {
        $this->deletingMahasiswa = $mahasiswa;
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->deletingMahasiswa = null;
    }

    public function delete()
    {
        if ($this->deletingMahasiswa) {
            $this->deletingMahasiswa->delete();
            $this->closeDeleteModal();
            $this->resetPage();
        }
    }

    public function render()
    {
        $mahasiswas = Mahasiswa::with(['programStudi', 'kurikulum'])
            ->when($this->search, function ($query) {
                $query->where('nama_lengkap', 'like', '%' . $this->search . '%')
                      ->orWhere('nim', 'like', '%' . $this->search . '%');
            })
            ->orderBy('nama_lengkap', 'asc')
            ->paginate(10);

        return view('livewire.akademik.mahasiswa-manager', [
            'mahasiswas' => $mahasiswas,
        ]);
    }
}