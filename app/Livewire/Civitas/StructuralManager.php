<?php

namespace App\Livewire\Civitas;

use App\Models\StructuralAssignment;
use App\Models\StructuralPosition;
use App\Models\Dosen;
use App\Traits\WithToast;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.app')]
#[Title('Pejabat Struktural & Yayasan')]
class StructuralManager extends Component
{
    use WithPagination, WithFileUploads, WithToast;

    // Filter
    public $search = '';
    public $activeTab = 'Rektorat'; // Default tab

    // Form Properties
    public $assignment_id;
    public $structural_position_id;
    public $source_type = 'dosen'; // 'dosen' atau 'manual'

    // Jika Dosen
    public $dosen_id;

    // Jika Manual (Yayasan/Eksternal)
    public $name_custom;
    public $photo_custom;
    public $old_photo_custom;

    // Periode
    public $start_date;
    public $end_date;
    public $is_active = true;

    // UI States
    public $showModal = false;
    public $isEditing = false;
    public $showDeleteModal = false;
    public $deletingId = null;

    // Lists (Dropdown)
    public $positions = [];
    public $dosens = [];


    public $isCreatingPosition = false;
    public $new_position_name;
    public $new_position_order = 0;

    public function mount()
    {
        $this->dosens = Dosen::orderBy('nama_lengkap')->get();
        $this->refreshPositions();
    }

    public function refreshPositions()
    {
        // Ambil jabatan sesuai tab yang aktif
        $this->positions = StructuralPosition::where('group', $this->activeTab)
            ->orderBy('urutan')
            ->get();
    }

    public function updatedActiveTab()
    {
        $this->resetPage();
        $this->refreshPositions();
    }

    public function render()
    {
        // Ambil riwayat penugasan sesuai Tab (Group Jabatan)
        $assignments = StructuralAssignment::with(['position', 'dosen'])
            ->whereHas('position', function ($q) {
                $q->where('group', $this->activeTab);
            })
            ->when($this->search, function ($q) {
                $q->where(function ($sub) {
                    $sub->whereHas('dosen', fn($d) => $d->where('nama_lengkap', 'like', '%' . $this->search . '%'))
                        ->orWhere('name_custom', 'like', '%' . $this->search . '%');
                });
            })
            ->orderByDesc('is_active') // Yang aktif di atas
            ->orderBy('structural_position_id') // Urut berdasarkan hierarki jabatan
            ->orderByDesc('start_date')
            ->paginate(10);

        return view('livewire.civitas.structural-manager', [
            'assignments' => $assignments
        ]);
    }

    // --- CRUD ---

    public function create()
    {
        $this->reset(['assignment_id', 'structural_position_id', 'dosen_id', 'name_custom', 'photo_custom', 'old_photo_custom', 'end_date']);
        $this->start_date = date('Y-m-d');
        $this->source_type = 'dosen';
        $this->is_active = true;
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $this->resetValidation();
        $a = StructuralAssignment::findOrFail($id);

        $this->assignment_id = $a->id;
        $this->structural_position_id = $a->structural_position_id;
        $this->dosen_id = $a->dosen_id;
        $this->name_custom = $a->name_custom;
        $this->old_photo_custom = $a->photo_custom;

        $this->start_date = $a->start_date ? $a->start_date->format('Y-m-d') : null;
        $this->end_date = $a->end_date ? $a->end_date->format('Y-m-d') : null;
        $this->is_active = (bool) $a->is_active;

        // Deteksi tipe sumber
        $this->source_type = $a->dosen_id ? 'dosen' : 'manual';

        $this->isEditing = true;
        $this->showModal = true;
    }

    public function save()
    {
        // Validasi Dasar
        $rules = [
            'structural_position_id' => 'required|exists:structural_positions,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ];

        // Validasi Kondisional
        if ($this->source_type == 'dosen') {
            $rules['dosen_id'] = 'required|exists:dosens,id';
        } else {
            $rules['name_custom'] = 'required|string|max:255';
            $rules['photo_custom'] = 'nullable|image|max:2048';
        }

        $this->validate($rules);

        // LOGIC: Cek tumpang tindih jabatan aktif
        // Jika diset aktif, pastikan tidak ada orang lain yang sedang menjabat di posisi itu
        if ($this->is_active) {
            $conflict = StructuralAssignment::where('structural_position_id', $this->structural_position_id)
                ->where('is_active', true)
                ->where('id', '!=', $this->assignment_id)
                ->exists();

            if ($conflict) {
                // Opsi: Bisa auto-nonaktifkan yang lama, atau tolak.
                // Disini kita tolak biar admin sadar.
                $this->addError('is_active', 'Masih ada pejabat aktif di posisi ini. Harap non-aktifkan pejabat lama terlebih dahulu.');
                return;
            }
        }

        // Handle Foto Manual
        $photoPath = $this->old_photo_custom;
        if ($this->source_type == 'manual' && $this->photo_custom) {
            if ($this->old_photo_custom) Storage::disk('public')->delete($this->old_photo_custom);
            $photoPath = $this->photo_custom->store('pimpinan', 'public');
        }

        StructuralAssignment::updateOrCreate(
            ['id' => $this->assignment_id],
            [
                'structural_position_id' => $this->structural_position_id,
                'dosen_id' => $this->source_type == 'dosen' ? $this->dosen_id : null,
                'name_custom' => $this->source_type == 'manual' ? $this->name_custom : null,
                'photo_custom' => $this->source_type == 'manual' ? $photoPath : null,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date ?: null,
                'is_active' => $this->is_active,
            ]
        );

        $this->showModal = false;
        // Gunakan session flash atau dispatch notify sesuai sistem Bapak
        $this->alertSuccess('Data pejabat berhasil disimpan.');
    }

    public function confirmDelete($id)
    {
        $this->deletingId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        $a = StructuralAssignment::find($this->deletingId);
        if ($a) {
            if ($a->photo_custom) Storage::disk('public')->delete($a->photo_custom);
            $a->delete();
        }
        $this->showDeleteModal = false;
        $this->alertSuccess('Data dihapus.');
    }



    public function saveNewPosition()
    {
        $this->validate([
            'new_position_name' => 'required|string|max:255|unique:structural_positions,name',
            'new_position_order' => 'integer'
        ]);

        $pos = \App\Models\StructuralPosition::create([
            'name' => $this->new_position_name,
            'group' => $this->activeTab,
            'urutan' => $this->new_position_order
        ]);

        // Refresh list dan pilih jabatan baru
        $this->refreshPositions();
        $this->structural_position_id = $pos->id;

        // Reset UI
        $this->isCreatingPosition = false;
        $this->new_position_name = '';
       $this->alertSuccess('Jabatan baru berhasil dibuat!');
    }
}
