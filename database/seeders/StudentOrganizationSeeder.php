<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StudentOrganization;

class StudentOrganizationSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama' => 'BEM Universitas',
                'kategori' => 'Organisasi',
                'deskripsi' => 'Badan Eksekutif Mahasiswa sebagai lembaga eksekutif tertinggi.',
                'icon' => 'fas fa-users',
                'warna' => 'bg-blue-600'
            ],
            [
                'nama' => 'Mapala "Maritim"',
                'kategori' => 'Minat Bakat',
                'deskripsi' => 'Mahasiswa Pecinta Alam yang fokus pada pelestarian lingkungan pesisir.',
                'icon' => 'fas fa-mountain',
                'warna' => 'bg-green-600'
            ],
            [
                'nama' => 'Paduan Suara',
                'kategori' => 'Seni',
                'deskripsi' => 'Mengembangkan bakat tarik suara dan tampil di acara wisuda/nasional.',
                'icon' => 'fas fa-music',
                'warna' => 'bg-purple-600'
            ],
            [
                'nama' => 'E-Sport UNMARIS',
                'kategori' => 'Olahraga',
                'deskripsi' => 'Komunitas kompetitif Mobile Legends, PUBG, dan Valorant.',
                'icon' => 'fas fa-gamepad',
                'warna' => 'bg-indigo-600'
            ],
            [
                'nama' => 'LDK Al-Bahar',
                'kategori' => 'Kerohanian',
                'deskripsi' => 'Lembaga Dakwah Kampus untuk pembinaan karakter Islami.',
                'icon' => 'fas fa-mosque',
                'warna' => 'bg-emerald-600'
            ],
            [
                'nama' => 'PMK (Persekutuan Mahasiswa Kristen)',
                'kategori' => 'Kerohanian',
                'deskripsi' => 'Wadah persekutuan dan pelayanan mahasiswa Kristen.',
                'icon' => 'fas fa-church',
                'warna' => 'bg-cyan-600'
            ],
        ];

        foreach ($data as $item) {
            StudentOrganization::create($item);
        }
    }
}