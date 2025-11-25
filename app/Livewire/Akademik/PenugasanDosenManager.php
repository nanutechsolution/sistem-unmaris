<?php

namespace App\Livewire\Akademik;

use App\Models\PenugasanDosen;
use App\Models\Dosen;
use App\Models\ProgramStudi;
use App\Models\TahunAkademik;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Penugasan Dosen')]
class PenugasanDosenManager extends Component
{
    use WithPagination;

    // Filters
    public $search = '';
    public $filterTahun; // Default ke tahun aktif
    public $filterProdi = '';

    // Form Properties
    public $penugasan_id;
    public $dosen_id;
    public $program_studi_id;
    public $tahun_akademik_id;
    public $status_penugasan = 'Tetap';

    // Modal
    public $showModal = false;
    public $isEditing = false;
    public $showDeleteModal = false;
    public $deletingId = null;

    // Dropdown Data
    public $listTahun = [];
    public $listProdi = [];
    public $listDosen = [];


    public $showCopyModal = false;
    public $sumberTahun;
    public function mount()
    {
        // Load Data Dropdown
        $this->listTahun = TahunAkademik::orderByDesc('kode_tahun')->get();
        $this->listProdi = ProgramStudi::orderBy('nama_prodi')->get();
        $this->listDosen = Dosen::orderBy('nama_lengkap')->get();

        // Set Default Filter ke Tahun Aktif
        $aktif = TahunAkademik::where('status', 'Aktif')->first();
        $this->filterTahun = $aktif ? $aktif->id : ($this->listTahun->first()->id ?? null);
    }

    public function openCopyModal()
    {
        // Default: Ambil tahun ajaran sebelum tahun yang sedang dipilih
        $prev = \App\Models\TahunAkademik::where('id', '<', $this->filterTahun)
            ->orderByDesc('id')
            ->first();

        $this->sumberTahun = $prev ? $prev->id : null;
        $this->showCopyModal = true;
    }

    public function copySemester()
    {
        $this->validate([
            'sumberTahun' => 'required|exists:tahun_ajarans,id',
            'filterTahun' => 'required|exists:tahun_ajarans,id', // Target tahun (dari filter)
        ]);

        if ($this->sumberTahun == $this->filterTahun) {
            $this->addError('sumberTahun', 'Tahun sumber dan tujuan tidak boleh sama.');
            return;
        }

        // 1. Ambil semua data dari semester lalu
        $dataLama = PenugasanDosen::where('tahun_akademik_id', $this->sumberTahun)->get();

        if ($dataLama->isEmpty()) {
            $this->addError('sumberTahun', 'Tidak ada data pada tahun ajaran sumber.');
            return;
        }

        $berhasil = 0;
        $gagal = 0;

        foreach ($dataLama as $item) {
            // 2. Cek apakah di semester baru sudah ada? (Biar tidak duplikat)
            $exists = PenugasanDosen::where('tahun_akademik_id', $this->filterTahun)
                ->where('dosen_id', $item->dosen_id)
                ->where('program_studi_id', $item->program_studi_id)
                ->exists();

            // 3. Kalau belum ada, Copy!
            if (!$exists) {
                PenugasanDosen::create([
                    'dosen_id' => $item->dosen_id,
                    'program_studi_id' => $item->program_studi_id,
                    'tahun_akademik_id' => $this->filterTahun, // ID Tahun Baru
                    'status_penugasan' => $item->status_penugasan, // Status (Tetap/LB) ikut yang lama
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $berhasil++;
            } else {
                $gagal++; // Sudah ada (skip)
            }
        }

        $this->showCopyModal = false;

        $msg = "Berhasil menyalin $berhasil data.";
        if ($gagal > 0) $msg .= " ($gagal data dilewati karena sudah ada)";

        session()->flash('success', $msg);
    }

    public function render()
    {
        $data = PenugasanDosen::with(['dosen', 'programStudi', 'TahunAkademik'])
            ->where('tahun_akademik_id', $this->filterTahun) // Filter Wajib
            ->when($this->filterProdi, function ($q) {
                $q->where('program_studi_id', $this->filterProdi);
            })
            ->when($this->search, function ($q) {
                $q->whereHas('dosen', function ($sub) {
                    $sub->where('nama_lengkap', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('program_studi_id') // Kelompokkan per prodi biar rapi
            ->paginate(10);

        return view('livewire.akademik.penugasan-dosen-manager', [
            'penugasans' => $data
        ]);
    }

    // --- CRUD ---

    public function openCreateModal()
    {
        $this->reset(['penugasan_id', 'dosen_id', 'program_studi_id']);
        // Auto set tahun ajaran ke yang sedang difilter user
        $this->tahun_akademik_id = $this->filterTahun;
        $this->status_penugasan = 'Tetap';

        $this->isEditing = false;
        $this->showModal = true;
    }

    public function openEditModal($id)
    {
        $data = PenugasanDosen::findOrFail($id);
        $this->penugasan_id = $data->id;
        $this->dosen_id = $data->dosen_id;
        $this->program_studi_id = $data->program_studi_id;
        $this->tahun_akademik_id = $data->tahun_akademik_id;
        $this->status_penugasan = $data->status_penugasan;

        $this->isEditing = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'dosen_id' => 'required',
            'program_studi_id' => 'required',
            'tahun_akademik_id' => 'required',
            'status_penugasan' => 'required',
        ]);

        // Cek Duplikat (1 Dosen tidak boleh 2x di Prodi sama pd Tahun sama)
        $exists = PenugasanDosen::where('dosen_id', $this->dosen_id)
            ->where('program_studi_id', $this->program_studi_id)
            ->where('tahun_akademik_id', $this->tahun_akademik_id)
            ->where('id', '!=', $this->penugasan_id) // Kecuali dirinya sendiri (saat edit)
            ->exists();

        if ($exists) {
            $this->addError('dosen_id', 'Dosen ini sudah ditugaskan di prodi tersebut pada tahun ajaran ini.');
            return;
        }

        PenugasanDosen::updateOrCreate(
            ['id' => $this->penugasan_id],
            [
                'dosen_id' => $this->dosen_id,
                'program_studi_id' => $this->program_studi_id,
                'tahun_akademik_id' => $this->tahun_akademik_id,
                'status_penugasan' => $this->status_penugasan,
            ]
        );

        $this->showModal = false;
        session()->flash('success', 'Penugasan berhasil disimpan.');
    }

    public function confirmDelete($id)
    {
        $this->deletingId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        PenugasanDosen::find($this->deletingId)->delete();
        $this->showDeleteModal = false;
        session()->flash('success', 'Data dihapus.');
    }
}
