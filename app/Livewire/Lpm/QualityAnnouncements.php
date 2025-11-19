<?php

namespace App\Livewire\Lpm;

use App\Models\QualityAnnouncement;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Quality Announcements')]
class QualityAnnouncements extends Component
{
    use WithPagination;

    // Modal States
    public $modal = false;
    public $showDeleteModal = false;

    // Form / Model Properties
    public $annId;
    public $title;
    public $content;
    public $published_at;

    // Delete Target
    public $deletingAnnId;
    public $deletingAnnTitle; // Untuk konfirmasi di modal delete

    protected $rules = [
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'published_at' => 'nullable|date',
    ];

    public function resetForm()
    {
        $this->reset(['annId', 'title', 'content', 'published_at']);
        $this->published_at = now()->format('Y-m-d');
        $this->resetValidation();
    }

    /**
     * Buka modal untuk membuat pengumuman baru.
     */
    public function create()
    {
        $this->resetForm();
        $this->modal = true;
    }

    /**
     * Buka modal untuk mengedit pengumuman.
     */
    public function edit($id)
    {
        $a = QualityAnnouncement::findOrFail($id);

        $this->annId = $a->id;
        $this->title = $a->title;
        $this->content = $a->content;
        $this->published_at = optional($a->published_at)->format('Y-m-d');

        $this->modal = true;
    }

    /**
     * Simpan (Create atau Update) pengumuman.
     */
    public function save()
    {
        $validated = $this->validate();

        // 1. Tentukan Slug
        if ($this->annId) {
            // Jika update, ambil slug yang sudah ada atau buat baru jika tidak ada
            $slug = QualityAnnouncement::find($this->annId)->slug ?? Str::slug($this->title) . '-' . uniqid(2);
        } else {
            // Jika create, buat slug unik
            $slug = Str::slug($this->title) . '-' . uniqid(2);
        }

        // 2. Simpan Data
        QualityAnnouncement::updateOrCreate(
            ['id' => $this->annId],
            [
                'title' => $validated['title'],
                'slug' => $slug,
                'content' => $validated['content'],
                'published_at' => $validated['published_at'],
                'posted_by' => auth()->id() // Mencatat user yang memposting
            ]
        );

        $this->modal = false;
        $this->resetForm();
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Pengumuman berhasil disimpan.']);
    }

    /**
     * Buka modal konfirmasi hapus.
     */
    public function openDeleteModal($id)
    {
        $announcement = QualityAnnouncement::findOrFail($id);
        $this->deletingAnnId = $announcement->id;
        $this->deletingAnnTitle = $announcement->title;
        $this->showDeleteModal = true;
    }

    /**
     * Tutup modal konfirmasi hapus.
     */
    public function closeDeleteModal()
    {
        $this->reset(['deletingAnnId', 'deletingAnnTitle']);
        $this->showDeleteModal = false;
    }

    /**
     * Hapus pengumuman.
     */
    public function delete()
    {
        if (! $this->deletingAnnId) {
            $this->closeDeleteModal();
            return;
        }

        QualityAnnouncement::find($this->deletingAnnId)->delete();

        $this->closeDeleteModal();
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Pengumuman berhasil dihapus.']);
    }

    public function render()
    {
        return view('livewire.lpm.quality-announcements', [
            'announcements' => QualityAnnouncement::latest()->paginate(10),
        ]);
    }
}
