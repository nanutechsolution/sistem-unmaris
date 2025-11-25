<?php

namespace App\Livewire\Public;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pengumuman;

class PengumumanIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $kategori = '';

    // Reset halaman ke 1 saat user mencari/filter
    public function updatedSearch() { $this->resetPage(); }
    public function updatedKategori() { $this->resetPage(); }

    // Ganti kategori via Sidebar
    public function setKategori($kategori)
    {
        $this->kategori = $kategori;
    }

    public function render()
    {
        // Query Utama
        $query = Pengumuman::tayang() // Hanya yg published & tanggal lewat
            ->urutkan() // Pinned paling atas, lalu tanggal terbaru
            ->when($this->search, function($q) {
                $q->where('judul', 'like', '%'.$this->search.'%');
            })
            ->when($this->kategori, function($q) {
                $q->where('kategori', $this->kategori);
            });

        // Ambil data dengan Pagination (7 item: 1 Headline + 6 Grid)
        $pengumumans = $query->paginate(7);

        return view('livewire.public.pengumuman-index', [
            'pengumumans' => $pengumumans
        ])->layout('components.layouts.public', ['title' => 'Kabar Kampus & Pengumuman']);
    }
}