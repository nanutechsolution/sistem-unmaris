<?php

namespace App\Livewire\Manajemen;

use App\Models\Setting;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.app')]
#[Title('Pengaturan Website')]
class SettingsManager extends Component
{
    use WithFileUploads;

    public $activeTab = 'general';

    // Array untuk menampung input (Key => Value)
    public $inputs = [];

    // Array khusus untuk upload gambar (Key => File Temporary)
    public $image_uploads = [];

    public function mount()
    {
        // Load semua setting ke properti inputs
        $settings = Setting::all();
        foreach ($settings as $s) {
            $this->inputs[$s->key] = $s->value;
        }
    }

    public function save()
    {
        // 1. Simpan Input Teks Biasa
        foreach ($this->inputs as $key => $value) {
            // Skip jika ini adalah key gambar (karena gambar ditangani terpisah di bawah)
            if (array_key_exists($key, $this->image_uploads)) continue;

            Setting::where('key', $key)->update(['value' => $value]);

            // Hapus cache agar update langsung terasa di frontend
            Cache::forget("setting_{$key}");
        }

        // 2. Simpan Upload Gambar (Jika ada)
        foreach ($this->image_uploads as $key => $file) {
            if ($file) {
                $path = $file->store('settings', 'public');

                // Hapus gambar lama jika ada (optional, good practice)
                $old = Setting::where('key', $key)->value('value');
                if ($old) Storage::disk('public')->delete($old);

                Setting::where('key', $key)->update(['value' => $path]);
                Cache::forget("setting_{$key}");

                // Update tampilan input
                $this->inputs[$key] = $path;
            }
        }

        // Reset upload temporary
        $this->image_uploads = [];

        session()->flash('success', 'Pengaturan berhasil diperbarui.');
    }

    public function render()
    {
        // Grouping setting untuk View
        $settings = Setting::all()->groupBy('group');

        return view('livewire.manajemen.settings-manager', [
            'groupedSettings' => $settings
        ]);
    }
}
