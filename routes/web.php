<?php

use App\Models\Berita;

use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\FokusController;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\EpaperController;
use App\Http\Controllers\StatisController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminFokusController;
use App\Http\Controllers\AdminIklanController;
use App\Http\Controllers\AdminMediaController;
use App\Http\Controllers\AdminBeritaController;
use App\Http\Controllers\AdminEpaperController;
use App\Http\Controllers\AdminGaleriController;
use App\Http\Controllers\AdminProfilController;
use App\Http\Controllers\AdminStatisController;
use App\Http\Controllers\AdminLaporanController;
use App\Http\Controllers\AdminNetworkController;
use App\Http\Controllers\AdminSettingController;
use App\Http\Controllers\AdminKategoriController;
use App\Http\Controllers\AdminStrukturController;
use App\Http\Controllers\AdminWartawanController;
use App\Http\Controllers\AdminListTayangController;
use App\Http\Controllers\AdminNetworkAccessController;

//Frontend Routes
Route::get('/', [BeritaController::class, 'home']);
Route::get('/berita/{berita}', [BeritaController::class, 'detail']);
Route::get('/kategori/{kategori}', [KategoriController::class, 'kategori']);
Route::get('/fokus/{fokus}', [FokusController::class, 'fokus']);
Route::get('/search', [BeritaController::class, 'search']);
Route::get('/statis/{statis}', [StatisController::class, 'index']);
Route::get('/epaper/{epaper}', [EpaperController::class, 'index']);
Route::get('/sitemap', [SitemapController::class, 'index']);
Route::get('/sitemap/{kategori}', [SitemapController::class, 'sitemapKanal']);
Route::get('/feedberita', [SitemapController::class, 'feed']);
Route::get('/feedberita/{kategori}', [SitemapController::class, 'feedKanal']);
Route::get('/indeks', [BeritaController::class, 'indeks']);
Route::post('/indeks', [BeritaController::class, 'indeksFilter']);

//Login Routes
// Route::get('/cmslogin', [LoginController::class, 'index'])->name('login')->middleware('guest');
// Route::post('/cmslogin', [LoginController::class, 'authenticate']);
// Route::post('/cmslogout', [LoginController::class, 'logout']);

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', ])->group(function () {

    Route::get('admin/dashboard', [DashboardController::class, 'index'])->name("home");
    Route::get('admin/list-tayang', [AdminListTayangController::class, 'index']);
    Route::get('admin/profile', [AdminProfilController::class, 'index']);
    Route::get('admin/media', [AdminMediaController::class, 'index']);
    Route::resource('admin/berita', AdminBeritaController::class);
    Route::resource('admin/galeri', AdminGaleriController::class)->except('show');
    Route::resource('admin/epaper', AdminEpaperController::class)->except('show');
    Route::post('admin/berita/upload_image', [AdminBeritaController::class, 'uploadImage'])->name('upload'); //CKEditor Upload

    Route::get('admin/id-card/{user}', [AdminUserController::class, 'pdf']);
    Route::put('admin/profile/{user}', [AdminProfilController::class, 'update']);
    
    Route::middleware(['admin'])->group(function () {
        Route::get('admin/laporan', [AdminLaporanController::class, 'index']);
        Route::post('admin/laporan', [AdminLaporanController::class, 'show']);
        Route::get('admin/laporan_wartawan', [AdminLaporanController::class, 'LaporanWartawan']);
        Route::post('admin/laporan_wartawan', [AdminLaporanController::class, 'LaporanWartawanTanggal']);
        Route::post('admin/laporan/downloadexcel', [AdminLaporanController::class, 'downloadexcel']);
        
        Route::resource('admin/kategori', AdminKategoriController::class);
        Route::resource('admin/fokus', AdminFokusController::class);
        Route::resource('admin/halaman', AdminStatisController::class)->except('show');
        Route::resource('admin/wartawan', AdminWartawanController::class);
        Route::resource('admin/iklan', AdminIklanController::class);
        Route::resource('admin/pengaturan', AdminSettingController::class)->except('show');

        Route::get('admin/user/check', [AdminUserController::class, 'checkUnique']);
        Route::resource('admin/user', AdminUserController::class);
    });

    Route::middleware(['owner'])->group(function () {
        Route::get('/setclient', [AdminNetworkController::class, 'setnetwork'])->name('setnetwork');
        Route::get('admin/network/check',[ AdminNetworkController::class, 'checkUnique']);
        Route::resource('admin/network', AdminNetworkController::class);
        Route::get('admin/network_access/check',[AdminNetworkAccessController::class, 'checkUnique']);
        Route::resource('admin/network_access', AdminNetworkAccessController::class);
        Route::get('admin/struktur/check',[AdminStrukturController::class, 'checkUnique']);
        Route::resource('admin/struktur', AdminStrukturController::class);

        Route::get('optimize', function () {
            Artisan::call('optimize:clear');
            Artisan::call('optimize');
            return 'Application Optimized';
        });

        // STORAGE LINK
        Route::get('storagelink', function () {

            Artisan::call('storage:link');
            return 'Storage Linked';
        }); 
    });
});
