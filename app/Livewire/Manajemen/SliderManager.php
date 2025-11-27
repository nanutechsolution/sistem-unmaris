<?php

namespace App\Livewire\Manajemen;

use App\Models\Slider;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.app')]
#[Title('Manajemen Slider')]
class SliderManager extends Component
{
    use WithFileUploads;

    // Data List
    public $sliders;

    // Form Properties
    public $slider_id;
    public $title;
    public $description;
    public $type = 'image'; // Default image
    public $button_text;
    public $button_url;
    public $order = 0;
    public $active = true;

    // Uploads
    public $file_upload;      // File Baru (Gambar/Video)
    public $poster_upload;    // Poster Baru (Khusus Video)
    
    // Old Paths (Untuk Preview saat Edit)
    public $old_file_path;
    public $old_poster_path;

    // UI States
    public $showModal = false;
    public $isEditing = false;
    public $showDeleteModal = false;
    public $deletingId = null;

    // --- PESAN ERROR YANG LEBIH JELAS ---
    protected $messages = [
        'file_upload.required' => 'Mohon pilih file terlebih dahulu.',
        'file_upload.image' => 'File harus berupa gambar (JPG, JPEG, PNG).',
        'file_upload.mimes' => 'Format video tidak didukung. Coba gunakan MP4, M4V, MOV, atau AVI.',
        'file_upload.max' => 'Ukuran file terlalu besar (Maksimum 50MB untuk video).',
        
        'poster_upload.image' => 'Cover video harus berupa gambar (JPG/PNG).',
        'poster_upload.max' => 'Ukuran cover video maksimal 2MB.',
        
        'title.max' => 'Judul maksimal 255 karakter.',
        'type.required' => 'Pilih jenis media (Gambar/Video).',
    ];

    // Validasi Dasar (File akan divalidasi ulang di save)
    protected $rules = [
        'title' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'type' => 'required|in:image,video',
        'button_text' => 'nullable|string|max:50',
        'button_url' => 'nullable|string|max:255',
        'order' => 'integer',
        'active' => 'boolean',
    ];

    public function render()
    {
        $this->sliders = Slider::orderBy('order', 'asc')->get();
        return view('livewire.manajemen.slider-manager');
    }

    // --- CRUD ---

    public function create()
    {
        $this->reset();
        $this->type = 'image';
        $this->active = true;
        $this->order = Slider::max('order') + 1; 
        $this->isEditing = false;
        $this->showModal = true;
        $this->resetErrorBag();
    }

    public function edit($id)
    {
        $this->reset();
        $this->resetErrorBag();
        
        $s = Slider::findOrFail($id);
        
        $this->slider_id = $s->id;
        $this->title = $s->title;
        $this->description = $s->description;
        $this->type = $s->type;
        $this->button_text = $s->button_text;
        $this->button_url = $s->button_url;
        $this->order = $s->order;
        $this->active = (bool) $s->active;
        
        $this->old_file_path = $s->file_path;
        $this->old_poster_path = $s->poster_path;

        $this->isEditing = true;
        $this->showModal = true;
    }

    public function save()
    {
        // --- KONFIGURASI VALIDASI VIDEO YANG LEBIH LUAS ---
        // Menambahkan m4v, webm, dan menaikkan limit ke 50MB (51200 KB)
        $videoRules = 'mimes:mp4,mov,avi,m4v,webm,qt|max:51200'; 
        $imageRules = 'image|max:5120'; // Max 5MB untuk gambar

        $fileRules = 'nullable';
        if (!$this->isEditing) {
            // Create Baru: Wajib ada file
            $fileRules = $this->type == 'video' ? "required|$videoRules" : "required|$imageRules";
        } else {
            // Edit: Boleh kosong (pakai file lama), tapi kalau ada upload harus divalidasi
            $fileRules = $this->type == 'video' ? "nullable|$videoRules" : "nullable|$imageRules";
        }

        // Lakukan Validasi
        $this->validate([
            'file_upload' => $fileRules,
            'poster_upload' => 'nullable|image|max:2048',
            'title' => 'nullable|string|max:255',
            'type' => 'required|in:image,video',
        ], $this->messages);

        // 1. Handle File Utama
        $filePath = $this->old_file_path;
        if ($this->file_upload) {
            if ($this->old_file_path) Storage::disk('public')->delete($this->old_file_path);
            
            $folder = $this->type == 'video' ? 'sliders/videos' : 'sliders/images';
            $filePath = $this->file_upload->store($folder, 'public');
        }

        // 2. Handle Poster
        $posterPath = $this->old_poster_path;
        if ($this->poster_upload && $this->type == 'video') {
            if ($this->old_poster_path) Storage::disk('public')->delete($this->old_poster_path);
            $posterPath = $this->poster_upload->store('sliders/posters', 'public');
        }

        // 3. Simpan ke Database
        Slider::updateOrCreate(
            ['id' => $this->slider_id],
            [
                'title' => $this->title,
                'description' => $this->description,
                'type' => $this->type,
                'file_path' => $filePath,
                'poster_path' => $this->type == 'video' ? $posterPath : null,
                'button_text' => $this->button_text,
                'button_url' => $this->button_url,
                'order' => $this->order,
                'active' => $this->active,
            ]
        );

        $this->showModal = false;
        session()->flash('success', 'Slider berhasil disimpan.');
    }

    // --- DELETE & TOGGLE ---
    public function confirmDelete($id)
    {
        $this->deletingId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        $s = Slider::find($this->deletingId);
        if ($s) {
            if ($s->file_path) Storage::disk('public')->delete($s->file_path);
            if ($s->poster_path) Storage::disk('public')->delete($s->poster_path);
            $s->delete();
        }
        $this->showDeleteModal = false;
        session()->flash('success', 'Slider dihapus.');
    }

    public function toggleActive($id)
    {
        $s = Slider::find($id);
        $s->active = !$s->active;
        $s->save();
    }

    // Helper untuk preview aman (mencegah error m4v)
    public function getSafeTemporaryUrl($temporaryFile)
    {
        if (!$temporaryFile) return null;
        try {
            return $temporaryFile->temporaryUrl();
        } catch (\Exception $e) {
            return null;
        }
    }
}