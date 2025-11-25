<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads; // Wajib untuk upload file
use App\Models\Pengumuman;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Manajemen Pengumuman')]
class PengumumanManager extends Component
{
    use WithPagination;
    use WithFileUploads;

    // Filter & Search
    public $search = '';
    
    // Form Properties
    public $pengumuman_id;
    public $judul, $slug, $konten, $ringkasan;
    public $kategori = 'Umum';
    public $status = 'Published';
    public $is_pinned = false;
    public $published_at;
    
    // File Uploads
    public $thumbnail; // File baru
    public $old_thumbnail; // Path lama
    public $file_lampiran; // File baru
    public $old_file_lampiran; // Path lama

    // Modal State
    public $showModal = false;
    public $isEditing = false;
    public $showDeleteModal = false;
    public $deleteId;

    // Rules Validasi
    protected $rules = [
        'judul' => 'required|min:5',
        'kategori' => 'required',
        'konten' => 'required',
        'status' => 'required',
        'thumbnail' => 'nullable|image|max:2048', // Max 2MB
        'file_lampiran' => 'nullable|mimes:pdf,doc,docx|max:5120', // Max 5MB
    ];

    public function render()
    {
        $data = Pengumuman::latest()
            ->where('judul', 'like', '%'.$this->search.'%')
            ->paginate(10);

        return view('livewire.admin.pengumuman-manager', [
            'pengumumans' => $data
        ]);
    }

    // --- LOGIC CRUD ---

    public function create()
    {
        $this->reset(); // Kosongkan form
        $this->published_at = now()->format('Y-m-d\TH:i'); // Default jam sekarang
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $this->reset();
        $p = Pengumuman::findOrFail($id);
        
        $this->pengumuman_id = $p->id;
        $this->judul = $p->judul;
        $this->slug = $p->slug;
        $this->kategori = $p->kategori;
        $this->konten = $p->konten;
        $this->ringkasan = $p->ringkasan;
        $this->status = $p->status;
        $this->is_pinned = $p->is_pinned;
        // Format datetime untuk input HTML5
        $this->published_at = $p->published_at ? $p->published_at->format('Y-m-d\TH:i') : null;
        
        $this->old_thumbnail = $p->thumbnail;
        $this->old_file_lampiran = $p->file_lampiran;

        $this->isEditing = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        // 1. Generate Slug Otomatis dari Judul
        $slug = Str::slug($this->judul);
        
        // Cek duplikat slug (tambah angka random jika kembar)
        if (Pengumuman::where('slug', $slug)->where('id', '!=', $this->pengumuman_id)->exists()) {
            $slug .= '-' . Str::random(5);
        }

        // 2. Handle Upload Thumbnail
        $thumbnailPath = $this->old_thumbnail;
        if ($this->thumbnail) {
            // Hapus file lama jika ada
            if($this->old_thumbnail) Storage::disk('public')->delete($this->old_thumbnail);
            // Simpan baru
            $thumbnailPath = $this->thumbnail->store('pengumuman/thumbs', 'public');
        }

        // 3. Handle Upload Lampiran
        $filePath = $this->old_file_lampiran;
        if ($this->file_lampiran) {
            if($this->old_file_lampiran) Storage::disk('public')->delete($this->old_file_lampiran);
            $filePath = $this->file_lampiran->store('pengumuman/files', 'public');
        }

        // 4. Simpan ke Database
        Pengumuman::updateOrCreate(
            ['id' => $this->pengumuman_id],
            [
                'judul' => $this->judul,
                'slug' => $slug,
                'kategori' => $this->kategori,
                'konten' => $this->konten,
                // Buat ringkasan otomatis dari konten jika kosong
                'ringkasan' => $this->ringkasan ?? Str::limit(strip_tags($this->konten), 150),
                'status' => $this->status,
                'is_pinned' => $this->is_pinned ? true : false,
                'published_at' => $this->published_at,
                'thumbnail' => $thumbnailPath,
                'file_lampiran' => $filePath,
                'penulis' => auth()->user()->name ?? 'Admin UNMARIS', // Sesuaikan dengan user login
            ]
        );

        session()->flash('success', 'Pengumuman berhasil disimpan!');
        $this->showModal = false;
    }

    // --- DELETE ---
    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        $p = Pengumuman::find($this->deleteId);
        if ($p) {
            // Hapus file fisik
            if($p->thumbnail) Storage::disk('public')->delete($p->thumbnail);
            if($p->file_lampiran) Storage::disk('public')->delete($p->file_lampiran);
            $p->delete();
        }
        $this->showDeleteModal = false;
        session()->flash('success', 'Pengumuman dihapus.');
    }
}