<?php

namespace App\Livewire\Akademik;

use App\Models\Dosen;
use App\Models\ProgramStudi;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Validation\Rule as ValidationRule;

#[Layout('layouts.app')]
#[Title('Manajemen Dosen')]
class DosenManager extends Component
{
    use WithPagination;

    public $search = '';

    // --- Properti Modal & Form ---
    public $showModal = false;
    public $isEditing = false;
    public ?Dosen $editingDosen = null;

    // --- Properti Form ---
    public $nidn;
    public $nama_lengkap;
    public $program_studi_id;
    public $status_dosen = 'Aktif';
    public $email;
    public $no_hp;
    // -------------------------

    // Properti untuk dropdown
    public $programStudis = [];

    protected function rules()
    {
        return [
            'nidn' => [
                'required', 'string', 'max:20',
                $this->isEditing
                    ? ValidationRule::unique('dosens')->ignore($this->editingDosen->id)
                    : ValidationRule::unique('dosens')
            ],
            'nama_lengkap' => 'required|string|max:255',
            'program_studi_id' => 'required|exists:program_studis,id',
            'status_dosen' => 'required|in:Aktif,Tidak Aktif,Tugas Belajar',
            'email' => [
                'nullable', 'email', 'max:255',
                $this->isEditing
                    ? ValidationRule::unique('dosens')->ignore($this->editingDosen->id)
                    : ValidationRule::unique('dosens')
            ],
            'no_hp' => 'nullable|string|max:20',
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
            'nidn', 'nama_lengkap', 'program_studi_id', 'status_dosen', 'email', 'no_hp',
            'isEditing', 'editingDosen'
        ]);
        $this->status_dosen = 'Aktif';
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

        $this->nidn = $dosen->nidn;
        $this->nama_lengkap = $dosen->nama_lengkap;
        $this->program_studi_id = $dosen->program_studi_id;
        $this->status_dosen = $dosen->status_dosen;
        $this->email = $dosen->email;
        $this->no_hp = $dosen->no_hp;

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

        if ($this->isEditing) {
            $this->editingDosen->update($validatedData);
        } else {
            Dosen::create($validatedData);
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
            $this->deletingDosen->delete();
            $this->closeDeleteModal();
            $this->resetPage();
        }
    }
    // --- Akhir Logika Hapus ---

    public function render()
    {
        $dosens = Dosen::with('programStudi')
            ->when($this->search, function ($query) {
                $query->where('nama_lengkap', 'like', '%' . $this->search . '%')
                      ->orWhere('nidn', 'like', '%' . $this->search . '%');
            })
            ->orderBy('nama_lengkap', 'asc')
            ->paginate(10);

        return view('livewire.akademik.dosen-manager', [
            'dosens' => $dosens,
        ]);
    }
}
