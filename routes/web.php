<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\CatatanKondisiBarangController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\UserController;
Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');

     // barang
    Route::get('/databarang', [BarangController::class,'index'])->name('databarang.index');

    Route::middleware([RoleMiddleware::class . ':admin,pengurus' ])->group(function () {
    Route::get('/cetakbarang', [BarangController::class, 'cetakPDF']);
 
    // tambahkan rute lain di sini
});

     
   
Route::middleware(RoleMiddleware::class . ':admin')->group(function () {
    // user
    Route::get('/datauser', [UserController::class,'index'])->name('datauser.index');
    Route::post('/datauser', [UserController::class,'store'])->name('datauser.store');
    // Route::get('/datauser/{user}/edit', [UserController::class,'edit'])->name('datauser.edit');
    Route::put('/datauser/{user}', [UserController::class,'update'])->name('datauser.update');
    Route::delete('/datauser/{user}', [UserController::class,'destroy'])->name('datauser.destroy');
   
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

    Route::middleware(RoleMiddleware::class . ':pengurus')->group(function () {
        Route::get('/catatankondisibarang', [CatatanKondisiBarangController::class,'index'])->name('catatankondisibarang.index');
        Route::post('/catatankondisibarang', [CatatanKondisiBarangController::class,'store'])->name('catatan.store');
        // destroy
        Route::delete('/catatankondisibarang/{id}', [CatatanKondisiBarangController::class,'destroy'])->name('catatan.destroy');

        // peminjaman
        Route::get('/verifikasipeminjamanbarang', [PeminjamanController::class,'verifikasipeminjamanlist'])->name('verifikasipeminjamanbarang.index');
        Route::put('/peminjaman/updatestatus/{id}', [PeminjamanController::class, 'updateStatus'])->name('peminjaman.updatestatus');

        // konfirmasi pengembalian barang
         Route::get('/konfirmasipengembalianbarang', [PengembalianController::class, 'index'])->name('konfirmasipengembalianbarang.index');
         Route::put('/pengembalian/update/{id}', [PengembalianController::class, 'update'])->name('pengembalian.updatestatus');
    });

     Route::middleware(RoleMiddleware::class . ':peminjam')->group(function () {
        Route::get('/ajuanpeminjamanbarang', [PeminjamanController::class,'index'])->name('peminjaman.index');
        Route::post('/ajuanpeminjamanbarang', [PeminjamanController::class,'store'])->name('peminjamanbarang.store');
        Route::delete('/ajuanpeminjamanbarang/{id}', [PeminjamanController::class,'destroy'])->name('peminjamanbarang.destroy');
          Route::get('/ajuanpeminjamanbarang/rekap/pdf', [PeminjamanController::class, 'cetakPDF'])->name('peminjaman.rekap');
        //   cetak bukti verifikasi
        Route::get('/buktiverifikasi/{id}', [PeminjamanController::class, 'cetakVerifikasi'])->name('peminjaman.cetak');

        //   riwayatpeminjaman
        Route::get('riwayatpeminjamanbarang', [PeminjamanController::class, 'riwayatPeminjaman'])->name('riwayatpeminjamanbarang.index');

        // pengembalian peminjaman
        Route::post('/pengembalianpeminjamanbarang', [PengembalianController::class, 'store'])->name('pengembalian.store');
       

    });

    Route::middleware(RoleMiddleware::class . ':pengurus,peminjam')->group(function () {
         //   batal peminjaman
        Route::put('/peminjaman/batalkan/{id}', [PeminjamanController::class, 'batalkan'])->name('peminjaman.batalkan');
        Route::delete('/peminjaman/{id}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
    });

    Route::middleware('role:admin,pemilik')->get('/bersama', function () {
        return 'Halaman admin dan pemilik';
    });
});

require __DIR__.'/auth.php';
