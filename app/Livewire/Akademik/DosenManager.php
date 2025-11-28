<?php

namespace App\Livewire\Akademik;

use App\Models\Dosen;
use App\Models\ProgramStudi;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads; // PENTING: Untuk upload foto
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Validation\Rule as ValidationRule;
use Illuminate\Support\Facades\Storage; // PENTING: Untuk hapus foto

#[Layout('layouts.app')]
#[Title('Manajemen Dosen')]
class DosenManager extends Component
{
    use WithPagination;
    use WithFileUploads; // Aktifkan fitur upload

    public $search = '';

    // --- Properti Modal & Form ---
    public $showModal = false;
    public $isEditing = false;
    public ?Dosen $editingDosen = null;

    // --- Properti Form (Sesuai Tabel Baru) ---
    public $nidn;
    public $gelar_depan;
    public $nuptk;
    public $nama_lengkap;
    public $gelar_belakang;
    public $program_studi_id;
    public $status_kepegawaian = 'Aktif';
    public $email;
    public $no_hp;

    // Data Pribadi (Baru)
    public $jenis_kelamin;
    public $tempat_lahir;
    public $tanggal_lahir;
    public $agama;

    // Foto Profil
    public $foto_profil;      // Object (File Baru)
    public $old_foto_profil;  // String (Path Foto Lama)

    // -------------------------

    // Properti untuk dropdown
    public $programStudis = [];

    protected function rules()
    {
        return [
            // NIDN sekarang nullable karena di Excel ada yg kosong
            'nidn' => [
                'nullable',
                'string',
                'max:20',
                $this->isEditing
                    ? ValidationRule::unique('dosens')->ignore($this->editingDosen->id)
                    : ValidationRule::unique('dosens')
            ],
            'nuptk' => 'nullable|string|max:50', // Baru
            'nama_lengkap' => 'required|string|max:255',
            'program_studi_id' => 'nullable|exists:program_studis,id', // Homebase bisa null (opsional)

            // Status sesuai migration baru
            'status_kepegawaian' => 'required|in:Aktif,Keluar,Pensiun,Tugas Belajar',

            'email' => [
                'nullable',
                'email',
                'max:255',
                $this->isEditing
                    ? ValidationRule::unique('dosens')->ignore($this->editingDosen->id)
                    : ValidationRule::unique('dosens')
            ],
            'no_hp' => 'nullable|string|max:20',

            // Validasi Data Pribadi
            'jenis_kelamin' => 'nullable|in:L,P',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'agama' => 'nullable|string|max:50',
            'foto_profil' => 'nullable|image|max:2048', // Max 2MB
        ];
    }

    public function mount()
    {
        $this->loadDropdownData();
    }

    public function loadDropdownData()
    {
        $this->programStudis = ProgramStudi::orderBy('nama_prodi')->get();
    }

    public function resetForm()
    {
        $this->reset([
            'nidn',
            'gelar_depan',
            'nuptk',
            'nama_lengkap',
            'gelar_belakang',
            'program_studi_id',
            'status_kepegawaian',
            'email',
            'no_hp',
            'jenis_kelamin',
            'tempat_lahir',
            'tanggal_lahir',
            'agama',
            'foto_profil',
            'old_foto_profil',
            'isEditing',
            'editingDosen'
        ]);
        $this->status_kepegawaian = 'Aktif';
        $this->resetErrorBag();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function openEditModal(Dosen $dosen)
    {
        $this->resetForm();
        $this->isEditing = true;
        $this->editingDosen = $dosen;

        // Populate Data
        $this->nidn = $dosen->nidn;
        $this->gelar_depan = $dosen->gelar_depan;
        $this->nuptk = $dosen->nuptk;
        $this->nama_lengkap = $dosen->nama_lengkap;
        $this->gelar_belakang = $dosen->gelar_belakang;
        $this->program_studi_id = $dosen->program_studi_id;
        $this->status_kepegawaian = $dosen->status_kepegawaian;
        $this->email = $dosen->email;
        $this->no_hp = $dosen->no_hp;

        $this->jenis_kelamin = $dosen->jenis_kelamin;
        $this->tempat_lahir = $dosen->tempat_lahir;
        $this->tanggal_lahir = $dosen->tanggal_lahir ? $dosen->tanggal_lahir->format('Y-m-d') : null; // Format HTML Date
        $this->agama = $dosen->agama;

        $this->old_foto_profil = $dosen->foto_profil; // Simpan path foto lama untuk preview

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm(); // Ini akan menghapus temporary upload file juga
    }

    public function save()
    {
        $validatedData = $this->validate();

        // --- HANDLE UPLOAD FOTO ---
        if ($this->foto_profil) {
            // 1. Jika Edit & Ada foto lama, hapus dulu fisiknya
            if ($this->isEditing && $this->editingDosen->foto_profil) {
                Storage::disk('public')->delete($this->editingDosen->foto_profil);
            }
            // 2. Simpan foto baru
            $path = $this->foto_profil->store('dosen-photos', 'public');
            $validatedData['foto_profil'] = $path;
        } else {
            // Jika tidak upload baru, hapus key dari array validasi agar tidak menimpa dgn null
            unset($validatedData['foto_profil']);
        }

        // Hapus variabel temporary livewire
        unset($validatedData['old_foto_profil']);

        if ($this->isEditing) {
            $this->editingDosen->update($validatedData);
            session()->flash('success', 'Data Dosen berhasil diperbarui.');
        } else {
            Dosen::create($validatedData);
            session()->flash('success', 'Dosen baru berhasil ditambahkan.');
        }

        $this->closeModal();
        $this->resetPage();
    }

    // --- Logika Hapus ---
    public $showDeleteModal = false;
    public ?Dosen $deletingDosen = null;

    public function openDeleteModal(Dosen $dosen)
    {
        $this->deletingDosen = $dosen;
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->deletingDosen = null;
    }

    public function delete()
    {
        if ($this->deletingDosen) {
            // Hapus foto fisik jika ada
            if ($this->deletingDosen->foto_profil) {
                Storage::disk('public')->delete($this->deletingDosen->foto_profil);
            }

            $this->deletingDosen->delete();
            $this->closeDeleteModal();
            $this->resetPage();
            session()->flash('success', 'Data Dosen berhasil dihapus.');
        }
    }
    // --- Akhir Logika Hapus ---

    public function render()
    {
        $dosens = Dosen::with('programStudi')
            ->when($this->search, function ($query) {
                $query->where('nama_lengkap', 'like', '%' . $this->search . '%')
                    ->orWhere('nidn', 'like', '%' . $this->search . '%')
                    ->orWhere('nuptk', 'like', '%' . $this->search . '%'); // Tambah cari NUPTK
            })
            ->orderBy('nama_lengkap', 'asc')
            ->paginate(10);

        return view('livewire.akademik.dosen-manager', [
            'dosens' => $dosens,
        ]);
    }
}
