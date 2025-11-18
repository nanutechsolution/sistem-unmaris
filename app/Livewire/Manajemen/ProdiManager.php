<?php

namespace App\Livewire\Manajemen;

use App\Models\Fakultas;
use App\Models\ProgramStudi;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Rule;
use Illuminate\Validation\Rule as ValidationRule; // <-- Import Rule bawaan Laravel

#[Layout('layouts.app')]
#[Title('Manajemen Program Studi')]
class ProdiManager extends Component
{
    public $prodis;
    public $fakultas;
    public $showModal = false;
    public $isEditing = false;
    public ?ProgramStudi $editingProdi = null;

    // --- Properti Form ---

    #[Rule('required|exists:fakultas,id')]
    public $fakultas_id;
    public $kode_prodi;
    public $nama_prodi;
    public $jenjang = 'S1';
    public $akreditasi;
    // ---------------------


    public $showDeleteModal = false;
    public ?ProgramStudi $deletingProdi = null;

    // Method untuk mendefinisikan rules secara dinamis
    protected function rules()
    {
        return [
            // Saat edit, rule unique harus mengabaikan ID prodi itu sendiri
            'fakultas_id' => 'required|exists:fakultas,id',
            'kode_prodi' => [
                'required',
                'string',
                'max:10',
                $this->isEditing
                    ? ValidationRule::unique('program_studis')->ignore($this->editingProdi->id)
                    : ValidationRule::unique('program_studis')
            ],
            'nama_prodi' => 'required|string|max:255',
            'jenjang' => 'required|in:D3,S1,S2,S3',
            'akreditasi' => 'nullable|string|max:5',
        ];
    }

    public function mount()
    {
        $this->loadProdis();
        $this->loadFakultas();
    }



    public function loadProdis()
    {
        $this->prodis = ProgramStudi::orderBy('nama_prodi', 'asc')->get();
    }

    public function loadFakultas()
    {
        $this->fakultas = Fakultas::orderBy('nama_fakultas')->get();
    }

    // Mengosongkan form dan state
    public function resetForm()
    {
        $this->reset(['fakultas_id','kode_prodi', 'nama_prodi', 'jenjang', 'akreditasi', 'isEditing', 'editingProdi']);
        $this->jenjang = 'S1';
    }

    // Fungsi untuk membuka modal (Mode CREATE)
    public function openCreateModal()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }

    // Fungsi untuk membuka modal (Mode EDIT)
    public function openEditModal(ProgramStudi $prodi)
    {
        $this->resetForm();
        $this->isEditing = true;
        $this->editingProdi = $prodi;

        // Isi form dengan data yang ada
        $this->fakultas_id = $prodi->fakultas_id;
        $this->kode_prodi = $prodi->kode_prodi;
        $this->nama_prodi = $prodi->nama_prodi;
        $this->jenjang = $prodi->jenjang;
        $this->akreditasi = $prodi->akreditasi;

        $this->showModal = true;



    }

public function openModal()
    {
        $this->showModal = true;
    }
    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm(); // <-- Bersihkan form saat modal ditutup
    }

    // Fungsi untuk MENYIMPAN (Create ATAU Update)
    public function save()
    {
        // Validasi akan dijalankan otomatis menggunakan method rules()
        $validatedData = $this->validate();

        if ($this->isEditing) {
            // --- Proses UPDATE ---
            $this->editingProdi->update($validatedData);
            session()->flash('message', 'Data prodi berhasil diperbarui.');
        } else {
            // --- Proses CREATE ---
            ProgramStudi::create($validatedData);
            session()->flash('message', 'Data prodi berhasil disimpan.');
        }

        $this->loadProdis();
        $this->closeModal();
    }


    // Fungsi untuk membuka modal konfirmasi hapus
    public function openDeleteModal(ProgramStudi $prodi)
    {
        $this->deletingProdi = $prodi;
        $this->showDeleteModal = true;
    }

    // Fungsi untuk menutup modal konfirmasi hapus
    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->deletingProdi = null;
    }

    // Fungsi untuk EKSEKUSI HAPUS
    public function delete()
    {
        if ($this->deletingProdi) {
            $this->deletingProdi->delete();
            $this->loadProdis();
            $this->closeDeleteModal();
            session()->flash('message', 'Data prodi berhasil dihapus.');
        }
    }

    public function render()
    {
        return view('livewire.manajemen.prodi-manager');
    }
}
