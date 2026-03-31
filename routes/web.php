<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OwnerController;

/* WELCOME */
Route::get('/', function () {
    return view('welcome');
});

/* LOGIN */
Route::get('/login', [AuthController::class,'showLogin']);
Route::post('/login', [AuthController::class,'login']);
Route::get('/logout', [AuthController::class,'logout']);

/* ROLE PAGE */
Route::get('/inputkasir', [KasirController::class,'index']);
Route::get('/verifadmin', [AdminController::class,'index']);
Route::get('/dashboardowner', [OwnerController::class,'index']);

// KASIR (Transaksi Penjualan) 
Route::get('/kasir', [KasirController::class,'index']);
Route::post('/kasir/tambah', [KasirController::class,'tambahBarang']);
Route::post('/kasir/metode', [KasirController::class,'metode']);
Route::post('/kasir/pin', [KasirController::class,'inputPin']);
Route::get('/kasir/struk', [KasirController::class,'struk']);
Route::post('/kasir/hapus/{index}', [KasirController::class,'hapusBarang']);
Route::get('/kasir/metode', function () {
    return redirect('/kasir');
});



//KASIR REKAP HARIAN
Route::get('/kasir/rekap', [KasirController::class,'rekapHarian']);

// Sprint 4: Pengiriman Laporan
Route::post('/kasir/kirim-laporan', [KasirController::class, 'kirimLaporan']);

Route::get('/kasir/detail-transaksi/{id}', [KasirController::class, 'detailTransaksi']);
Route::post('/kasir/kirim-laporan', [KasirController::class, 'kirimLaporan']);

// Sprint 5: Verifikasi Laporan
Route::get('/verifadmin', [AdminController::class, 'index']);
// Pastikan method-nya POST dan parameternya {id} sesuai dengan form di blade
Route::post('/admin/verifikasi/{id}', [AdminController::class, 'verifikasi']);