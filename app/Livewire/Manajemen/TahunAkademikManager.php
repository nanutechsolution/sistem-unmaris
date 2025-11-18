<?php

namespace App\Livewire\Manajemen;

use App\Models\TahunAkademik;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Validation\Rule as ValidationRule;
use Illuminate\Support\Facades\DB; // <-- Import DB untuk Transaksi

#[Layout('layouts.app')]
#[Title('Manajemen Tahun Akademik')]
class TahunAkademikManager extends Component
{
    use WithPagination;

    // --- Properti Modal & Form ---
    public $showModal = false;
    public $isEditing = false;
    public ?TahunAkademik $editingTahunAkademik = null;

    // --- Properti Form ---
    public $kode_tahun;
    public $nama_tahun;
    public $semester = 'Ganjil';
    public $tgl_mulai_krs;
    public $tgl_selesai_krs;
    public $tgl_mulai_kuliah;
    public $tgl_selesai_kuliah;
    // -------------------------

    protected function rules()
    {
        return [
            'kode_tahun' => [
                'required', 'string', 'max:10',
                $this->isEditing
                    ? ValidationRule::unique('tahun_akademiks')->ignore($this->editingTahunAkademik->id)
                    : ValidationRule::unique('tahun_akademiks')
            ],
            'nama_tahun' => 'required|string|max:255',
            'semester' => 'required|in:Ganjil,Genap',
            'tgl_mulai_krs' => 'required|date',
            'tgl_selesai_krs' => 'required|date|after_or_equal:tgl_mulai_krs',
            'tgl_mulai_kuliah' => 'required|date',
            'tgl_selesai_kuliah' => 'required|date|after_or_equal:tgl_mulai_kuliah',
        ];
    }

    public function resetForm()
    {
        $this->reset([
            'kode_tahun', 'nama_tahun', 'semester', 'tgl_mulai_krs', 'tgl_selesai_krs',
            'tgl_mulai_kuliah', 'tgl_selesai_kuliah', 'isEditing', 'editingTahunAkademik'
        ]);
        $this->semester = 'Ganjil';
        $this->resetErrorBag();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function openEditModal(TahunAkademik $tahunAkademik)
    {
        $this->resetForm();
        $this->isEditing = true;
        $this->editingTahunAkademik = $tahunAkademik;

        $this->kode_tahun = $tahunAkademik->kode_tahun;
        $this->nama_tahun = $tahunAkademik->nama_tahun;
        $this->semester = $tahunAkademik->semester;
        $this->tgl_mulai_krs = $tahunAkademik->tgl_mulai_krs ? $tahunAkademik->tgl_mulai_krs->format('Y-m-d') : null;
        $this->tgl_selesai_krs = $tahunAkademik->tgl_selesai_krs ? $tahunAkademik->tgl_selesai_krs->format('Y-m-d') : null;
        $this->tgl_mulai_kuliah = $tahunAkademik->tgl_mulai_kuliah ? $tahunAkademik->tgl_mulai_kuliah->format('Y-m-d') : null;
        $this->tgl_selesai_kuliah = $tahunAkademik->tgl_selesai_kuliah ? $tahunAkademik->tgl_selesai_kuliah->format('Y-m-d') : null;

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
            $this->editingTahunAkademik->update($validatedData);
        } else {
            // Data baru selalu 'Tidak Aktif' by default
            TahunAkademik::create($validatedData + ['status' => 'Tidak Aktif']);
        }

        $this->closeModal();
        $this->resetPage();
    }

    // --- FUNGSI SPESIAL: SET AKTIF ---
    public function setAktif(TahunAkademik $tahunAkademik)
    {
        // Gunakan transaksi database untuk memastikan data konsisten
        DB::transaction(function () use ($tahunAkademik) {
            // 1. Set semua tahun akademik lain menjadi 'Tidak Aktif'
            TahunAkademik::where('id', '!=', $tahunAkademik->id)->update(['status' => 'Tidak Aktif']);

            // 2. Set tahun akademik yang dipilih menjadi 'Aktif'
            $tahunAkademik->update(['status' => 'Aktif']);
        });

        // session()->flash('message', 'Tahun akademik berhasil diaktifkan.');
    }

    public function render()
    {
        $tahunAkademiks = TahunAkademik::orderBy('kode_tahun', 'desc')->paginate(10);

        return view('livewire.manajemen.tahun-akademik-manager', [
            'tahunAkademiks' => $tahunAkademiks,
        ]);
    }
}
