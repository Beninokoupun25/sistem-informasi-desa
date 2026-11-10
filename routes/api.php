<?php

use App\Http\Controllers\DesaController;
use App\Http\Controllers\FasilitasDesaController;
use App\Http\Controllers\MediaDesaController;
use App\Http\Controllers\PerangkatDesaController;
use App\Http\Controllers\ProfilDesaController;
use App\Http\Controllers\SejarahDesaController;
use App\Http\Controllers\StatistikDesaController;
use App\Http\Controllers\VisiMisiController;
use App\Http\Controllers\WilayahDesaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/desa', [DesaController::class, 'index']);
Route::get('/desa/{desa}', [DesaController::class, 'show']);

Route::prefix('desa/{desa}')->group(function () {
    Route::get('/profil', [ProfilDesaController::class, 'show']);

    Route::get('/sejarah', [SejarahDesaController::class, 'index']);
    Route::get('/sejarah/{sejarah}', [SejarahDesaController::class, 'show']);

    Route::get('/visi-misi', [VisiMisiController::class, 'index']);
    Route::get('/visi-misi/{visiMisi}', [VisiMisiController::class, 'show']);

    Route::get('/wilayah', [WilayahDesaController::class, 'index']);
    Route::get('/wilayah/{wilayah}', [WilayahDesaController::class, 'show']);

    Route::get('/perangkat', [PerangkatDesaController::class, 'index']);
    Route::get('/perangkat/{perangkat}', [PerangkatDesaController::class, 'show']);

    Route::get('/statistik', [StatistikDesaController::class, 'index']);
    Route::get('/statistik/{statistik}', [StatistikDesaController::class, 'show']);

    Route::get('/fasilitas', [FasilitasDesaController::class, 'index']);
    Route::get('/fasilitas/{fasilitas}', [FasilitasDesaController::class, 'show']);

    Route::get('/media', [MediaDesaController::class, 'index']);
    Route::get('/media/{media}', [MediaDesaController::class, 'show']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/desa', [DesaController::class, 'store']);
    Route::match(['put', 'patch'], '/desa/{desa}', [DesaController::class, 'update']);
    Route::delete('/desa/{desa}', [DesaController::class, 'destroy']);

    Route::prefix('desa/{desa}')->group(function () {
        Route::match(['post', 'put'], '/profil', [ProfilDesaController::class, 'update']);

        Route::post('/sejarah', [SejarahDesaController::class, 'store']);
        Route::match(['put', 'patch'], '/sejarah/{sejarah}', [SejarahDesaController::class, 'update']);
        Route::delete('/sejarah/{sejarah}', [SejarahDesaController::class, 'destroy']);

        Route::post('/visi-misi', [VisiMisiController::class, 'store']);
        Route::match(['put', 'patch'], '/visi-misi/{visiMisi}', [VisiMisiController::class, 'update']);
        Route::delete('/visi-misi/{visiMisi}', [VisiMisiController::class, 'destroy']);

        Route::post('/wilayah', [WilayahDesaController::class, 'store']);
        Route::match(['put', 'patch'], '/wilayah/{wilayah}', [WilayahDesaController::class, 'update']);
        Route::delete('/wilayah/{wilayah}', [WilayahDesaController::class, 'destroy']);

        Route::post('/perangkat', [PerangkatDesaController::class, 'store']);
        Route::match(['put', 'patch'], '/perangkat/{perangkat}', [PerangkatDesaController::class, 'update']);
        Route::delete('/perangkat/{perangkat}', [PerangkatDesaController::class, 'destroy']);

        Route::post('/statistik', [StatistikDesaController::class, 'store']);
        Route::match(['put', 'patch'], '/statistik/{statistik}', [StatistikDesaController::class, 'update']);
        Route::delete('/statistik/{statistik}', [StatistikDesaController::class, 'destroy']);

        Route::post('/fasilitas', [FasilitasDesaController::class, 'store']);
        Route::match(['put', 'patch'], '/fasilitas/{fasilitas}', [FasilitasDesaController::class, 'update']);
        Route::delete('/fasilitas/{fasilitas}', [FasilitasDesaController::class, 'destroy']);

        Route::post('/media', [MediaDesaController::class, 'store']);
        Route::match(['put', 'patch'], '/media/{media}', [MediaDesaController::class, 'update']);
        Route::delete('/media/{media}', [MediaDesaController::class, 'destroy']);
    });
});
