<?php

namespace App\Livewire\Akademik;

use App\Models\FakultasDekan;
use App\Models\Fakultas;
use App\Models\Dosen;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Riwayat Dekan')]
class DekanManager extends Component
{
    use WithPagination;

    // Filter
    public $search = '';
    public $filterFakultas = '';

    // Form
    public $dekan_id;
    public $fakultas_id;
    public $dosen_id;
    public $mulai;
    public $selesai;

    // UI States
    public $showModal = false;
    public $isEditing = false;
    public $showDeleteModal = false;
    public $deletingId = null;

    // Lists
    public $listFakultas = [];
    public $listDosen = [];

    public function mount()
    {
        $this->listFakultas = Fakultas::orderBy('nama_fakultas')->get();
        $this->listDosen = Dosen::orderBy('nama_lengkap')->get();
    }

    public function render()
    {
        $data = FakultasDekan::with(['fakultas', 'dosen'])
            ->when($this->filterFakultas, function($q) {
                $q->where('fakultas_id', $this->filterFakultas);
            })
            ->when($this->search, function($q) {
                $q->whereHas('dosen', function($sub) {
                    $sub->where('nama_lengkap', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy('fakultas_id')
            ->orderByDesc('mulai')
            ->paginate(10);

        return view('livewire.akademik.dekan-manager', [
            'history' => $data
        ]);
    }

    // --- CRUD LOGIC ---

    public function create()
    {
        $this->reset(['dekan_id', 'fakultas_id', 'dosen_id', 'mulai', 'selesai']);
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $d = FakultasDekan::findOrFail($id);
        $this->dekan_id = $d->id;
        $this->fakultas_id = $d->fakultas_id;
        $this->dosen_id = $d->dosen_id;
        $this->mulai = $d->mulai ? $d->mulai->format('Y-m-d') : null;
        $this->selesai = $d->selesai ? $d->selesai->format('Y-m-d') : null;

        $this->isEditing = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'fakultas_id' => 'required|exists:fakultas,id',
            'dosen_id' => 'required|exists:dosens,id',
            'mulai' => 'required|date',
            'selesai' => 'nullable|date|after_or_equal:mulai',
        ]);

        // VALIDASI: Jangan sampai ada 2 Dekan Aktif di 1 Fakultas
        if (empty($this->selesai)) {
            $existingAktif = FakultasDekan::where('fakultas_id', $this->fakultas_id)
                ->whereNull('selesai')
                ->where('id', '!=', $this->dekan_id)
                ->exists();

            if ($existingAktif) {
                $this->addError('selesai', 'Fakultas ini masih memiliki Dekan Aktif. Harap set tanggal selesai pejabat lama dulu.');
                return;
            }
        }

        FakultasDekan::updateOrCreate(
            ['id' => $this->dekan_id],
            [
                'fakultas_id' => $this->fakultas_id,
                'dosen_id' => $this->dosen_id,
                'mulai' => $this->mulai,
                'selesai' => $this->selesai ?: null,
            ]
        );

        $this->showModal = false;
        session()->flash('success', 'Data Dekan berhasil disimpan.');
    }

    public function confirmDelete($id)
    {
        $this->deletingId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        FakultasDekan::find($this->deletingId)->delete();
        $this->showDeleteModal = false;
        session()->flash('success', 'Data dihapus.');
    }
}