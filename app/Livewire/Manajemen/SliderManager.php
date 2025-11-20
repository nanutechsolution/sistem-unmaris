<?php

namespace App\Livewire\Manajemen;

use App\Models\Slider;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Manajemen Banner Depan')]
class SliderManager extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $isEditing = false;
    public ?Slider $editingSlider = null;

    public $title;
    public $description;
    public $image; // File upload
    public $existing_image;
    public $button_text;
    public $button_url;
    public $order = 0;
    public $active = true;

    protected function rules()
    {
        return [
            'image' => $this->isEditing ? 'nullable|image|max:2048' : 'required|image|max:2048',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:500',
            'button_text' => 'nullable|string|max:50',
            'button_url' => 'nullable|url|max:255',
            'order' => 'required|integer',
            'active' => 'boolean',
        ];
    }

    public function resetForm()
    {
        $this->reset(['title', 'description', 'image', 'existing_image', 'button_text', 'button_url', 'order', 'active', 'isEditing', 'editingSlider']);
        $this->order = 0;
        $this->active = true;
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function openEditModal(Slider $slider)
    {
        $this->resetForm();
        $this->isEditing = true;
        $this->editingSlider = $slider;

        $this->title = $slider->title;
        $this->description = $slider->description;
        $this->existing_image = $slider->image_path;
        $this->button_text = $slider->button_text;
        $this->button_url = $slider->button_url;
        $this->order = $slider->order;
        $this->active = $slider->active;

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function save()
    {
        $validatedData = $this->validate();

        // Handle Image
        if ($this->image) {
            if ($this->isEditing && $this->editingSlider->image_path) {
                Storage::disk('public')->delete($this->editingSlider->image_path);
            }
            $validatedData['image_path'] = $this->image->store('sliders', 'public');
        } else {
             // Jika edit tapi tidak upload gambar baru, hapus key image_path dari array agar tidak null
             unset($validatedData['image']); 
        }

        if ($this->isEditing) {
            $this->editingSlider->update($validatedData);
        } else {
            Slider::create($validatedData);
        }

        $this->closeModal();
    }

    public function delete(Slider $slider)
    {
        if ($slider->image_path) {
            Storage::disk('public')->delete($slider->image_path);
        }
        $slider->delete();
    }

    public function render()
    {
        return view('livewire.manajemen.slider-manager', [
            'sliders' => Slider::orderBy('order', 'asc')->get()
        ]);
    }
}