<?php

namespace App\Livewire\Manajemen;

use App\Models\Kurikulum;
use App\Models\ProgramStudi;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

#[Layout('layouts.app')]
#[Title('Manajemen Kurikulum')]
class KurikulumManager extends Component
{
    use WithPagination;

    public $showModal = false;
    public $isEditing = false;
    public ?Kurikulum $editingKurikulum = null;

    // --- Form Properties ---
    public $program_studi_id;
    public $nama_kurikulum;
    public $tahun_mulai;
    public $aktif = false;
    
    // --- Filter ---
    public $filterProdi = '';

    // Data Dropdown
    public $programStudis = [];

    protected function rules()
    {
        return [
            'program_studi_id' => 'required|exists:program_studis,id',
            'nama_kurikulum' => 'required|string|max:255',
            'tahun_mulai' => 'required|digits:4|integer|min:2000|max:'.(date('Y')+5),
            'aktif' => 'boolean'
        ];
    }

    public function mount()
    {
        $this->programStudis = ProgramStudi::orderBy('nama_prodi')->get();
    }

    public function resetForm()
    {
        $this->reset(['program_studi_id', 'nama_kurikulum', 'tahun_mulai', 'aktif', 'isEditing', 'editingKurikulum']);
        $this->resetErrorBag();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function openEditModal(Kurikulum $kurikulum)
    {
        $this->resetForm();
        $this->isEditing = true;
        $this->editingKurikulum = $kurikulum;

        $this->program_studi_id = $kurikulum->program_studi_id;
        $this->nama_kurikulum = $kurikulum->nama_kurikulum;
        $this->tahun_mulai = $kurikulum->tahun_mulai;
        $this->aktif = $kurikulum->aktif;

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function save()
    {
        $validatedData = $this->validate();

        // Jika diset aktif, matikan kurikulum lain di prodi yang sama
        if ($this->aktif) {
            Kurikulum::where('program_studi_id', $this->program_studi_id)
                     ->update(['aktif' => false]);
        }

        if ($this->isEditing) {
            // Jika kita meng-edit dan mengubahnya jadi aktif, query di atas sudah menangani reset
            $this->editingKurikulum->update($validatedData);
        } else {
            Kurikulum::create($validatedData);
        }

        $this->closeModal();
        $this->resetPage();
    }
    
    // --- Fungsi Set Aktif Cepat ---
    public function toggleActive(Kurikulum $kurikulum)
    {
        // Jika tombol ditekan, jadikan ini aktif dan yang lain non-aktif (per prodi)
        DB::transaction(function () use ($kurikulum) {
            Kurikulum::where('program_studi_id', $kurikulum->program_studi_id)
                     ->update(['aktif' => false]);
            
            $kurikulum->update(['aktif' => true]);
        });
    }

    // --- Logika Hapus ---
    public $showDeleteModal = false;
    public ?Kurikulum $deletingKurikulum = null;

    public function openDeleteModal(Kurikulum $kurikulum)
    {
        $this->deletingKurikulum = $kurikulum;
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->deletingKurikulum = null;
    }

    public function delete()
    {
        if ($this->deletingKurikulum) {
            try {
                $this->deletingKurikulum->delete();
                $this->closeDeleteModal();
                $this->resetPage();
            } catch (\Exception $e) {
                // Biasanya error foreign key constraint jika sudah ada mata kuliah
                session()->flash('error', 'Gagal menghapus: Kurikulum ini sudah memiliki Mata Kuliah.');
                $this->closeDeleteModal();
            }
        }
    }

    public function render()
    {
        $kurikulums = Kurikulum::with('programStudi')
            ->when($this->filterProdi, function($q) {
                $q->where('program_studi_id', $this->filterProdi);
            })
            ->orderBy('program_studi_id') // Group by prodi visual
            ->orderBy('tahun_mulai', 'desc')
            ->paginate(10);

        return view('livewire.manajemen.kurikulum-manager', [
            'kurikulums' => $kurikulums
        ]);
    }
}