<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\StructuralPosition;
use App\Models\Fakultas; // Import Model Fakultas
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.public')]
#[Title('Struktur Organisasi')]
class StrukturOrganisasi extends Component
{
    public function render()
    {
        // 1. Pimpinan Universitas
        $leaders = StructuralPosition::with(['currentOfficial.dosen'])->orderBy('urutan')->get()->groupBy('group');

        // 2. Dekan
        $dekans = Fakultas::with(['dekanAktif.dosen'])->get()->filter(fn($f) => $f->dekanAktif != null);

        // 3. KAPRODI (TAMBAHAN BARU)
        // Ambil Prodi yang punya Kaprodi Aktif, urutkan berdasarkan Fakultas agar rapi
        $kaprodis = \App\Models\ProgramStudi::with(['kaprodiAktif.dosen', 'fakultas'])
            ->orderBy('fakultas_id')
            ->get()
            ->filter(fn($p) => $p->kaprodiAktif != null);

        return view('livewire.public.struktur-organisasi', [
            'groupedLeaders' => $leaders,
            'dekans' => $dekans,
            'kaprodis' => $kaprodis // <-- Kirim ke View
        ]);
    }
}
