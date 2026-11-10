<?php

use App\Http\Controllers\Admin\FasilitasController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\ProfilController;
use App\Http\Controllers\Admin\SejarahController;
use App\Http\Controllers\Admin\StatistikController;
use App\Http\Controllers\Admin\VisiMisiController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::controller(PageController::class)->group(function () {
    Route::get('/', 'beranda')->name('beranda');
    Route::get('/selamat-datang', 'selamatDatang')->name('selamat-datang');
    Route::get('/sejarah', 'sejarah')->name('sejarah');
    Route::get('/visi-misi', 'visiMisi')->name('visi-misi');
    Route::get('/wilayah', 'wilayah')->name('wilayah');
    Route::get('/perangkat', 'perangkat')->name('perangkat');
    Route::get('/statistik', 'statistik')->name('statistik');
    Route::get('/fasilitas', 'fasilitas')->name('fasilitas');
    Route::get('/media', 'media')->name('media');

    Route::post('/pilih-desa', 'pilihDesa')->name('pilih-desa');
});

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::post('/pilih-desa', [App\Http\Controllers\Admin\DashboardController::class, 'pilihDesa'])->name('pilih-desa');

        Route::get('/profil', [ProfilController::class, 'edit'])->name('profil.edit');
        Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');

        Route::resource('/sejarah', SejarahController::class)->except('show');
        Route::resource('/visi-misi', VisiMisiController::class)->except(['show', 'create']);
        Route::resource('/statistik', StatistikController::class)->except('show');
        Route::resource('/fasilitas', FasilitasController::class)->except('show');

        Route::get('/media', [MediaController::class, 'index'])->name('media.index');
        Route::post('/media', [MediaController::class, 'store'])->name('media.store');
        Route::delete('/media/{media}', [MediaController::class, 'destroy'])->name('media.destroy');
    });
});
