<?php
namespace App\Livewire\Manajemen;

use App\Models\Setting;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Pengaturan Website')]
class SettingsManager extends Component
{
    // Properti untuk form
    public $alamat;
    public $telepon;
    public $email;
    public $link_facebook;
    public $link_instagram;

    public function mount()
    {
        // Ambil semua setting dan isi properti
        $settings = Setting::pluck('value', 'key');
        $this->alamat = $settings['alamat'] ?? '';
        $this->telepon = $settings['telepon'] ?? '';
        $this->email = $settings['email'] ?? '';
        $this->link_facebook = $settings['link_facebook'] ?? '';
        $this->link_instagram = $settings['link_instagram'] ?? '';
    }

    public function save()
    {
        $data = [
            'alamat' => $this->alamat,
            'telepon' => $this->telepon,
            'email' => $this->email,
            'link_facebook' => $this->link_facebook,
            'link_instagram' => $this->link_instagram,
        ];

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        session()->flash('message', 'Pengaturan berhasil disimpan.');
    }

    public function render()
    {
        return view('livewire.manajemen.settings-manager');
    }
}
