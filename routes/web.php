<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\UserController;

Route::middleware(['guest'])->group(function () {
    Route::get('/', [LoginController::class, 'viewLogin'])->name('home');
    Route::post('/', [LoginController::class, 'login'])->name('login');
});

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/penjualan/nota/{id}/{jumlah}', [BarangKeluarController::class, 'nota'])->name('nota');
    
    Route::resource('barang', BarangController::class);
    Route::resource('pembelian', PembelianController::class);
    Route::get('download', [PembelianController::class, 'download'])->name('download');
    Route::resource('user', UserController::class);
});