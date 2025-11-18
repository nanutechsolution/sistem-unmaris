<?php
namespace App\Livewire\Manajemen;

use App\Models\Post;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Manajemen Berita')]
class PostManager extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $showModal = false;
    public $isEditing = false;
    public ?Post $editingPost = null;

    // --- Form Properties ---
    public $title;
    public $slug;
    public $category_id;
    public $status = 'Published';
    public $published_at;
    public $featured_image;
    public $existing_featured_image;
    public $content; // <- content kembali normal
    // ------------------------

    public $categories = [];

    public $showDeleteModal = false;
    public ?Post $deletingPost = null;

    public function openDeleteModal(Post $post)
    {
        $this->deletingPost = $post;
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->deletingPost = null;
    }

    public function delete()
    {
        if ($this->deletingPost) {
            if ($this->deletingPost->featured_image) {
                Storage::disk('public')->delete($this->deletingPost->featured_image);
            }

            $this->deletingPost->delete();
            $this->closeDeleteModal();
            $this->resetPage();
        }
    }

    protected function rules()
    {
        return [
            'title'          => 'required|string|max:255',
            'category_id'    => 'required|exists:categories,id',
            'status'         => 'required|in:Published,Draft',
            'featured_image' => 'nullable|image|max:2048',
            'content'        => 'required|string',
        ];
    }

    public function mount()
    {
        $this->categories = Category::orderBy('name')->get();
        $this->published_at = now()->format('Y-m-d');
    }

    public function updatedTitle($value)
    {
        $this->slug = Str::slug($value);
    }

    public function resetForm()
    {
        $this->reset([
            'title',
            'slug',
            'category_id',
            'status',
            'featured_image',
            'existing_featured_image',
            'isEditing',
            'editingPost',
            'content',
        ]);

        $this->published_at = now()->format('Y-m-d');
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function openEditModal(Post $post)
    {
        $this->resetForm();
        $this->isEditing = true;
        $this->editingPost = $post;

        $this->title       = $post->title;
        $this->slug        = $post->slug;
        $this->category_id = $post->category_id;
        $this->status      = $post->status;
        $this->published_at = $post->published_at
            ? $post->published_at->format('Y-m-d')
            : now()->format('Y-m-d');

        $this->existing_featured_image = $post->featured_image;
        $this->content = $post->content;

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function save()
    {
        $validatedData = $this->validate();

        $validatedData['slug']         = Str::slug($this->title);
        $validatedData['user_id']      = Auth::id();
        $validatedData['published_at'] = $this->published_at;

        // Handle Featured Image
        if ($this->featured_image) {
            if ($this->isEditing && $this->editingPost->featured_image) {
                Storage::disk('public')->delete($this->editingPost->featured_image);
            }
            $validatedData['featured_image'] =
                $this->featured_image->store('post-images', 'public');
        }

        if ($this->isEditing) {
            $this->editingPost->update($validatedData);
        } else {
            Post::create($validatedData);
        }

        $this->closeModal();
        $this->resetPage();
    }

    public function render()
    {
        $posts = Post::with('category', 'author')
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        return view('livewire.manajemen.post-manager', [
            'posts' => $posts
        ]);
    }
}
