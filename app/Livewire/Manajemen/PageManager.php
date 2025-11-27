<?php

namespace App\Livewire\Manajemen;

use App\Models\Page; // Pastikan model Page sudah ada
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Str;

#[Layout('layouts.app')]
#[Title('Manajemen Halaman Statis')]
class PageManager extends Component
{
    use WithPagination;

    // Properties
    public $page_id;
    public $title;
    public $slug;
    public $content;
    public $status = 'Published';

    // UI State
    public $showModal = false;
    public $isEditing = false;
    public $search = '';

    protected $rules = [
        'title' => 'required|string|max:255',
        'slug' => 'required|string|max:255', // Validasi unique ditangani di save
        'content' => 'required|string',
        'status' => 'required|in:Published,Draft',
    ];

    public function render()
    {
        $pages = Page::where('title', 'like', '%'.$this->search.'%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.manajemen.page-manager', [
            'pages' => $pages
        ]);
    }

    // --- Auto Generate Slug ---
    public function updatedTitle($value)
    {
        if (!$this->isEditing) { 
            $this->slug = Str::slug($value);
        }
    }

    // --- CRUD ---

    public function openCreateModal()
    {
        $this->reset();
        $this->isEditing = false;
        $this->showModal = true;
        
        // PENTING: Kirim sinyal kosongkan editor
        $this->dispatch('refresh-trix', content: ''); 
    }

    public function openEditModal($id)
    {
        $p = Page::findOrFail($id);
        $this->page_id = $p->id;
        $this->title = $p->title;
        $this->slug = $p->slug;
        $this->content = $p->content;
        $this->status = $p->status;

        $this->isEditing = true;
        $this->showModal = true;

        // PENTING: Kirim sinyal isi editor dengan konten lama
        $this->dispatch('refresh-trix', content: $this->content);
    }

    public function save()
    {
        $this->validate();

        Page::updateOrCreate(
            ['id' => $this->page_id],
            [
                'title' => $this->title,
                'slug' => Str::slug($this->slug),
                'content' => $this->content,
                'status' => $this->status,
            ]
        );

        $this->showModal = false;
        session()->flash('success', 'Halaman berhasil disimpan.');
    }

    public function closeModal()
    {
        $this->showModal = false;
    }
}