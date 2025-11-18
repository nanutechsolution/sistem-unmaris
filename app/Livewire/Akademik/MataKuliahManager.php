<?php

namespace App\Livewire\Akademik;

use App\Models\MataKuliah;
use App\Models\ProgramStudi;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Validation\Rule as ValidationRule;

#[Layout('layouts.app')]
#[Title('Manajemen Mata Kuliah')]
class MataKuliahManager extends Component
{
    use WithPagination;

    public $search = '';

    // --- Properti Modal & Form ---
    public $showModal = false;
    public $isEditing = false;
    public ?MataKuliah $editingMataKuliah = null;

    // --- Properti Form ---
    public $kode_mk;
    public $nama_mk;
    public $program_studi_id;
    public $sks;
    public $semester;
    // -------------------------

    // Properti untuk dropdown
    public $programStudis = [];

    protected function rules()
    {
        return [
            'kode_mk' => [
                'required', 'string', 'max:20',
                $this->isEditing
                    ? ValidationRule::unique('mata_kuliahs')->ignore($this->editingMataKuliah->id)
                    : ValidationRule::unique('mata_kuliahs')
            ],
            'nama_mk' => 'required|string|max:255',
            'program_studi_id' => 'required|exists:program_studis,id',
            'sks' => 'required|integer|min:1|max:6',
            'semester' => 'required|integer|min:1|max:14',
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
            'kode_mk', 'nama_mk', 'program_studi_id', 'sks', 'semester',
            'isEditing', 'editingMataKuliah'
        ]);
        $this->resetErrorBag();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function openEditModal(MataKuliah $mataKuliah)
    {
        $this->resetForm();
        $this->isEditing = true;
        $this->editingMataKuliah = $mataKuliah;

        $this->kode_mk = $mataKuliah->kode_mk;
        $this->nama_mk = $mataKuliah->nama_mk;
        $this->program_studi_id = $mataKuliah->program_studi_id;
        $this->sks = $mataKuliah->sks;
        $this->semester = $mataKuliah->semester;

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
            $this->editingMataKuliah->update($validatedData);
        } else {
            MataKuliah::create($validatedData);
        }

        $this->closeModal();
        $this->resetPage();
    }

    // --- Logika Hapus ---
    public $showDeleteModal = false;
    public ?MataKuliah $deletingMataKuliah = null;

    public function openDeleteModal(MataKuliah $mataKuliah)
    {
        $this->deletingMataKuliah = $mataKuliah;
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->deletingMataKuliah = null;
    }

    public function delete()
    {
        if ($this->deletingMataKuliah) {
            $this->deletingMataKuliah->delete();
            $this->closeDeleteModal();
            $this->resetPage();
        }
    }
    // --- Akhir Logika Hapus ---

    public function render()
    {
        $mataKuliahs = MataKuliah::with('programStudi')
            ->when($this->search, function ($query) {
                $query->where('nama_mk', 'like', '%' . $this->search . '%')
                      ->orWhere('kode_mk', 'like', '%' . $this->search . '%');
            })
            ->orderBy('semester', 'asc')
            ->orderBy('nama_mk', 'asc')
            ->paginate(10);

        return view('livewire.akademik.mata-kuliah-manager', [
            'mataKuliahs' => $mataKuliahs,
        ]);
    }
}
