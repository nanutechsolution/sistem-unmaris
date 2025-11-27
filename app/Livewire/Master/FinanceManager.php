<?php

namespace App\Livewire\Master;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\FinanceComponent;
use App\Models\FinanceRate;
use App\Models\ProgramStudi;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Manajemen Biaya Kuliah')]
class FinanceManager extends Component
{
    use WithPagination;

    public $activeTab = 'rates'; // Default buka tab Tarif (karena lebih sering dipakai)
    public $search = '';
    
    // --- Filter Tarif ---
    public $filterProdi = '';
    public $filterAngkatan = '';

    // --- Modal State ---
    public $showModalComponent = false;
    public $showModalRate = false;
    public $isEditing = false;
    public $deleteId = null;
    public $deleteType = ''; // 'component' atau 'rate'

    // --- Form Komponen ---
    public $comp_id, $comp_nama, $comp_tipe = 'Per Semester', $comp_wajib = true;

    // --- Form Tarif ---
    public $rate_id, $rate_comp_id, $rate_prodi_id, $rate_angkatan, $rate_nominal;

    // --- Data Lists ---
    public $listProdi;
    public $listKomponen;

    public function mount()
    {
        $this->listProdi = ProgramStudi::orderBy('nama_prodi')->get();
        $this->listKomponen = FinanceComponent::all();
        $this->filterAngkatan = date('Y'); // Default tahun ini
    }

    public function render()
    {
        $dataComponents = [];
        $dataRates = [];

        if ($this->activeTab == 'components') {
            $dataComponents = FinanceComponent::where('nama', 'like', '%'.$this->search.'%')
                ->paginate(10);
        } else {
            $dataRates = FinanceRate::with(['component', 'prodi'])
                ->when($this->filterProdi, fn($q) => $q->where('program_studi_id', $this->filterProdi))
                ->when($this->filterAngkatan, fn($q) => $q->where('angkatan', $this->filterAngkatan))
                ->when($this->search, fn($q) => $q->whereHas('component', fn($sub) => $sub->where('nama', 'like', '%'.$this->search.'%')))
                ->orderBy('program_studi_id')
                ->paginate(10);
        }

        return view('livewire.master.finance-manager', [
            'components' => $dataComponents,
            'rates' => $dataRates
        ]);
    }

    // === LOGIC KOMPONEN ===

    public function createComponent()
    {
        $this->reset(['comp_id', 'comp_nama', 'comp_tipe', 'comp_wajib']);
        $this->isEditing = false;
        $this->showModalComponent = true;
    }

    public function saveComponent()
    {
        $this->validate([
            'comp_nama' => 'required|string|max:255',
            'comp_tipe' => 'required',
        ]);

        FinanceComponent::updateOrCreate(
            ['id' => $this->comp_id],
            [
                'nama' => $this->comp_nama,
                'tipe' => $this->comp_tipe,
                'is_wajib' => $this->comp_wajib
            ]
        );

        $this->showModalComponent = false;
        $this->listKomponen = FinanceComponent::all(); // Refresh list dropdown
        session()->flash('success', 'Komponen biaya berhasil disimpan.');
    }

    public function editComponent($id)
    {
        $c = FinanceComponent::findOrFail($id);
        $this->comp_id = $c->id;
        $this->comp_nama = $c->nama;
        $this->comp_tipe = $c->tipe;
        $this->comp_wajib = (bool) $c->is_wajib;
        $this->isEditing = true;
        $this->showModalComponent = true;
    }

    // === LOGIC TARIF ===

    public function createRate()
    {
        $this->reset(['rate_id', 'rate_comp_id', 'rate_prodi_id', 'rate_nominal']);
        $this->rate_angkatan = $this->filterAngkatan ?: date('Y'); // Auto isi tahun
        $this->isEditing = false;
        $this->showModalRate = true;
    }

    public function saveRate()
    {
        $this->validate([
            'rate_comp_id' => 'required|exists:finance_components,id',
            'rate_angkatan' => 'required|numeric|digits:4',
            'rate_nominal' => 'required|numeric|min:0',
        ]);

        // Cek Duplikat (1 Prodi, 1 Angkatan, 1 Komponen hanya boleh 1 harga)
        if (!$this->isEditing) {
            $exists = FinanceRate::where('finance_component_id', $this->rate_comp_id)
                ->where('program_studi_id', $this->rate_prodi_id) // Bisa null (Umum)
                ->where('angkatan', $this->rate_angkatan)
                ->exists();
            
            if ($exists) {
                $this->addError('rate_comp_id', 'Tarif untuk komponen ini pada prodi & angkatan tersebut sudah ada.');
                return;
            }
        }

        FinanceRate::updateOrCreate(
            ['id' => $this->rate_id],
            [
                'finance_component_id' => $this->rate_comp_id,
                'program_studi_id' => $this->rate_prodi_id ?: null, // Jika kosong simpan null (Berlaku Umum)
                'angkatan' => $this->rate_angkatan,
                'nominal' => $this->rate_nominal,
            ]
        );

        $this->showModalRate = false;
        session()->flash('success', 'Tarif biaya berhasil disimpan.');
    }

    public function editRate($id)
    {
        $r = FinanceRate::findOrFail($id);
        $this->rate_id = $r->id;
        $this->rate_comp_id = $r->finance_component_id;
        $this->rate_prodi_id = $r->program_studi_id;
        $this->rate_angkatan = $r->angkatan;
        $this->rate_nominal = $r->nominal;
        $this->isEditing = true;
        $this->showModalRate = true;
    }

    // === DELETE GENERAL ===
    public function confirmDelete($type, $id)
    {
        $this->deleteType = $type;
        $this->deleteId = $id;
        // Bisa tambahkan modal konfirmasi terpisah jika mau, atau langsung delete (kasar)
        // Disini saya langsung eksekusi demi ringkas, di view bisa pakai onlclick confirm
        $this->delete();
    }

    public function delete()
    {
        if ($this->deleteType == 'component') {
            FinanceComponent::find($this->deleteId)->delete();
        } else {
            FinanceRate::find($this->deleteId)->delete();
        }
        session()->flash('success', 'Data dihapus.');
    }
}