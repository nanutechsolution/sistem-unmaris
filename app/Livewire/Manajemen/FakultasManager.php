<?php

namespace App\Livewire\Manajemen;

use App\Models\Fakultas; // <-- Ganti
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Validation\Rule as ValidationRule;

#[Layout('layouts.app')]
#[Title('Manajemen Fakultas')] // <-- Ganti
class FakultasManager extends Component
{
    public $fakultas; // <-- Ganti
    public $showModal = false;
    public $isEditing = false;
    public ?Fakultas $editingFakultas = null; // <-- Ganti

    // --- Properti Form ---
    public $kode_fakultas; // <-- Ganti
    public $nama_fakultas; // <-- Ganti
    // ---------------------

    protected function rules()
    {
        return [
            'kode_fakultas' => [
                'required', 'string', 'max:10',
                $this->isEditing
                    ? ValidationRule::unique('fakultas')->ignore($this->editingFakultas->id)
                    : ValidationRule::unique('fakultas')
            ],
            'nama_fakultas' => 'required|string|max:255',
        ];
    }

    public function mount()
    {
        $this->loadFakultas(); // <-- Ganti
    }

    public function loadFakultas() // <-- Ganti
    {
        $this->fakultas = Fakultas::orderBy('nama_fakultas', 'asc')->get(); // <-- Ganti
    }

    public function resetForm()
    {
        $this->reset(['kode_fakultas', 'nama_fakultas', 'isEditing', 'editingFakultas']); // <-- Ganti
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function openEditModal(Fakultas $fakultas) // <-- Ganti
    {
        $this->resetForm();
        $this->isEditing = true;
        $this->editingFakultas = $fakultas; // <-- Ganti

        $this->kode_fakultas = $fakultas->kode_fakultas; // <-- Ganti
        $this->nama_fakultas = $fakultas->nama_fakultas; // <-- Ganti

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
            $this->editingFakultas->update($validatedData);
        } else {
            Fakultas::create($validatedData); // <-- Ganti
        }

        $this->loadFakultas(); // <-- Ganti
        $this->closeModal();
    }

    // --- Logika Hapus ---
    public $showDeleteModal = false;
    public ?Fakultas $deletingFakultas = null; // <-- Ganti

    public function openDeleteModal(Fakultas $fakultas) // <-- Ganti
    {
        $this->deletingFakultas = $fakultas; // <-- Ganti
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->deletingFakultas = null; // <-- Ganti
    }

    public function delete()
    {
        if ($this->deletingFakultas) { // <-- Ganti
            $this->deletingFakultas->delete(); // <-- Ganti
            $this->loadFakultas(); // <-- Ganti
            $this->closeDeleteModal();
        }
    }
    // --- Akhir Logika Hapus ---

    public function render()
    {
        return view('livewire.manajemen.fakultas-manager');
    }
}
