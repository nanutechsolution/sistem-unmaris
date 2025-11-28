<?php

namespace App\Livewire\Cms;

use App\Models\StudentOrganization;
use App\Traits\WithToast;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.app')]
#[Title('Manajemen UKM')]
class StudentOrganizationManager extends Component
{
    use WithPagination, WithFileUploads, WithToast;

    public $search = '';

    // Form Properties
    public $org_id;
    public $nama;
    public $kategori = 'Organisasi';
    public $deskripsi;
    public $logo, $old_logo;

    // Styling Options
    public $icon = 'fas fa-users'; // Default Icon
    public $warna = 'bg-blue-600'; // Default Color
    public $is_active = true;

    // UI States
    public $showModal = false;
    public $isEditing = false;
    public $showDeleteModal = false;
    public $deletingId = null;

    // Pilihan Warna untuk Dropdown (Mapping Nama -> Class Tailwind)
    public $colors = [
        'Biru' => 'bg-blue-600',
        'Hijau' => 'bg-green-600',
        'Merah' => 'bg-red-600',
        'Kuning' => 'bg-yellow-500',
        'Ungu' => 'bg-purple-600',
        'Indigo' => 'bg-indigo-600',
        'Cyan' => 'bg-cyan-600',
        'Teal' => 'bg-teal-600',
        'Pink' => 'bg-pink-600',
        'Orange' => 'bg-orange-500',
        'Hitam' => 'bg-gray-800',
    ];

    public function render()
    {
        $data = StudentOrganization::where('nama', 'like', '%' . $this->search . '%')
            ->orderBy('kategori')
            ->orderBy('nama')
            ->paginate(10);

        return view('livewire.cms.student-organization-manager', ['organizations' => $data]);
    }

    // --- CRUD ---

    public function create()
    {
        $this->reset(['org_id', 'nama', 'deskripsi', 'logo', 'old_logo']);
        $this->kategori = 'Organisasi';
        $this->icon = 'fas fa-users';
        $this->warna = 'bg-blue-600';
        $this->is_active = true;

        $this->isEditing = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $this->resetValidation();
        $org = StudentOrganization::findOrFail($id);

        $this->org_id = $org->id;
        $this->nama = $org->nama;
        $this->kategori = $org->kategori;
        $this->deskripsi = $org->deskripsi;
        $this->icon = $org->icon;
        $this->warna = $org->warna;
        $this->is_active = (bool) $org->is_active;
        $this->old_logo = $org->logo;

        $this->isEditing = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string',
            'deskripsi' => 'required|string',
            'icon' => 'required|string', // FontAwesome Class
            'warna' => 'required|string', // Tailwind Class
            'logo' => 'nullable|image|max:2048', // Max 2MB
        ]);

        // Handle Logo
        $path = $this->old_logo;
        if ($this->logo) {
            if ($this->old_logo) Storage::disk('public')->delete($this->old_logo);
            $path = $this->logo->store('ukm-logos', 'public');
        }

        StudentOrganization::updateOrCreate(
            ['id' => $this->org_id],
            [
                'nama' => $this->nama,
                'kategori' => $this->kategori,
                'deskripsi' => $this->deskripsi,
                'icon' => $this->icon,
                'warna' => $this->warna,
                'logo' => $path,
                'is_active' => $this->is_active,
            ]
        );

        $this->showModal = false;
        $this->alertSuccess('Data UKM berhasil disimpan.');
    }

    public function confirmDelete($id)
    {
        $this->deletingId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        $org = StudentOrganization::find($this->deletingId);
        if ($org) {
            if ($org->logo) Storage::disk('public')->delete($org->logo);
            $org->delete();
        }
        $this->showDeleteModal = false;
        $this->alertSuccess('Data UKM dihapus.');
    }
}
