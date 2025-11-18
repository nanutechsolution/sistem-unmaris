<?php

namespace App\Livewire\Akademik;

use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Validation\Rule as ValidationRule; // <-- Import Rule bawaan Laravel

#[Layout('layouts.app')]
#[Title('Manajemen Mahasiswa')]
class MahasiswaManager extends Component
{
    use WithPagination;

    public $search = '';

    // --- Properti Modal & Form ---
    public $showModal = false;
    public $isEditing = false;
    public ?Mahasiswa $editingMahasiswa = null;

    // --- Properti Form (dihubungkan dengan wire:model) ---
    // Rules akan kita pindah ke method rules() agar dinamis
    public $nim;
    public $nama_lengkap;
    public $program_studi_id;
    public $status_mahasiswa = 'Aktif';
    public $angkatan;
    public $email;
    public $no_hp;
    public $tempat_lahir;
    public $tanggal_lahir;
    public $jenis_kelamin;
    public $alamat;
    // ----------------------------------------------------

    // Properti untuk menampung data dropdown
    public $programStudis = [];

    // Method untuk mendefinisikan rules secara dinamis
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
            'status_mahasiswa' => 'required|in:Aktif,Cuti,Lulus,Drop Out,Meninggal Dunia',
            'angkatan' => 'required|numeric|digits:4',
            'email' => [
                'nullable', 'email', 'max:255',
                $this->isEditing
                    ? ValidationRule::unique('mahasiswas')->ignore($this->editingMahasiswa->id)
                    : ValidationRule::unique('mahasiswas')
            ],
            'no_hp' => 'nullable|string|max:20',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'alamat' => 'nullable|string',
        ];
    }

    // 'mount' dijalankan saat komponen di-load
    public function mount()
    {
        $this->loadDropdownData();
    }

    // Fungsi untuk mengambil data dropdown
    public function loadDropdownData()
    {
        $this->programStudis = ProgramStudi::orderBy('nama_prodi')->get();
    }

    // Fungsi untuk mengosongkan form
    public function resetForm()
    {
        $this->reset([
            'nim', 'nama_lengkap', 'program_studi_id', 'status_mahasiswa', 'angkatan',
            'email', 'no_hp', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'alamat',
            'isEditing', 'editingMahasiswa'
        ]);
        $this->status_mahasiswa = 'Aktif'; // Set default
        $this->resetErrorBag(); // Bersihkan error validasi
    }

    // Fungsi untuk membuka modal (Mode CREATE)
    public function openCreateModal()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }

    // Fungsi untuk membuka modal (Mode EDIT)
    public function openEditModal(Mahasiswa $mahasiswa)
    {
        $this->resetForm();
        $this->isEditing = true;
        $this->editingMahasiswa = $mahasiswa;

        // Isi form dengan data yang ada
        $this->nim = $mahasiswa->nim;
        $this->nama_lengkap = $mahasiswa->nama_lengkap;
        $this->program_studi_id = $mahasiswa->program_studi_id;
        $this->status_mahasiswa = $mahasiswa->status_mahasiswa;
        $this->angkatan = $mahasiswa->angkatan;
        $this->email = $mahasiswa->email;
        $this->no_hp = $mahasiswa->no_hp;
        $this->tempat_lahir = $mahasiswa->tempat_lahir;
        // Format tanggal untuk input type="date"
        $this->tanggal_lahir = $mahasiswa->tanggal_lahir ? $mahasiswa->tanggal_lahir->format('Y-m-d') : null;
        $this->jenis_kelamin = $mahasiswa->jenis_kelamin;
        $this->alamat = $mahasiswa->alamat;

        $this->showModal = true;
    }

    // Fungsi untuk menutup modal
    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    // Fungsi untuk MENYIMPAN (Create ATAU Update)
    public function save()
    {
        // Validasi akan dijalankan otomatis menggunakan method rules()
        $validatedData = $this->validate();

        if ($this->isEditing) {
            // --- Proses UPDATE ---
            $this->editingMahasiswa->update($validatedData);
            // session()->flash('message', 'Data mahasiswa berhasil diperbarui.');
        } else {
            // --- Proses CREATE ---
            Mahasiswa::create($validatedData);
            // session()->flash('message', 'Data mahasiswa berhasil disimpan.');
        }

        $this->closeModal();
        $this->resetPage(); // Pindah ke halaman 1 jika ada paginasi
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
            session()->flash('message', 'Data mahasiswa berhasil dihapus.');
        }
    }
    // --- Akhir Logika Hapus ---

    // Fungsi 'render'
    public function render()
    {
        $mahasiswas = Mahasiswa::with('programStudi')
            ->when($this->search, function ($query) {
                $query->where('nama_lengkap', 'like', '%' . $this->search . '%')
                      ->orWhere('nim', 'like', '%' . $this->search . '%')
                      ->orWhereHas('programStudi', function ($subQuery) {
                            $subQuery->where('nama_prodi', 'like', '%' . $this->search . '%');
                      });
            })
            ->orderBy('nama_lengkap', 'asc')
            ->paginate(10);

        return view('livewire.akademik.mahasiswa-manager', [
            'mahasiswas' => $mahasiswas,
        ]);
    }
}
