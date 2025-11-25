<?php

namespace App\Livewire\Manajemen;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TahunAkademik;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Validation\Rule;

#[Layout('layouts.app')]
#[Title('Tahun Akademik')]
class TahunAkademikManager extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $isEditing = false;
    public $deleteId = null;
    public $showDeleteModal = false;

    // Form Fields (Lengkap)
    public $ta_id;
    public $kode_tahun;
    public $nama_tahun;
    public $semester = 'Ganjil';
    public $status = 'Tidak Aktif';
    public $tgl_mulai_krs;
    public $tgl_selesai_krs;
    public $tgl_mulai_kuliah;
    public $tgl_selesai_kuliah;

    public function render()
    {
        $data = TahunAkademik::orderBy('kode_tahun', 'desc')
            ->where('nama_tahun', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.manajemen.tahun-akademik-manager', [
            'tahun_akademiks' => $data
        ]);
    }

    public function rules()
    {
        return [
            'kode_tahun' => ['required', 'numeric', 'digits:5', Rule::unique('tahun_akademiks')->ignore($this->ta_id)],
            'nama_tahun' => 'required|string|max:255',
            'semester' => 'required|in:Ganjil,Genap',
            'status' => 'required|in:Aktif,Tidak Aktif',
            'tgl_mulai_krs' => 'nullable|date',
            'tgl_selesai_krs' => 'nullable|date|after_or_equal:tgl_mulai_krs',
            'tgl_mulai_kuliah' => 'nullable|date',
            'tgl_selesai_kuliah' => 'nullable|date|after_or_equal:tgl_mulai_kuliah',
        ];
    }

    public function create()
    {
        $this->reset();
        $this->semester = 'Ganjil';
        $this->status = 'Tidak Aktif';
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $this->reset();
        $ta = TahunAkademik::findOrFail($id);
        $this->ta_id = $ta->id;
        $this->kode_tahun = $ta->kode_tahun;
        $this->nama_tahun = $ta->nama_tahun;
        $this->semester = $ta->semester;
        $this->status = $ta->status;

        // Format tanggal untuk input HTML date (Y-m-d)
        $this->tgl_mulai_krs = $ta->tgl_mulai_krs?->format('Y-m-d');
        $this->tgl_selesai_krs = $ta->tgl_selesai_krs?->format('Y-m-d');
        $this->tgl_mulai_kuliah = $ta->tgl_mulai_kuliah?->format('Y-m-d');
        $this->tgl_selesai_kuliah = $ta->tgl_selesai_kuliah?->format('Y-m-d');

        $this->isEditing = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        // Jika status AKTIF, matikan yang lain
        if ($this->status == 'Aktif') {
            TahunAkademik::where('id', '!=', $this->ta_id)->update(['status' => 'Tidak Aktif']);
        }

        TahunAkademik::updateOrCreate(
            ['id' => $this->ta_id],
            [
                'kode_tahun' => $this->kode_tahun,
                'nama_tahun' => $this->nama_tahun,
                'semester' => $this->semester,
                'status' => $this->status,
                'tgl_mulai_krs' => $this->tgl_mulai_krs,
                'tgl_selesai_krs' => $this->tgl_selesai_krs,
                'tgl_mulai_kuliah' => $this->tgl_mulai_kuliah,
                'tgl_selesai_kuliah' => $this->tgl_selesai_kuliah,
            ]
        );

        $this->showModal = false;
        session()->flash('success', 'Data Tahun Akademik berhasil disimpan.');
    }

    public function toggleActive($id)
    {
        TahunAkademik::query()->update(['status' => 'Tidak Aktif']);
        $ta = TahunAkademik::find($id);
        $ta->status = 'Aktif';
        $ta->save();
        session()->flash('success', "Tahun Akademik {$ta->kode_tahun} sekarang AKTIF.");
    }

    public function delete()
    { /* Logic hapus sama spt sebelumnya */
    }
}
