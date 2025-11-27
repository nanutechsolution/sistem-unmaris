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
    
    // KITA GANTI $title MENJADI 2 BAGIAN
    public $title_1; // Bagian Putih (Baris 1)
    public $title_2; // Bagian Kuning (Baris 2)

    public $description;
    public $type = 'image'; 
    public $button_text;
    public $button_url;
    public $order = 0;
    public $active = true;

    // Uploads & Paths
    public $file_upload, $poster_upload;
    public $old_file_path, $old_poster_path;

    // UI States
    public $showModal = false;
    public $isEditing = false;
    public $showDeleteModal = false;
    public $deletingId = null;

    // Pesan Error
    protected $messages = [
        'file_upload.required' => 'Mohon pilih file terlebih dahulu.',
        'file_upload.image' => 'File harus berupa gambar (JPG, JPEG, PNG).',
        'file_upload.mimes' => 'Format video tidak didukung. Gunakan MP4, M4V, MOV.',
        'file_upload.max' => 'Ukuran file terlalu besar.',
        'title_1.max' => 'Judul utama terlalu panjang.',
        'title_2.max' => 'Judul highlight terlalu panjang.',
    ];

    public function render()
    {
        $this->sliders = Slider::orderBy('order', 'asc')->get();
        return view('livewire.manajemen.slider-manager');
    }

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
        $this->description = $s->description;
        $this->type = $s->type;
        $this->button_text = $s->button_text;
        $this->button_url = $s->button_url;
        $this->order = $s->order;
        $this->active = (bool) $s->active;
        
        $this->old_file_path = $s->file_path;
        $this->old_poster_path = $s->poster_path;

        // --- LOGIC PECAH HTML KE 2 INPUT ---
        // Format DB: "Judul 1 <br> <span class="...">Judul 2</span>"
        // Kita gunakan Regex sederhana untuk memisahkan
        if (preg_match('/(.*?)\s*<br>\s*<span.*?>(.*?)<\/span>/s', $s->title, $matches)) {
            $this->title_1 = trim($matches[1]);
            $this->title_2 = trim($matches[2]);
        } else {
            // Jika format tidak sesuai (teks biasa), masukkan semua ke title 1
            $this->title_1 = strip_tags($s->title); 
            $this->title_2 = '';
        }

        $this->isEditing = true;
        $this->showModal = true;
    }

    public function save()
    {
        // Konfigurasi Validasi
        $videoRules = 'mimes:mp4,mov,avi,m4v,webm,qt,bin|max:2048000'; 
        $imageRules = 'image|max:10240';

        $fileRules = 'nullable';
        if (!$this->isEditing) {
            $fileRules = $this->type == 'video' ? "required|$videoRules" : "required|$imageRules";
        } else {
            $fileRules = $this->type == 'video' ? "nullable|$videoRules" : "nullable|$imageRules";
        }

        $this->validate([
            'file_upload' => $fileRules,
            'title_1' => 'nullable|string|max:100', // Validasi field baru
            'title_2' => 'nullable|string|max:100',
            'type' => 'required|in:image,video',
        ], $this->messages);

        // --- LOGIC GABUNG 2 INPUT JADI HTML ---
        $fullTitle = $this->title_1;
        if (!empty($this->title_2)) {
            // Tambahkan tag BR dan SPAN otomatis
            $fullTitle .= ' <br> <span class="text-unmaris-yellow">' . $this->title_2 . '</span>';
        }

        // Handle File
        $filePath = $this->old_file_path;
        if ($this->file_upload) {
            if ($this->old_file_path) Storage::disk('public')->delete($this->old_file_path);
            $folder = $this->type == 'video' ? 'sliders/videos' : 'sliders/images';
            $filePath = $this->file_upload->store($folder, 'public');
        }

        // Handle Poster
        $posterPath = $this->old_poster_path;
        if ($this->poster_upload && $this->type == 'video') {
            if ($this->old_poster_path) Storage::disk('public')->delete($this->old_poster_path);
            $posterPath = $this->poster_upload->store('sliders/posters', 'public');
        }

        // Simpan ke DB
        Slider::updateOrCreate(
            ['id' => $this->slider_id],
            [
                'title' => $fullTitle, // Simpan hasil gabungan
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

    // ... (Fungsi delete, confirmDelete, toggleActive, getSafeTemporaryUrl SAMA SEPERTI SEBELUMNYA) ...
    public function confirmDelete($id) { $this->deletingId = $id; $this->showDeleteModal = true; }
    public function delete() { 
        $s = Slider::find($this->deletingId);
        if ($s) {
            if ($s->file_path) Storage::disk('public')->delete($s->file_path);
            if ($s->poster_path) Storage::disk('public')->delete($s->poster_path);
            $s->delete();
        }
        $this->showDeleteModal = false;
        session()->flash('success', 'Slider dihapus.');
    }
    public function toggleActive($id) {
        $s = Slider::find($id);
        $s->active = !$s->active;
        $s->save();
    }
    public function getSafeTemporaryUrl($temporaryFile) {
        if (!$temporaryFile) return null;
        try { return $temporaryFile->temporaryUrl(); } catch (\Exception $e) { return null; }
    }
}