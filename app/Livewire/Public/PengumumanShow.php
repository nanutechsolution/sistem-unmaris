<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Pengumuman;

class PengumumanShow extends Component
{
    public $slug;
    public $pengumuman;
    public $terkaits;

    public function mount($slug)
    {
        $this->slug = $slug;
        
        $this->pengumuman = Pengumuman::where('slug', $slug)
            ->where('status', 'Published')
            ->firstOrFail();

        // Hitung Views
        $this->pengumuman->increment('views');

        // Sidebar Berita Terkait
        $this->terkaits = Pengumuman::where('id', '!=', $this->pengumuman->id)
            ->where('status', 'Published')
            ->latest()
            ->take(4)
            ->get();
    }

    public function render()
    {
        return view('livewire.public.pengumuman-show')
            ->layout('components.layouts.public', ['title' => $this->pengumuman->judul]);
    }
}