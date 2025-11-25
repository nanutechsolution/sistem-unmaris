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

    // --- PESAN ERROR YANG RAMAH USER (BAHASA INDONESIA) ---
    protected $messages = [
        'file_upload.required' => 'Mohon pilih file (Gambar/Video) terlebih dahulu untuk diupload.',
        'file_upload.image' => 'File harus berupa gambar (format JPG, JPEG, atau PNG).',
        'file_upload.mimes' => 'Format file tidak didukung. Harap upload video (MP4, MOV, AVI) atau gambar (JPG, PNG).',
        'file_upload.max' => 'Ukuran file terlalu besar. Batas maksimum adalah 20MB untuk video dan 2MB untuk gambar.',

        'poster_upload.image' => 'Cover video harus berupa gambar (JPG/PNG).',
        'poster_upload.max' => 'Ukuran cover video terlalu besar (Maksimal 2MB).',

        'title.max' => 'Judul terlalu panjang (maksimal 255 karakter).',
        'button_text.max' => 'Teks tombol terlalu panjang (maksimal 50 karakter).',
        'type.required' => 'Silakan pilih jenis media (Gambar atau Video).',
        'type.in' => 'Jenis media tidak valid.',
    ];

    protected $rules = [
        'title' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'type' => 'required|in:image,video',
        'button_text' => 'nullable|string|max:50',
        'button_url' => 'nullable|string|max:255',
        'order' => 'integer',
        'active' => 'boolean',
        // Validasi File dinamis di function save()
    ];

    public function render()
    {
        // Ambil semua slider diurutkan berdasarkan 'order'
        $this->sliders = Slider::orderBy('order', 'asc')->get();
        return view('livewire.manajemen.slider-manager');
    }

    // --- CRUD ---

    public function create()
    {
        $this->reset();
        $this->type = 'image';
        $this->active = true;
        $this->order = Slider::max('order') + 1; // Auto increment order
        $this->isEditing = false;
        $this->showModal = true;
        $this->resetErrorBag(); // Bersihkan error lama saat buka modal
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
        // Validasi File Khusus
        $fileRules = 'nullable';
        if (!$this->isEditing) {
            // Kalau create baru, file wajib ada
            // Pesan error khusus ditangani via $messages
            $fileRules = $this->type == 'video' ? 'required|mimes:mp4,mov,avi|max:20480' : 'required|image|max:2048';
        } else {
            // Kalau edit, boleh kosong (pakai file lama)
            $fileRules = $this->type == 'video' ? 'nullable|mimes:mp4,mov,avi|max:20480' : 'nullable|image|max:2048';
        }

        // Validasi dengan pesan custom
        $this->validate([
            'file_upload' => $fileRules,
            'poster_upload' => 'nullable|image|max:2048', // Cover video
            'title' => 'nullable|string|max:255',
            'type' => 'required|in:image,video',
        ], $this->messages); // Inject custom messages here if not picked up automatically

        // 1. Handle File Utama (Gambar/Video)
        $filePath = $this->old_file_path;
        if ($this->file_upload) {
            if ($this->old_file_path) Storage::disk('public')->delete($this->old_file_path);
            $folder = $this->type == 'video' ? 'sliders/videos' : 'sliders/images';
            $filePath = $this->file_upload->store($folder, 'public');
        }

        // 2. Handle Poster (Khusus Video)
        $posterPath = $this->old_poster_path;
        if ($this->poster_upload && $this->type == 'video') {
            if ($this->old_poster_path) Storage::disk('public')->delete($this->old_poster_path);
            $posterPath = $this->poster_upload->store('sliders/posters', 'public');
        }

        // 3. Simpan Database
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
        session()->flash('success', 'Slider berhasil disimpan dan akan tampil di halaman depan.');
    }

    // --- DELETE ---
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
        session()->flash('success', 'Slider berhasil dihapus.');
    }

    // --- FITUR TOGGLE AKTIF ---
    public function toggleActive($id)
    {
        $s = Slider::find($id);
        $s->active = !$s->active;
        $s->save();
    }
}
