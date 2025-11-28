<?php

namespace App\Livewire\Cms;

use App\Models\Achievement;
use App\Traits\WithToast;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.app')]
#[Title('Manajemen Prestasi')]
class AchievementManager extends Component
{
    use WithPagination, WithFileUploads, WithToast;

    public $search = '';
    public $filterCategory = '';

    // Form Properties
    public $achievement_id;
    public $title, $event_name, $winner_name, $prodi_name;
    public $level = 'Nasional';
    public $category = 'Akademik';
    public $medal = 'Gold';
    public $description;
    public $date;
    public $is_featured = false;

    // Uploads
    public $image, $old_image;

    // UI States
    public $showModal = false;
    public $isEditing = false;
    public $showDeleteModal = false;
    public $deletingId = null;

    public function render()
    {
        $data = Achievement::query()
            ->when($this->search, function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('winner_name', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterCategory, function ($q) {
                $q->where('category', $this->filterCategory);
            })
            ->orderByDesc('date')
            ->paginate(10);

        return view('livewire.cms.achievement-manager', ['achievements' => $data]);
    }

    // --- CRUD ---

    public function create()
    {
        $this->reset();
        $this->date = date('Y-m-d'); // Default hari ini
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $this->resetValidation();
        $item = Achievement::findOrFail($id);

        $this->achievement_id = $item->id;
        $this->title = $item->title;
        $this->event_name = $item->event_name;
        $this->winner_name = $item->winner_name;
        $this->prodi_name = $item->prodi_name;
        $this->level = $item->level;
        $this->category = $item->category;
        $this->medal = $item->medal;
        $this->description = $item->description;
        $this->date = $item->date->format('Y-m-d');
        $this->is_featured = (bool) $item->is_featured;
        $this->old_image = $item->image_path;

        $this->isEditing = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'event_name' => 'required|string|max:255',
            'winner_name' => 'required|string|max:255',
            'level' => 'required',
            'category' => 'required',
            'medal' => 'required',
            'date' => 'required|date',
            'image' => $this->isEditing ? 'nullable|image|max:2048' : 'required|image|max:2048',
        ]);

        // Handle Image
        $path = $this->old_image;
        if ($this->image) {
            if ($this->old_image) Storage::disk('public')->delete($this->old_image);
            $path = $this->image->store('achievements', 'public');
        }

        Achievement::updateOrCreate(
            ['id' => $this->achievement_id],
            [
                'title' => $this->title,
                'event_name' => $this->event_name,
                'winner_name' => $this->winner_name,
                'prodi_name' => $this->prodi_name,
                'level' => $this->level,
                'category' => $this->category,
                'medal' => $this->medal,
                'description' => $this->description,
                'date' => $this->date,
                'is_featured' => $this->is_featured ? 1 : 0,
                'image_path' => $path,
            ]
        );

        $this->showModal = false;
        $this->alertSuccess('Data prestasi berhasil disimpan.');
    }

    // --- DELETE ---

    public function confirmDelete($id)
    {
        $this->deletingId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        $item = Achievement::find($this->deletingId);
        if ($item) {
            if ($item->image_path) Storage::disk('public')->delete($item->image_path);
            $item->delete();
        }
        $this->showDeleteModal = false;
        $this->alertSuccess('Data dihapus.');
    }
}
