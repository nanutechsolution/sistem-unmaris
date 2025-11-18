<?php

namespace App\Livewire\Manajemen;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Manajemen Kategori Berita')]
class CategoryManager extends Component
{
    use WithPagination;

    public $showModal = false;
    public $isEditing = false;
    public ?Category $editingCategory = null;

    // --- Form Properties ---
    public $name;
    public $slug;
    // ----------------------

    protected function rules()
    {
        return [
            'name' => [
                'required', 'string', 'max:255',
                $this->isEditing
                    ? Rule::unique('categories')->ignore($this->editingCategory->id)
                    : Rule::unique('categories')
            ],
            'slug' => [
                'required', 'string', 'max:255',
                $this->isEditing
                    ? Rule::unique('categories')->ignore($this->editingCategory->id)
                    : Rule::unique('categories')
            ],
        ];
    }

    // Dipanggil setiap 'name' berubah
    public function updatedName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function resetForm()
    {
        $this->reset(['name', 'slug', 'isEditing', 'editingCategory']);
        $this->resetErrorBag();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function openEditModal(Category $category)
    {
        $this->resetForm();
        $this->isEditing = true;
        $this->editingCategory = $category;

        $this->name = $category->name;
        $this->slug = $category->slug;

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function save()
    {
        $validatedData = $this->validate();
        // Pastikan slug juga di-generate jika diubah manual
        $validatedData['slug'] = Str::slug($this->slug);

        if ($this->isEditing) {
            $this->editingCategory->update($validatedData);
        } else {
            Category::create($validatedData);
        }

        $this->closeModal();
        $this->resetPage();
    }

    // --- Logika Hapus ---
    public $showDeleteModal = false;
    public ?Category $deletingCategory = null;

    public function openDeleteModal(Category $category)
    {
        $this->deletingCategory = $category;
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->deletingCategory = null;
    }

    public function delete()
    {
        if ($this->deletingCategory) {
            // Kita bisa tambahkan cek jika kategori ini dipakai oleh post
            // $postCount = $this->deletingCategory->posts()->count();
            // if ($postCount > 0) {
            //     session()->flash('error', 'Kategori tidak bisa dihapus karena masih digunakan.');
            //     $this->closeDeleteModal();
            //     return;
            // }

            $this->deletingCategory->delete();
            $this->closeDeleteModal();
            $this->resetPage();
        }
    }
    // --- Akhir Logika Hapus ---

    public function render()
    {
        $categories = Category::withCount('posts')->orderBy('name', 'asc')->paginate(10);

        return view('livewire.manajemen.category-manager', [
            'categories' => $categories,
        ]);
    }
}
