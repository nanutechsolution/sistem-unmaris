<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// --- 1. CONTROLLERS (FRONTEND / PUBLIC) ---
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FakultasController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\AkreditasiController;
use App\Http\Controllers\LpmController;
use App\Http\Controllers\LppmController;
use App\Http\Controllers\PmbController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\KemahasiswaanController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\PublicAnnouncementController;
use App\Http\Controllers\Public\AkademikController;
use App\Http\Controllers\TrixImageController;

// --- 2. LIVEWIRE COMPONENTS (BACKEND / ADMIN) ---
use App\Livewire\Dashboard;

// Admin: Master Data
use App\Livewire\Manajemen\FakultasManager;
use App\Livewire\Manajemen\ProdiManager;
use App\Livewire\Manajemen\TahunAkademikManager;
use App\Livewire\Manajemen\KurikulumManager;
use App\Livewire\Akademik\MataKuliahManager;

// Admin: Civitas (SDM)
use App\Livewire\Akademik\DosenManager;
use App\Livewire\Akademik\MahasiswaManager;
use App\Livewire\Akademik\DekanManager;
use App\Livewire\Akademik\KaprodiManager as AdminKaprodiManager;
use App\Livewire\Akademik\PenugasanDosenManager;

// Admin: Perkuliahan
use App\Livewire\Perkuliahan\KelasManager;
use App\Livewire\KRS\PengisianKrs;
use App\Livewire\KRS\ValidasiKrs;
use App\Livewire\Perkuliahan\InputNilai;
use App\Livewire\KRS\KartuHasilStudi;

// Admin: CMS & Website
use App\Livewire\Manajemen\PostManager;
use App\Livewire\Manajemen\CategoryManager;
use App\Livewire\Manajemen\PageManager;
use App\Livewire\Manajemen\SliderManager;
use App\Livewire\Manajemen\SettingsManager;
use App\Livewire\Admin\PengumumanManager;
use App\Livewire\Admin\DokumenManager;
use App\Livewire\Admin\KaprodiManager;
use App\Livewire\Manajemen\PmbGelombangManager;

// Admin: LPM
use App\Livewire\Lpm\QualityDocuments;
use App\Livewire\Lpm\QualityAnnouncements;
use App\Livewire\Master\FinanceManager;
// Livewire Public Components
use App\Livewire\Public\PengumumanIndex;
use App\Livewire\Public\PengumumanShow;
use App\Livewire\Public\DokumenIndex;
use App\Livewire\Public\FasilitasIndex;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (Website Depan - Bisa diakses Tamu)
|--------------------------------------------------------------------------
*/

Route::get('/', HomeController::class)->name('home');
Route::get('/page/{slug}', [PageController::class, 'show'])->name('pages.show');

Route::prefix('berita')->name('public.posts.')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('index');
    Route::get('/{slug}', [PostController::class, 'show'])->name('show');
    Route::get('/kategori/{slug}', [PostController::class, 'byCategory'])->name('category');
});

Route::prefix('pengumuman')->name('public.pengumuman.')->group(function () {
    Route::get('/', PengumumanIndex::class)->name('index');
    Route::get('/{slug}', PengumumanShow::class)->name('show');
});

Route::prefix('fakultas')->name('public.fakultas.')->group(function () {
    Route::get('/{id}', [FakultasController::class, 'show'])->name('show');
    Route::get('/prodi/{id}', [ProdiController::class, 'show'])->name('prodi.show');
    Route::get('/list/semua', [AkademikController::class, 'fakultasProdi'])->name('index');
});

Route::prefix('dokumen')->name('public.dokumen.')->group(function () {
    Route::get('/', DokumenIndex::class)->name('index');
    Route::get('/{dokumen}/download', [DokumenController::class, 'download'])->name('download');
});

Route::prefix('akreditasi')->name('public.akreditasi.')->group(function () {
    Route::get('/institusi', [AkreditasiController::class, 'institusi'])->name('institusi');
    Route::get('/program-studi', [AkreditasiController::class, 'programStudi'])->name('prodi');
});

Route::prefix('lpm')->name('public.lpm.')->group(function () {
    Route::get('/', [LpmController::class, 'index'])->name('index');
    Route::get('/profil/{slug?}', [LpmController::class, 'profile'])->name('profile');
    Route::get('/dokumen/{slug}', [LpmController::class, 'document'])->name('document');
    Route::get('/pengumuman', [LpmController::class, 'announcementsIndex'])->name('announcements.index');
    Route::get('/pengumuman/{slug}', [LpmController::class, 'announcement'])->name('announcement.show');
});

Route::get('/kontak', [ContactController::class, 'index'])->name('public.contact');
Route::post('/kontak/store', [ContactController::class, 'store'])->name('contact.store');
Route::get('/pmb', [PmbController::class, 'index'])->name('public.pmb.index');
Route::get('/kemahasiswaan', [KemahasiswaanController::class, 'index'])->name('public.kemahasiswaan.index');
Route::get('/lppm', [LppmController::class, 'index'])->name('public.lppm.index');
Route::get('/fasilitas', FasilitasIndex::class)->name('public.fasilitas.index');
Route::get('/library', [LibraryController::class, 'index'])->name('public.library.index');


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (SIAKAD & CMS - Wajib Login)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard (Bisa diakses semua role yang login)
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::view('/profile', 'profile')->name('profile');

    Route::post('/trix-upload', [TrixImageController::class, 'store'])->name('trix.upload');


    // --- GRUP 1: ZONA MANAJEMEN (BAAK & Super Admin) ---
    // Mengelola Data Master, SDM, dan Jadwal
    Route::middleware(['role:super_admin|baak'])->group(function () {

        Route::get('/fasilitas', \App\Livewire\Master\FacilityManager::class)->name('fasilitas.index');

        // Master Data
        Route::prefix('master')->name('master.')->group(function () {
            Route::get('/fakultas', FakultasManager::class)->name('fakultas.index');
            Route::get('/prodi', ProdiManager::class)->name('prodi.index');
            Route::get('/tahun-akademik', TahunAkademikManager::class)->name('tahun-akademik.index');
            Route::get('/kurikulum', KurikulumManager::class)->name('kurikulum.index');
            Route::get('/biaya', FinanceManager::class)->name('finance.index');
        });

        // Civitas & SDM
        Route::prefix('civitas')->name('civitas.')->group(function () {
            Route::get('/dosen', DosenManager::class)->name('dosen.index');
            Route::get('/mahasiswa', MahasiswaManager::class)->name('mahasiswa.index');
            Route::get('/dekan', DekanManager::class)->name('dekan.index');
            Route::get('/kaprodi', KaprodiManager::class)->name('kaprodi.index');
            Route::get('/penugasan-dosen', PenugasanDosenManager::class)->name('penugasan-dosen.index');
        });

        // Manajemen Mata Kuliah & Jadwal
        Route::prefix('akademik')->name('akademik.')->group(function () {
            Route::get('/mata-kuliah', MataKuliahManager::class)->name('matakuliah.index');
            Route::get('/kelas', KelasManager::class)->name('kelas.index');
        });
    });


    // --- GRUP 2: ZONA DOSEN (Akademik Operasional) ---
    // Diakses oleh: Dosen, BAAK (untuk bantu), Super Admin
    Route::middleware(['role:super_admin|baak|dosen'])->prefix('akademik')->name('akademik.')->group(function () {

        // Validasi KRS (Dosen Wali)
        Route::get('/krs/validasi', ValidasiKrs::class)->name('krs.validasi');

        // Input Nilai (Dosen Pengampu)
        Route::get('/nilai', InputNilai::class)->name('nilai.index');
    });


    // --- GRUP 3: ZONA MAHASISWA ---
    Route::middleware(['role:super_admin|baak|mahasiswa'])->prefix('akademik')->name('akademik.')->group(function () {
        // Pengisian KRS
        Route::get('/krs', PengisianKrs::class)->name('krs.index');
        // Lihat KHS
        Route::get('/khs', KartuHasilStudi::class)->name('khs.index');
    });


    // --- GRUP 4: ZONA LPM ---
    Route::middleware(['role:super_admin|lpm'])->prefix('lpm')->name('lpm.')->group(function () {
        Route::get('/dokumen-mutu', QualityDocuments::class)->name('documents.index');
        Route::get('/info-mutu', QualityAnnouncements::class)->name('announcements.index');
    });


    // --- GRUP 5: ZONA CMS (Website) ---
    Route::middleware(['role:super_admin|baak|lpm'])->prefix('cms')->name('cms.')->group(function () {
        Route::get('/berita', PostManager::class)->name('posts.index');
        Route::get('/kategori', CategoryManager::class)->name('categories.index');
        Route::get('/halaman', PageManager::class)->name('pages.index');
        Route::get('/slider', SliderManager::class)->name('sliders.index');
        Route::get('/pengumuman', PengumumanManager::class)->name('pengumuman.index');
        Route::get('/dokumen', DokumenManager::class)->name('documents.index');
        Route::get('/pmb-gelombang', PmbGelombangManager::class)->name('pmb-gelombang.index');
        Route::get('/pengaturan', SettingsManager::class)->name('settings.index');
    });

    // --- GROUP 6: SYSTEM SETTINGS (Khusus Super Admin) ---
    Route::middleware(['role:super_admin'])->prefix('system')->name('system.')->group(function () {
        Route::get('/roles', \App\Livewire\System\RoleManager::class)->name('roles.index');
    });
});


/*
|--------------------------------------------------------------------------
| AUTHENTICATION ROUTES
|--------------------------------------------------------------------------
*/
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout')->middleware('auth');

require __DIR__ . '/auth.php';
