<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\Kelompok1Controller;
use App\Http\Controllers\Kelompok2Controller;
use App\Http\Controllers\Kelompok3Controller;
use App\Http\Controllers\Kelompok5Controller;
use App\Http\Controllers\Kelompok6Controller;
use App\Http\Controllers\Kelompok7Controller;
use App\Http\Controllers\Kelompok8Controller;
use App\Http\Controllers\Kelompok9Controller;
use Illuminate\Support\Facades\Route;

// Welcome page

Route::get('/', function () {
    return view('welcome');
});


// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Additional views
Route::get('/kontak', function () {
    return view('kontak');
})->middleware(['auth', 'verified'])->name('kontak');

Route::get('/menu', function () {
    return view('menu');
})->middleware(['auth', 'verified'])->name('menu');

// Barang routes
Route::resource('barang', BarangController::class)->middleware('auth');
Route::get('/makanan', [BarangController::class, 'showMakanan'])->name('makanan');
Route::get('/minuman', [BarangController::class, 'showMinuman'])->name('minuman');

// Pemesanan routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/lihat-pesanan', [PemesananController::class, 'index'])->name('pesanan.index');
    Route::post('/makanan/store', [PemesananController::class, 'store'])->name('pesan.makanan2.store');
    Route::delete('/pesanan/{id}', [PemesananController::class, 'destroy'])->name('pesanan.destroy');
    Route::post('/pesanan/{id}/approve', [PemesananController::class, 'approve'])->name('pesanan.approve');
});

// Order routes

// Profile management
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/lihat-pesanan', [PemesananController::class, 'index'])->name('pesanan.index');
    Route::post('/makanan', [PemesananController::class, 'store'])->name('pesan.makanan.store');
    Route::post('/minuman', [PemesananController::class, 'store'])->name('pesan.minuman.store');
    Route::delete('/pesanan/{id}', [PemesananController::class, 'destroy'])->name('pesanan.destroy');
    Route::post('/pesanan/{id}/aprove', [PemesananController::class, 'approve'])->name('pesanan.aprove');


});

// Route untuk halaman web

Route::get('/kelompok1', [Kelompok1Controller::class, 'index'])->name('kelompok1.index');
Route::post('/kelompok1', [Kelompok1Controller::class, 'store'])->name('kelompok1.store');
Route::put('/kelompok1/{id}', [Kelompok1Controller::class, 'update'])->name('kelompok1.update');
Route::delete('/kelompok1/{id}', [Kelompok1Controller::class, 'destroy'])->name('kelompok1.destroy');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/kelompok5', [Kelompok5Controller::class, 'index'])->name('kelompok5.index');
    Route::get('/kelompok5/create', [Kelompok5Controller::class, 'create'])->name('kelompok5.create');
    Route::post('/kelompok5', [Kelompok5Controller::class, 'store'])->name('kelompok5.store');
    Route::get('/kelompok5/{id}/edit', [Kelompok5Controller::class, 'edit'])->name('kelompok5.edit');
    Route::put('/kelompok5/{id}', [Kelompok5Controller::class, 'update'])->name('kelompok5.update');
    Route::delete('/kelompok5/{id}', [Kelompok5Controller::class, 'destroy'])->name('kelompok5.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/kelompok6', [Kelompok6Controller::class, 'index'])->name('kelompok6.index');
    Route::post('/kelompok6', [Kelompok6Controller::class, 'store'])->name('kelompok6.store');
    Route::patch('/kelompok6/{id}', [Kelompok6Controller::class, 'update'])->name('kelompok6.update');
    Route::delete('/kelompok6/{id}', [Kelompok6Controller::class, 'destroy'])->name('kelompok6.destroy');
});

Route::get('/kelompok7', [Kelompok7Controller::class, 'index'])->name('kelompok7.index');
Route::post('/kelompok7', [Kelompok7Controller::class, 'store'])->name('kelompok7.store');
Route::put('/kelompok7/{id}', [Kelompok7Controller::class, 'update'])->name('kelompok7.update');
Route::delete('/kelompok7/{id}', [Kelompok7Controller::class, 'destroy'])->name('kelompok7.destroy');

Route::get('/kelompok8', [Kelompok8Controller::class, 'index'])->name('kelompok8.index');
Route::get('/kelompok8/edit/{id}', [Kelompok8Controller::class, 'show'])->name('kelompok8.edit');
Route::post('/kelompok8/store', [Kelompok8Controller::class, 'store'])->name('kelompok8.store');
Route::put('/kelompok8/update/{id}', [Kelompok8Controller::class, 'update'])->name('kelompok8.update');
Route::delete('/kelompok8/delete/{id}', [Kelompok8Controller::class, 'destroy'])->name('kelompok8.delete');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/kelompok9', [Kelompok9Controller::class, 'index'])->name('kelompok9.index');
    Route::post('/kelompok9', [Kelompok9Controller::class, 'store'])->name('kelompok9.store');
    Route::delete('/kelompok9/{game}/{id}', [Kelompok9Controller::class, 'destroy'])->name('kelompok9.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/kelompok2', [Kelompok2Controller::class, 'index'])->name('kelompok2.index');
    Route::post('/kelompok2', [Kelompok2Controller::class, 'store'])->name('kelompok2.store');
    Route::put('/kelompok2/{id}', [Kelompok2Controller::class, 'update'])->name('kelompok2.update');
    Route::delete('/kelompok2/{id}', [Kelompok2Controller::class, 'destroy'])->name('kelompok2.destroy');
});
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/kelompok3', [Kelompok3Controller::class, 'index'])->name('kelompok3.index');
    Route::post('/kelompok3', [Kelompok3Controller::class, 'store'])->name('kelompok3.store');
    Route::put('/kelompok3/{id}', [Kelompok3Controller::class, 'update'])->name('kelompok3.update');
    Route::delete('/kelompok3/{id}', [Kelompok3Controller::class, 'destroy'])->name('kelompok3.destroy');
});

Route::get('/api/kelompok5', [Kelompok5Controller::class, 'apiList']);
Route::get('/api/kelompok5/{id}', [Kelompok5Controller::class, 'apiDetail']);

// Authentication routes
require __DIR__.'/auth.php';
