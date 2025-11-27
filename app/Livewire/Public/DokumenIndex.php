<?php

namespace App\Livewire\Public;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Dokumen;
use App\Models\DokumenKategori;
use App\Models\Fakultas;
use App\Models\ProgramStudi;
use Livewire\Attributes\Url;

class DokumenIndex extends Component
{
    use WithPagination;

    // Filter Properties (Live)
    // #[Url] membuat filter tetap ada di address bar browser
    #[Url(as: 'q')] 
    public $search = '';
    
    #[Url(as: 'kategori')]
    public $kategori_id = '';

    #[Url(as: 'fakultas')]
    public $fakultas_id = '';

    #[Url(as: 'prodi')]
    public $program_studi_id = '';

    // Reset pagination saat filter berubah
    public function updatedSearch() { $this->resetPage(); }
    public function updatedKategoriId() { $this->resetPage(); }
    public function updatedFakultasId() { $this->resetPage(); }
    public function updatedProgramStudiId() { $this->resetPage(); }

    public function resetFilter()
    {
        $this->reset(['search', 'kategori_id', 'fakultas_id', 'program_studi_id']);
        $this->resetPage();
    }

    public function render()
    {
        // Query Utama
        $dokumens = Dokumen::where('akses', 'Publik') // Hanya yg publik
            ->when($this->search, function($q) {
                $q->where('judul', 'like', '%'.$this->search.'%')
                  ->orWhere('deskripsi', 'like', '%'.$this->search.'%');
            })
            ->when($this->kategori_id, function($q) {
                $q->where('kategori_id', $this->kategori_id);
            })
            ->when($this->fakultas_id, function($q) {
                $q->where('fakultas_id', $this->fakultas_id);
            })
            ->when($this->program_studi_id, function($q) {
                $q->where('program_studi_id', $this->program_studi_id);
            })
            ->with(['kategori', 'fakultas', 'programStudi'])
            ->orderByDesc('created_at')
            ->paginate(9); // 9 item per halaman

        // Data untuk Dropdown Filter
        $kategoris = DokumenKategori::orderBy('nama')->get();
        $fakultas = Fakultas::orderBy('nama_fakultas')->get();
        
        // Prodi menyesuaikan fakultas yang dipilih (Dependent Dropdown)
        $prodis = ProgramStudi::when($this->fakultas_id, function($q) {
                $q->where('fakultas_id', $this->fakultas_id);
            })
            ->orderBy('nama_prodi')
            ->get();

        return view('livewire.public.dokumen-index', [
            'dokumens' => $dokumens,
            'kategoris' => $kategoris,
            'fakultas' => $fakultas,
            'prodis' => $prodis
        ])->layout('components.layouts.public', ['title' => 'Arsip Dokumen Digital']);
    }
}