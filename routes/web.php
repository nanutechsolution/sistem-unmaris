<?php

use App\Http\Controllers\Public\AkademikController;
use App\Http\Controllers\Public\PostController;
use App\Livewire\Akademik\DosenManager;
use App\Livewire\Akademik\MahasiswaManager;
use App\Livewire\Akademik\MataKuliahManager;
use App\Livewire\Dashboard;
use App\Livewire\KRS\KartuHasilStudi;
use App\Livewire\KRS\PengisianKrs;
use App\Livewire\KRS\ValidasiKrs;
use App\Livewire\Manajemen\CategoryManager;
use App\Livewire\Manajemen\FakultasManager;
use App\Livewire\Manajemen\PageManager;
use App\Livewire\Manajemen\PostManager;
use App\Livewire\Manajemen\ProdiManager;
use App\Livewire\Manajemen\SettingsManager;
use App\Livewire\Manajemen\TahunAkademikManager;
use App\Livewire\Perkuliahan\InputNilai;
use App\Livewire\Perkuliahan\KelasManager;
use App\Models\Fakultas;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    $fakultas = Fakultas::orderBy('nama_fakultas', 'asc')->get();
    return view('public.home', compact('fakultas'));
})->name('public.home');
Route::get('/fakultas-dan-prodi', [AkademikController::class, 'fakultasProdi'])->name('public.fakultas');
Route::get('/berita', [PostController::class, 'index'])->name('public.posts.index');
Route::get('/berita/{slug}', [PostController::class, 'show'])->name('public.posts.show');
Route::get('/kategori/{slug}', [PostController::class, 'byCategory'])->name('public.posts.category');



Route::middleware(['auth', 'verified'])->group(function () {
Route::get('dashboard', Dashboard::class)->name('dashboard');
Route::get('manajemen/fakultas', FakultasManager::class)->name('fakultas.index');
Route::get('manajemen/prodi', ProdiManager::class)->name('prodi.index');
Route::get('manajemen/tahun-akademik', TahunAkademikManager::class)->name('tahun-akademik.index');
Route::get('akademik/dosen', DosenManager::class)->name('dosen.index');
Route::get('akademik/mahasiswa', MahasiswaManager::class)->name('mahasiswa.index');
Route::get('akademik/mata-kuliah', MataKuliahManager::class)->name('matakuliah.index');
Route::get('perkuliahan/kelas', KelasManager::class)->name('kelas.index');
Route::get('perkuliahan/krs', PengisianKrs::class)->name('krs.index');
Route::get('perkuliahan/validasi-krs', ValidasiKrs::class)->name('krs.validasi');
Route::get('perkuliahan/input-nilai', InputNilai::class)->name('nilai.input');
Route::get('perkuliahan/khs', KartuHasilStudi::class)->name('khs.index');
Route::get('manajemen/halaman', PageManager::class)->name('pages.index');
Route::get('manajemen/pengaturan', SettingsManager::class)->name('settings.index');
Route::get('manajemen/kategori', CategoryManager::class)->name('categories.index');
Route::get('manajemen/berita', PostManager::class)->name('posts.index');
Route::view('profile', 'profile')->name('profile');
});


require __DIR__.'/auth.php';
