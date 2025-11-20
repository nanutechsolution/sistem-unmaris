<?php

namespace App\Livewire\Akademik;

use App\Models\MataKuliah;
use App\Models\ProgramStudi;
use App\Models\Kurikulum; 
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
    public $filterProdi = '';

    public $showModal = false;
    public $isEditing = false;
    public ?MataKuliah $editingMataKuliah = null;

    // --- Form Properties ---
    public $kode_mk;
    public $nama_mk;
    public $program_studi_id; 
    public $kurikulum_id;     
    public $sks;
    public $semester;
    public $sifat = 'Wajib';  
    public $syarat_sks_lulus = 0; 
    
    public $prasyarat_ids = []; 
    // -------------------------

    // Data Dropdown
    public $programStudis = [];
    public $kurikulums = []; 
    public $availablePrasyarats = [];

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
            'kurikulum_id' => 'required|exists:kurikulums,id', 
            'sks' => 'required|integer|min:0|max:6', 
            'semester' => 'required|integer|min:1|max:14',
            'sifat' => 'required|in:Wajib,Pilihan,MKDU',
            'syarat_sks_lulus' => 'integer|min:0',
            'prasyarat_ids' => 'array',
            'prasyarat_ids.*' => 'exists:mata_kuliahs,id', 
        ];
    }

    public function mount()
    {
        $this->programStudis = ProgramStudi::orderBy('nama_prodi')->get();
    }

    // Saat Prodi Berubah
    public function updatedProgramStudiId($value)
    {
        if ($value) {
            $this->kurikulums = Kurikulum::where('program_studi_id', $value)
                                         ->orderBy('tahun_mulai', 'desc')
                                         ->get();
        } else {
            $this->kurikulums = [];
        }
        $this->kurikulum_id = null;
        $this->availablePrasyarats = []; // Reset prasyarat
    }

    // Kita load semua MK lain di kurikulum ini
    public function updatedKurikulumId($value)
    {
        if ($value) {
            $query = MataKuliah::where('kurikulum_id', $value);
            
            // Jika sedang edit, jangan tampilkan diri sendiri di daftar syarat
            if ($this->isEditing && $this->editingMataKuliah) {
                $query->where('id', '!=', $this->editingMataKuliah->id);
            }

            $this->availablePrasyarats = $query->orderBy('semester')
                                               ->orderBy('nama_mk')
                                               ->get();
        } else {
            $this->availablePrasyarats = [];
        }
    }

    public function resetForm()
    {
        $this->reset([
            'kode_mk', 'nama_mk', 'program_studi_id', 'kurikulum_id', 
            'sks', 'semester', 'sifat', 'syarat_sks_lulus', 'prasyarat_ids', 
            'isEditing', 'editingMataKuliah'
        ]);
        $this->sifat = 'Wajib';
        $this->kurikulums = []; 
        $this->availablePrasyarats = [];
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
        $this->sifat = $mataKuliah->sifat;
        $this->syarat_sks_lulus = $mataKuliah->syarat_sks_lulus;

        // Isi data dropdown
        $this->updatedProgramStudiId($this->program_studi_id);
        $this->kurikulum_id = $mataKuliah->kurikulum_id;
        
        // Load Prasyarat
        $this->updatedKurikulumId($this->kurikulum_id); // Load list available
        // Ambil ID prasyarat yang sudah tersimpan
        $this->prasyarat_ids = $mataKuliah->prasyarats()->pluck('prasyarat_id')->toArray();
        
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

        // Kita pisahkan data MK dan data relasi prasyarat
        $mkData = collect($validatedData)->except(['prasyarat_ids'])->toArray();

        if ($this->isEditing) {
            $this->editingMataKuliah->update($mkData);
            $mk = $this->editingMataKuliah;
        } else {
            $mk = MataKuliah::create($mkData);
        }

        // Sync Prasyarat (Many-to-Many)
        // Ini akan mengisi tabel mk_prasyarats
        $mk->prasyarats()->sync($this->prasyarat_ids);

        $this->closeModal();
        $this->resetPage();
    }

    public $showDeleteModal = false;
    public ?MataKuliah $deletingMataKuliah = null;
    public function openDeleteModal(MataKuliah $mataKuliah) { $this->deletingMataKuliah = $mataKuliah; $this->showDeleteModal = true; }
    public function closeDeleteModal() { $this->showDeleteModal = false; $this->deletingMataKuliah = null; }
    public function delete() { if ($this->deletingMataKuliah) { try { $this->deletingMataKuliah->delete(); $this->closeDeleteModal(); $this->resetPage(); } catch (\Exception $e) { session()->flash('error', 'Gagal menghapus: MK ini sudah digunakan.'); $this->closeDeleteModal(); } } }

    public function render()
    {
        $mataKuliahs = MataKuliah::with(['programStudi', 'kurikulum', 'prasyarats']) // Eager load prasyarat
            ->when($this->filterProdi, function ($query) {
                $query->where('program_studi_id', $this->filterProdi);
            })
            ->when($this->search, function ($query) {
                $query->where(function($q) {
                    $q->where('nama_mk', 'like', '%' . $this->search . '%')
                      ->orWhere('kode_mk', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('program_studi_id')
            ->orderBy('semester', 'asc')
            ->orderBy('nama_mk', 'asc')
            ->paginate(10);

        return view('livewire.akademik.mata-kuliah-manager', [
            'mataKuliahs' => $mataKuliahs,
        ]);
    }
}