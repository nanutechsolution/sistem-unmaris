<?php

namespace App\Livewire\Master;

use App\Models\Facility;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.app')]
#[Title('Manajemen Fasilitas')]
class FacilityManager extends Component
{
    use WithFileUploads;

    public $search = '';
    public $facilities;
    
    // Form
    public $fac_id, $name, $description, $category = 'Gedung', $order = 0, $is_active = true;
    public $image, $old_image;

    public $showModal = false;
    public $isEditing = false;
    public $showDeleteModal = false;
    public $deletingId = null;

    protected $rules = [
        'name' => 'required|string|max:255',
        'category' => 'required|in:Laboratorium,Gedung,Olahraga,Penunjang,Lainnya',
        'description' => 'nullable|string',
        'order' => 'integer',
        'image' => 'nullable|image|max:2048', // 2MB Max
    ];

    public function render()
    {
        $this->facilities = Facility::where('name', 'like', '%'.$this->search.'%')
            ->orderBy('category')
            ->orderBy('order')
            ->get();

        return view('livewire.master.facility-manager');
    }

    public function create()
    {
        $this->reset();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $this->reset();
        $f = Facility::findOrFail($id);
        $this->fac_id = $f->id;
        $this->name = $f->name;
        $this->description = $f->description;
        $this->category = $f->category;
        $this->order = $f->order;
        $this->is_active = (bool) $f->is_active;
        $this->old_image = $f->image_path;
        
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function save()
    {
        // Validasi Gambar: Wajib saat Create, Optional saat Edit
        $imageRule = $this->isEditing ? 'nullable|image|max:2048' : 'required|image|max:2048';
        $this->validate(['image' => $imageRule]);
        $this->validate();

        $path = $this->old_image;
        if ($this->image) {
            if ($this->old_image) Storage::disk('public')->delete($this->old_image);
            $path = $this->image->store('facilities', 'public');
        }

        Facility::updateOrCreate(
            ['id' => $this->fac_id],
            [
                'name' => $this->name,
                'slug' => Str::slug($this->name),
                'description' => $this->description,
                'category' => $this->category,
                'image_path' => $path,
                'order' => $this->order,
                'is_active' => $this->is_active,
            ]
        );

        $this->showModal = false;
        session()->flash('success', 'Fasilitas berhasil disimpan.');
    }

    public function confirmDelete($id)
    {
        $this->deletingId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        $f = Facility::find($this->deletingId);
        if ($f) {
            if ($f->image_path) Storage::disk('public')->delete($f->image_path);
            $f->delete();
        }
        $this->showDeleteModal = false;
        session()->flash('success', 'Fasilitas dihapus.');
    }
}