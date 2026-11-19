<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TarifController;
use App\Http\Controllers\Admin\AreaParkirController;
use App\Http\Controllers\Admin\KendaraanController;
use App\Http\Controllers\Admin\LogAktivitasController;
use App\Http\Controllers\Petugas\TransaksiController;
use App\Http\Controllers\Owner\RekapController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showlogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function() {
    Route::get('/dashboard', fn () => view('admin.dashboard'))->name('dashboard');
    Route::resource('/user', UserController::class);
    Route::resource('/tarif', TarifController::class);
    Route::resource('/area', AreaParkirController::class);
    Route::resource('/kendaraan', KendaraanController::class);
    Route::get('/log-aktivitas', [LogAktivitasController::class, 'index'])->name('log.index');
});

Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () { 
    Route::get('/get-tarif/{id}', [TransaksiController::class, 'getTarif'])->name('transaksi.getTarif');
    Route::get('/dashboard', fn () => view('petugas.dashboard'))->name('dashboard'); 
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index'); 
    Route::get('/transaksi/masuk', [TransaksiController::class, 'formMasuk'])->name('transaksi.formMasuk'); 
    Route::post('/transaksi/masuk', [TransaksiController::class, 'prosesMasuk'])->name('transaksi.prosesMasuk'); 
    Route::get('/transaksi/keluar/{id}', [TransaksiController::class, 'formKeluar'])->name('transaksi.formKeluar'); 
    Route::post('/transaksi/keluar/{id}', [TransaksiController::class, 'prosesKeluar'])->name('transaksi.prosesKeluar'); 
    Route::get('/struk/{id}', [TransaksiController::class, 'cetakStruk'])->name('transaksi.struk');
}); 

Route::middleware(['auth', 'role:owner'])->prefix('owner')->name('owner.')->group(function 
() { 
    Route::get('/dashboard', fn () => view('owner.dashboard'))->name('dashboard'); 
    Route::get('/rekap', [RekapController::class, 'index'])->name('rekap.index'); 
});