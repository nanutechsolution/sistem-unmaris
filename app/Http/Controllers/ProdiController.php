<?php

namespace App\Http\Controllers;

use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProdiController extends Controller
{
    /**
     * Menampilkan detail Program Studi, Kurikulum, dan Profil Lulusan.
     */
    public function show($id): View
    {
         $prodi = ProgramStudi::with([
            'fakultas',
            'dosens' => function ($query) { 
                $query->where('status_kepegawaian', 'Aktif')
                      ->orderBy('nama_lengkap', 'asc');
            }
        ])->findOrFail($id);
        $dosens = \App\Models\Dosen::where('program_studi_id', $id)
                ->where('status_kepegawaian', 'Aktif') // Hanya yang aktif
                ->get();

        // --- MOCK DATA (Simulasi Data Kurikulum & Dosen) ---
        // Nanti bisa diganti dengan relasi database: $prodi->mataKuliahs
        
        $kurikulum = [
            'Semester 1' => [
                ['kode' => 'UN101', 'nama' => 'Pendidikan Agama', 'sks' => 2, 'jenis' => 'Wajib'],
                ['kode' => 'UN102', 'nama' => 'Bahasa Indonesia', 'sks' => 2, 'jenis' => 'Wajib'],
                ['kode' => 'UN103', 'nama' => 'Pengantar Teknologi Informasi', 'sks' => 3, 'jenis' => 'Prodi'],
                ['kode' => 'UN104', 'nama' => 'Logika & Algoritma', 'sks' => 4, 'jenis' => 'Prodi'],
                ['kode' => 'UN105', 'nama' => 'Bahasa Inggris I', 'sks' => 2, 'jenis' => 'Wajib'],
            ],
            'Semester 2' => [
                ['kode' => 'UN201', 'nama' => 'Pendidikan Kewarganegaraan', 'sks' => 2, 'jenis' => 'Wajib'],
                ['kode' => 'UN202', 'nama' => 'Struktur Data', 'sks' => 4, 'jenis' => 'Prodi'],
                ['kode' => 'UN203', 'nama' => 'Sistem Basis Data', 'sks' => 4, 'jenis' => 'Prodi'],
                ['kode' => 'UN204', 'nama' => 'Statistika Dasar', 'sks' => 3, 'jenis' => 'Wajib'],
            ],
            'Semester 3' => [
                ['kode' => 'UN301', 'nama' => 'Pemrograman Web I', 'sks' => 4, 'jenis' => 'Keahlian'],
                ['kode' => 'UN302', 'nama' => 'Jaringan Komputer', 'sks' => 3, 'jenis' => 'Keahlian'],
                ['kode' => 'UN303', 'nama' => 'Sistem Operasi', 'sks' => 3, 'jenis' => 'Keahlian'],
            ],
        ];

        $prospekKarir = [
            'Software Engineer', 'System Analyst', 'Database Administrator', 
            'IT Consultant', 'Technopreneur', 'Researcher'
        ];

        return view('public.prodi.show', compact('prodi', 'kurikulum', 'prospekKarir', 'dosens'));
    }
}