<?php

namespace App\Livewire\Admin;

use App\Models\ProgramStudiKaprodi;
use App\Models\ProgramStudi;
use App\Models\Dosen;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Riwayat Kaprodi')]
class KaprodiManager extends Component
{
    use WithPagination;

    // Filter
    public $search = '';
    public $filterProdi = '';

    // Form
    public $kaprodi_id;
    public $program_studi_id;
    public $dosen_id;
    public $mulai;
    public $selesai;

    // UI States
    public $showModal = false;
    public $isEditing = false;
    public $showDeleteModal = false;
    public $deletingId = null;

    // Data Lists
    public $listProdi = [];
    public $listDosen = [];

    public function mount()
    {
        $this->listProdi = ProgramStudi::orderBy('nama_prodi')->get();
        $this->listDosen = Dosen::orderBy('nama_lengkap')->get();
    }

    public function render()
    {
        $data = ProgramStudiKaprodi::with(['programStudi', 'dosen'])
            ->when($this->filterProdi, function($q) {
                $q->where('program_studi_id', $this->filterProdi);
            })
            ->when($this->search, function($q) {
                $q->whereHas('dosen', function($sub) {
                    $sub->where('nama_lengkap', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy('program_studi_id')
            ->orderByDesc('mulai') // Yang terbaru di atas
            ->paginate(10);

        return view('livewire.admin.kaprodi-manager', [
            'history' => $data
        ]);
    }

    // --- CRUD LOGIC ---

    public function create()
    {
        $this->reset(['kaprodi_id', 'program_studi_id', 'dosen_id', 'mulai', 'selesai']);
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $k = ProgramStudiKaprodi::findOrFail($id);
        $this->kaprodi_id = $k->id;
        $this->program_studi_id = $k->program_studi_id;
        $this->dosen_id = $k->dosen_id;
        $this->mulai = $k->mulai ? $k->mulai->format('Y-m-d') : null;
        $this->selesai = $k->selesai ? $k->selesai->format('Y-m-d') : null;

        $this->isEditing = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'program_studi_id' => 'required|exists:program_studis,id',
            'dosen_id' => 'required|exists:dosens,id',
            'mulai' => 'required|date',
            'selesai' => 'nullable|date|after_or_equal:mulai',
        ]);

        // VALIDASI LOGIC: Tidak boleh ada 2 Kaprodi Aktif di Prodi yang sama
        if (empty($this->selesai)) {
            $existingAktif = ProgramStudiKaprodi::where('program_studi_id', $this->program_studi_id)
                ->whereNull('selesai')
                ->where('id', '!=', $this->kaprodi_id) // Kecuali dirinya sendiri
                ->exists();

            if ($existingAktif) {
                $this->addError('selesai', 'Prodi ini masih memiliki Kaprodi Aktif. Harap set tanggal selesai untuk pejabat lama terlebih dahulu.');
                return;
            }
        }

        ProgramStudiKaprodi::updateOrCreate(
            ['id' => $this->kaprodi_id],
            [
                'program_studi_id' => $this->program_studi_id,
                'dosen_id' => $this->dosen_id,
                'mulai' => $this->mulai,
                'selesai' => $this->selesai ?: null, // Pastikan null jika string kosong
            ]
        );

        $this->showModal = false;
        session()->flash('success', 'Data Kaprodi berhasil disimpan.');
    }

    public function confirmDelete($id)
    {
        $this->deletingId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        ProgramStudiKaprodi::find($this->deletingId)->delete();
        $this->showDeleteModal = false;
        session()->flash('success', 'Data dihapus.');
    }
}