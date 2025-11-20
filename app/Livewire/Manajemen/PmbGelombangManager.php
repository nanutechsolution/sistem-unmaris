<?php

namespace App\Livewire\Manajemen;

use App\Models\PmbGelombang;
use App\Models\TahunAkademik;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Manajemen Gelombang PMB')]
class PmbGelombangManager extends Component
{
    use WithPagination;

    public $showModal = false;
    public $isEditing = false;
    public ?PmbGelombang $editingGelombang = null;

    // --- Form Properties ---
    public $tahun_akademik_id;
    public $nama_gelombang;
    public $promo; // <-- PROPERTI BARU DITAMBAHKAN
    public $tgl_mulai;
    public $tgl_selesai;
    public $aktif = false;
    
    // Dropdown Data
    public $tahunAkademiks = [];

    protected function rules()
    {
        return [
            'tahun_akademik_id' => 'required|exists:tahun_akademiks,id',
            'nama_gelombang' => 'required|string|max:255',
            'promo' => 'nullable|string|max:255', // <-- VALIDASI BARU
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
            'aktif' => 'boolean',
        ];
    }

    public function mount()
    {
        // Ambil tahun akademik terbaru (descending) untuk dropdown
        $this->tahunAkademiks = TahunAkademik::orderBy('kode_tahun', 'desc')->get();
    }

    public function resetForm()
    {
        // Tambahkan 'promo' ke reset form
        $this->reset(['tahun_akademik_id', 'nama_gelombang', 'promo', 'tgl_mulai', 'tgl_selesai', 'aktif', 'isEditing', 'editingGelombang']);
        $this->aktif = true; // Default aktif saat buat baru
        $this->resetErrorBag();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function openEditModal(PmbGelombang $gelombang)
    {
        $this->resetForm();
        $this->isEditing = true;
        $this->editingGelombang = $gelombang;

        $this->tahun_akademik_id = $gelombang->tahun_akademik_id;
        $this->nama_gelombang = $gelombang->nama_gelombang;
        $this->promo = $gelombang->promo; // <-- ISI DATA PROMO SAAT EDIT
        // Format tanggal agar bisa dibaca input type="date"
        $this->tgl_mulai = $gelombang->tgl_mulai->format('Y-m-d');
        $this->tgl_selesai = $gelombang->tgl_selesai->format('Y-m-d');
        $this->aktif = $gelombang->aktif;

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
            $this->editingGelombang->update($validatedData);
        } else {
            PmbGelombang::create($validatedData);
        }

        $this->closeModal();
        $this->resetPage();
    }

    // Toggle status aktif tanpa buka modal
    public function toggleActive(PmbGelombang $gelombang)
    {
        $gelombang->update(['aktif' => !$gelombang->aktif]);
    }

    // --- Logika Hapus ---
    public $showDeleteModal = false;
    public ?PmbGelombang $deletingGelombang = null;

    public function openDeleteModal(PmbGelombang $gelombang)
    {
        $this->deletingGelombang = $gelombang;
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->deletingGelombang = null;
    }

    public function delete()
    {
        if ($this->deletingGelombang) {
            $this->deletingGelombang->delete();
            $this->closeDeleteModal();
            $this->resetPage();
        }
    }

    public function render()
    {
        $gelombangs = PmbGelombang::with('tahunAkademik')
            ->orderBy('tahun_akademik_id', 'desc')
            ->orderBy('tgl_mulai', 'asc')
            ->paginate(10);

        return view('livewire.manajemen.pmb-gelombang-manager', [
            'gelombangs' => $gelombangs
        ]);
    }
}