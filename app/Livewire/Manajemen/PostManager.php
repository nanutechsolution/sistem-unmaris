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
    public $content; 
    // ------------------------

    public $categories = [];

    public $showDeleteModal = false;
    public ?Post $deletingPost = null;

    // --- PESAN VALIDASI BAHASA INDONESIA ---
    protected $messages = [
        'title.required' => 'Judul berita wajib diisi.',
        'title.max' => 'Judul berita terlalu panjang (maksimal 255 karakter).',
        'category_id.required' => 'Mohon pilih kategori berita.',
        'category_id.exists' => 'Kategori yang dipilih tidak valid.',
        'status.required' => 'Status publikasi wajib dipilih.',
        'published_at.required' => 'Tanggal terbit wajib diisi.',
        'published_at.date' => 'Format tanggal tidak valid.',
        'featured_image.image' => 'File harus berupa gambar (JPG, PNG, JPEG).',
        'featured_image.max' => 'Ukuran gambar terlalu besar. Maksimal 2MB.',
        'content.required' => 'Isi konten berita tidak boleh kosong.',
    ];

    protected function rules()
    {
        return [
            'title'          => 'required|string|max:255',
            'category_id'    => 'required|exists:categories,id',
            'status'         => 'required|in:Published,Draft',
            'published_at'   => 'required|date', // [TAMBAHAN] Validasi tanggal
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
        // [PERBAIKAN] Hanya generate slug otomatis saat CREATE (bukan Edit)
        // Agar link lama tidak rusak jika judul diedit sedikit
        if (!$this->isEditing) {
            $this->slug = Str::slug($value);
        }
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
        $this->resetErrorBag(); // Bersihkan pesan error saat reset
    }

    // ... (Sisa fungsi openCreateModal, openEditModal, dll TETAP SAMA) ...

    public function openCreateModal()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
        
        // Kirim sinyal ke View untuk mengosongkan Trix Editor
        $this->dispatch('refresh-trix', content: '');
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

        // Kirim sinyal ke View untuk mengisi Trix Editor dengan konten database
        $this->dispatch('refresh-trix', content: $this->content);
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function save()
    {
        // Gunakan $this->messages secara otomatis
        $validatedData = $this->validate();

        // Slug hanya di-set jika belum ada atau user mengubahnya manual
        // Tapi di sini kita pastikan slug terisi (fallback ke title jika kosong)
        if (empty($this->slug)) {
             $this->slug = Str::slug($this->title);
        }
        $validatedData['slug'] = $this->slug;
        
        $validatedData['user_id']      = Auth::id();
        // published_at sudah masuk $validatedData karena sudah ada di rules()

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
        session()->flash('success', 'Berita berhasil disimpan.'); // [OPSIONAL] Flash message
    }

    // ... (Fungsi render, delete, dll TETAP SAMA) ...
    
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