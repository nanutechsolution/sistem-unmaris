<?php

namespace App\Livewire\Public;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Achievement;
use Livewire\Attributes\Url;

class PrestasiIndex extends Component
{
    use WithPagination;

    #[Url]
    public $category = ''; // Filter Akademik/Olahraga/Seni

    public function setCategory($cat)
    {
        $this->category = $cat;
        $this->resetPage();
    }

    public function render()
    {
        $achievements = Achievement::query()
            ->when($this->category, function($q) {
                $q->where('category', $this->category);
            })
            ->orderByDesc('date') // Yang terbaru di atas
            ->orderBy('medal')    // Emas duluan
            ->paginate(9);

        return view('livewire.public.prestasi-index', [
            'achievements' => $achievements
        ])->layout('components.layouts.public', ['title' => 'Wall of Fame & Prestasi']);
    }
}