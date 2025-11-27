<?php

namespace App\Livewire\Public;

use App\Models\Facility;
use Livewire\Component;
use Livewire\Attributes\Url;

class FasilitasIndex extends Component
{
    #[Url]
    public $category = ''; // Filter Kategori

    public function setCategory($cat)
    {
        $this->category = $cat;
    }

    public function render()
    {
        $facilities = Facility::where('is_active', true)
            ->when($this->category, function($q) {
                $q->where('category', $this->category);
            })
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        // Hitung jumlah per kategori untuk menu filter
        $categories = Facility::where('is_active', true)
            ->selectRaw('category, count(*) as count')
            ->groupBy('category')
            ->get();

        return view('livewire.public.fasilitas-index', [
            'facilities' => $facilities,
            'categories' => $categories
        ])->layout('components.layouts.public', ['title' => 'Fasilitas Kampus']);
    }
}