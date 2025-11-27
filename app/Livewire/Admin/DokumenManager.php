<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Dokumen;
use App\Models\DokumenKategori; // Pastikan model ini ada
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DokumenManager extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $showModal = false;

    // Form Input sesuai tabel Bapak
    public $dok_id;
    public $judul;
    public $deskripsi;
    public $kategori_id;
    public $akses = 'Publik'; // Default Publik
    public $file_upload;

    public function render()
    {
        $docs = Dokumen::with('kategori')
            ->where('judul', 'like', '%' . $this->search . '%')
            ->orderByDesc('created_at')
            ->paginate(10);

        $kategoris = DokumenKategori::all(); // Untuk dropdown

        return view('livewire.admin.dokumen-manager', [
            'documents' => $docs,
            'kategoris' => $kategoris
        ])->layout('layouts.app');
    }

    public function create()
    {
        $this->reset();
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'judul' => 'required|string|max:255',
            'kategori_id' => 'required|exists:dokumen_kategori,id',
            'file_upload' => 'required|file|max:20480', // Max 20MB
            'akses' => 'required|in:Publik,Mahasiswa,Dosen,Admin',
        ]);

        // 1. Ambil Info File
        $file = $this->file_upload;
        $ext = $file->getClientOriginalExtension();
        $size = $file->getSize(); // Dalam bytes

        // 2. Simpan Fisik File
        $path = $file->storeAs(
            'dokumen/' . date('Y'),
            Str::slug($this->judul) . '-' . time() . '.' . $ext,
            'public'
        );

        // 3. Simpan ke Database (Sesuai kolom Bapak)
        Dokumen::create([
            'judul' => $this->judul,
            'slug' => Str::slug($this->judul) . '-' . Str::random(5),
            'deskripsi' => $this->deskripsi,
            'kategori_id' => $this->kategori_id,
            'akses' => $this->akses,

            // Data Teknis File
            'file_path' => $path,
            'file_type' => $ext,
            'file_size' => $size, // Simpan integer (bytes) agar akurat

            'fakultas_id' => null, // Bisa dikembangkan nanti
            'program_studi_id' => null,
        ]);

        $this->showModal = false;
        session()->flash('success', 'Dokumen berhasil diunggah.');
    }

    public function delete($id)
    {
        $doc = Dokumen::find($id);
        if ($doc) {
            Storage::disk('public')->delete($doc->file_path);
            $doc->delete();
        }
        session()->flash('success', 'Dokumen dihapus.');
    }
}
