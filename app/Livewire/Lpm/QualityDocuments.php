<?php

namespace App\Livewire\Lpm;

use App\Models\QualityDocument;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Quality Documents')]
class QualityDocuments extends Component
{
    use WithPagination, WithFileUploads;

    // modal states
    public $modal = false;
    public $showDeleteModal = false;

    // form / model props
    public $isEditing = false;
    public $docId;
    public $kode;
    public $title;
    public $category = 'SOP';
    public $description;
    public $file;
    public $published_at;

    // delete target
    public $deletingDoc;

    protected $rules = [
        'kode' => 'required|string|max:100',
        'title' => 'required|string|max:255',
        'category' => 'required|string|max:100',
        'description' => 'nullable|string',
        'file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        'published_at' => 'nullable|date',
    ];

    public function mount()
    {
        $this->published_at = now();
    }

  public function resetForm()
{
    $this->reset(['docId', 'kode', 'title', 'category', 'description', 'file', 'published_at', 'isEditing']);
    $this->category = 'SOP';
}

    // create
    public function openCreateModal()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->modal = true;
    }

public function openEditModal($id)
{
    $doc = QualityDocument::findOrFail($id);
    $this->docId = $doc->id;
    $this->kode = $doc->kode ?? null;
    $this->title = $doc->title ?? null;
    $this->category = $doc->category ?? 'SOP';
    $this->description = $doc->description ?? null;
    $this->published_at = $doc->published_at ?? null;
    $this->isEditing = true;
    $this->modal = true;
}

    // save (create or update)
    public function save()
    {
        $rules = $this->rules;

        // require file on create only
        if (! $this->docId) {
            $rules['file'] = 'required|file|mimes:pdf,doc,docx|max:5120';
        }

        $validated = $this->validate($rules);

        $data = [
        'kode' => $validated['kode'],
        'title' => $validated['title'],
        'category' => $validated['category'],
        'description' => $validated['description'],
        'published_at' => $validated['published_at'] ?? now(),
        'created_by' => auth()->id(),
    ];

        // handle file
        if ($this->file) {
            // if editing, delete old file
            if ($this->docId) {
                $old = QualityDocument::find($this->docId);
                if ($old && $old->file_path && Storage::disk('public')->exists($old->file_path)) {
                    Storage::disk('public')->delete($old->file_path);
                }
            }
            $path = $this->file->store('quality-docs', 'public');
            $data['file_path'] = $path;
        }

        if ($this->isEditing && $this->docId) {
            QualityDocument::where('id', $this->docId)->update($data);
        } else {
            $data['slug'] = Str::slug($data['title']) . '-' . uniqid();
        QualityDocument::create($data);
        }

        $this->modal = false;
        $this->resetForm();

        $this->dispatch('notify', ['type' => 'success', 'message' => 'Data berhasil disimpan']);
    }

    // open delete modal (set target)
    public function openDeleteModal($id)
    {
        $this->deletingDoc = QualityDocument::findOrFail($id);
        $this->showDeleteModal = true;
    }

    // close delete modal
    public function closeDeleteModal()
    {
        $this->deletingDoc = null;
        $this->showDeleteModal = false;
    }

    // delete action
    public function delete()
    {
        if (! $this->deletingDoc) {
            $this->closeDeleteModal();
            return;
        }

        // delete file if exists
        if ($this->deletingDoc->file_path && Storage::disk('public')->exists($this->deletingDoc->file_path)) {
            Storage::disk('public')->delete($this->deletingDoc->file_path);
        }

        $this->deletingDoc->delete();

        $this->closeDeleteModal();
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Dokumen berhasil dihapus']);
    }

    public function render()
    {
        return view('livewire.lpm.quality-documents', [
            'documents' => QualityDocument::orderByDesc('created_at')->paginate(10),
        ]);
    }
}
