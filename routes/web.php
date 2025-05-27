<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');

   
Route::middleware(RoleMiddleware::class . ':admin')->group(function () {
    // user
    Route::get('/datauser', [UserController::class,'index'])->name('datauser.index');
    Route::post('/datauser', [UserController::class,'store'])->name('datauser.store');
    // Route::get('/datauser/{user}/edit', [UserController::class,'edit'])->name('datauser.edit');
    Route::put('/datauser/{user}', [UserController::class,'update'])->name('datauser.update');
    Route::delete('/datauser/{user}', [UserController::class,'destroy'])->name('datauser.destroy');
    // barang
    Route::get('/databarang', [BarangController::class,'index'])->name('databarang.index');
    Route::post('/databarang', [BarangController::class,'store'])->name('databarang.store');
    // Route::get('/databarang/{barang}/edit', [BarangController::class,'edit'])->name('databarang.edit');
    Route::put('/databarang/{barang}', [BarangController::class,'update'])->name('databarang.update');
    Route::delete('/databarang/{barang}', [BarangController::class,'destroy'])->name('databarang.destroy');


    // transaksibarang
    Route::get('/transaksibarang', [TransaksiController::class,'index'])->name('transaksibarang.index');
    Route::get('/transaksi/rekap/pdf', [TransaksiController::class, 'cetakPDF'])->name('transaksi.rekap');
    Route::post('/transaksibarang', [TransaksiController::class,'store'])->name('transaksibarang.store');
    Route::put('/transaksibarang/{transaksibarang}', [TransaksiController::class,'update'])->name('transaksibarang.update');
    Route::delete('/transaksibarang/{transaksibarang}', [TransaksiController::class,'destroy'])->name('transaksibarang.destroy');
});

    Route::middleware(RoleMiddleware::class . ':pemilik')->get('/pemilik', function () {
        return 'Halaman pemilik';
    });

    Route::middleware('role:admin,pemilik')->get('/bersama', function () {
        return 'Halaman admin dan pemilik';
    });
});

require __DIR__.'/auth.php';
