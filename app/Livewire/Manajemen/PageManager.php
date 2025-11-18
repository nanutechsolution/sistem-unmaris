<?php

namespace App\Livewire\Manajemen;

use App\Models\Page;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

#[Layout('layouts.app')]
#[Title('Manajemen Halaman')]
class PageManager extends Component
{
    use WithPagination;

    public $showModal = false;
    public $isEditing = false;
    public ?Page $editingPage = null;

    // --- Form Properties ---
    public $title;
    public $slug;
    public $content;
    public $status = 'Published';
    // ----------------------

    protected function rules()
    {
        return [
            'title' => [
                'required', 'string', 'max:255',
                $this->isEditing
                    ? Rule::unique('pages')->ignore($this->editingPage->id)
                    : Rule::unique('pages')
            ],
            'content' => 'required|string',
            'status' => 'required|in:Published,Draft',
        ];
    }

    // Fungsi ini dipanggil setiap 'title' berubah
    public function updatedTitle($value)
    {
        // Otomatis buat slug dari title
        $this->slug = Str::slug($value);
    }

    public function resetForm()
    {
        $this->reset(['title', 'slug', 'content', 'status', 'isEditing', 'editingPage']);
        $this->status = 'Published';
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function openEditModal(Page $page)
    {
        $this->resetForm();
        $this->isEditing = true;
        $this->editingPage = $page;

        $this->title = $page->title;
        $this->slug = $page->slug;
        $this->content = $page->content;
        $this->status = $page->status;

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function save()
    {
        $validatedData = $this->validate();
        // Tambahkan slug ke data yang divalidasi
        $validatedData['slug'] = Str::slug($this->title);

        if ($this->isEditing) {
            $this->editingPage->update($validatedData);
        } else {
            Page::create($validatedData);
        }

        $this->closeModal();
        $this->resetPage();
    }

    // Tidak ada 'delete' untuk halaman, kita arsipkan saja (set ke Draft)
    public function archive(Page $page)
    {
        $page->update(['status' => 'Draft']);
    }

    public function render()
    {
        $pages = Page::orderBy('title', 'asc')->paginate(10);
        return view('livewire.manajemen.page-manager', [
            'pages' => $pages,
        ]);
    }
}
