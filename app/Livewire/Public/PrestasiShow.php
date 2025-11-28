<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Achievement;

class PrestasiShow extends Component
{
    public $achievement;
    public $related;

    public function mount($id)
    {
        $this->achievement = Achievement::findOrFail($id);

        // Ambil prestasi lain yang sejenis (kategori sama) untuk "Lihat Juga"
        $this->related = Achievement::where('category', $this->achievement->category)
            ->where('id', '!=', $id)
            ->orderByDesc('date')
            ->take(3)
            ->get();
    }

    public function render()
    {
        return view('livewire.public.prestasi-show')
            ->layout('components.layouts.public', ['title' => $this->achievement->title]);
    }
}