<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BeritaController;
use App\Http\Controllers\Api\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->name('api.v1.')->middleware('api.key')->group(function () {
    Route::get('/statistik', [BeritaController::class, 'statistik'])->name('statistik');
    Route::apiResource('berita', BeritaController::class)
    ->only(['index', 'show', 'store'])
    ->parameters(['berita' => 'berita']);
    Route::patch('/berita/{berita}/status', [BeritaController::class, 'ubahStatus'])->name('berita.status');
});

Route::prefix('v1')->name('api.v1.')->group(function () {
    // Publik: boleh diakses tanpa token. Dibatasi 5 percobaan per menit.
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login');

    // Wajib token: header Authorization: Bearer <token>
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/me', [AuthController::class, 'me'])->name('me');

        Route::get('/statistik', [BeritaController::class, 'statistik'])->name('statistik');
        Route::apiResource('berita', BeritaController::class)
            ->only(['index', 'show', 'store'])
            ->parameters(['berita' => 'berita']);
        Route::patch('/berita/{berita}/status', [BeritaController::class, 'ubahStatus'])->name('berita.status');
    });
});