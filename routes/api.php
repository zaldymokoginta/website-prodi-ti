<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BeritaController;

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