<?php

use App\Http\Controllers\BeritaController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\StatisController;
use App\Http\Controllers\EpaperController;
use App\Http\Controllers\SitemapController;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminBeritaController;
use App\Http\Controllers\AdminGaleriController;
use App\Http\Controllers\AdminKategoriController;
use App\Http\Controllers\AdminListTayangController;
use App\Http\Controllers\AdminStatisController;
use App\Http\Controllers\AdminLaporanController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminWartawanController;
use App\Http\Controllers\AdminIklanController;
use App\Http\Controllers\AdminSettingController;
use App\Http\Controllers\AdminEpaperController;
use App\Http\Controllers\AdminNetworkController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('throttle:60,1')->group(function () {

    //Frontend Routes
    Route::get('/', [BeritaController::class, 'home'])->name('home');
    Route::get('/berita/{berita}', [BeritaController::class, 'detail']);
    Route::get('/kategori/{kategori}', [KategoriController::class, 'kategori']);
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
    Route::get('/cmslogin', [LoginController::class, 'index'])->name('login')->middleware('guest');
    Route::post('/cmslogin', [LoginController::class, 'authenticate']);
    Route::post('/cmslogout', [LoginController::class, 'logout']);

    //Admin Routes
    Route::middleware(['auth'])->group(function () {
        Route::get('admin/dashboard', [DashboardController::class, 'index']);
        Route::get('admin/list-tayang', [AdminListTayangController::class, 'index']);
        Route::resource('admin/berita', AdminBeritaController::class)->middleware('optimizeImages'); // With Spatie Image Optimizer (Need Jpegotim & Optipng)
        Route::resource('admin/galeri', AdminGaleriController::class)->except('show');
        Route::resource('admin/kategori', AdminKategoriController::class)->except('show');
        Route::resource('admin/epaper', AdminEpaperController::class)->except('show');
        Route::post('admin/berita/upload_image', [AdminBeritaController::class, 'uploadImage'])->name('upload'); //CKEditor Upload
    });

    Route::middleware(['superadmin'])->group(function () {
        Route::get('admin/laporan', [AdminLaporanController::class, 'index']);
        Route::post('admin/laporan', [AdminLaporanController::class, 'show']);
        Route::get('admin/laporan_wartawan', [AdminLaporanController::class, 'LaporanWartawan']);
        Route::post('admin/laporan_wartawan', [AdminLaporanController::class, 'LaporanWartawanTanggal']);
        Route::post('admin/laporan/downloadexcel', [AdminLaporanController::class, 'downloadexcel']);
        Route::resource('admin/halaman', AdminStatisController::class)->except('show'); 
        Route::resource('admin/user', AdminUserController::class)->except('show');
        Route::resource('admin/wartawan', AdminWartawanController::class)->except('show');
        Route::resource('admin/iklan', AdminIklanController::class)->except('show');
        Route::resource('admin/network', AdminNetworkController::class)->except('show');
        Route::resource('admin/pengaturan', AdminSettingController::class)->except('show');
    });

});