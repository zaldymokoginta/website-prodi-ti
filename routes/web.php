<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MataKuliahController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BerandaController::class, 'index'])->name('beranda');

Route::view('/profil', 'profil')->name('profil');
Route::view('/kontak', 'kontak')->name('kontak');

Route::get('/dosen', [DosenController::class, 'index'])->name('dosen.index');
Route::get('/mata-kuliah', [MataKuliahController::class, 'index'])->name('matkul.index');

Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{berita:slug}', [BeritaController::class, 'show'])->name('berita.show');