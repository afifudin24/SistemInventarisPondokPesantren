<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('admin.dashboard.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::middleware(RoleMiddleware::class . ':admin')->get('/admin', function () {
        return 'Halaman admin';
    });

    Route::middleware(RoleMiddleware::class . ':pemilik')->get('/pemilik', function () {
        return 'Halaman pemilik';
    });

    Route::middleware('role:admin,pemilik')->get('/bersama', function () {
        return 'Halaman admin dan pemilik';
    });
});

require __DIR__.'/auth.php';
