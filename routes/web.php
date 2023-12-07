<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('layout.v_template');
});

Route::middleware(['CheckAuth'])->group(function () {
    Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
    Route::get('/barang/cari', [BarangController::class, 'cari'])->name('barang.cari');
    Route::get('/barang/add', [BarangController::class, 'create'])->name('barang.create');
    Route::post('/barang/insert', [BarangController::class, 'store'])->name('barang.store');
    Route::get('/barang/edit/{id}', [BarangController::class, 'edit'])->name('barang.edit');
    Route::post('/barang/update/{id}', [BarangController::class, 'update'])->name('barang.update');
    Route::post('/barang/delete/{id}', [BarangController::class, 'delete'])->name('barang.delete');
    Route::post('/barang/deleted', [BarangController::class, 'deleted'])->name('barang.deleted');
    Route::post('/barang/restore', [BarangController::class, 'restore'])->name('barang.restore');

    Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index');
    Route::get('/pelanggan/cari', [PelangganController::class, 'cari'])->name('pelanggan.cari');
    Route::get('/pelanggan/add', [PelangganController::class, 'create'])->name('pelanggan.create');
    Route::post('/pelanggan/insert', [PelangganController::class, 'store'])->name('pelanggan.store');
    Route::get('/pelanggan/edit/{id}', [PelangganController::class, 'edit'])->name('pelanggan.edit');
    Route::post('/pelanggan/update/{id}', [PelangganController::class, 'update'])->name('pelanggan.update');
    Route::post('/pelanggan/delete/{id}', [PelangganController::class, 'delete'])->name('pelanggan.delete');
    Route::post('/pelanggan/restore', [PelangganController::class, 'restore'])->name('pelanggan.restore');
    Route::post('/pelanggan/deleted', [PelangganController::class, 'deleted'])->name('pelanggan.deleted');

    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/cari', [TransaksiController::class, 'cari'])->name('transaksi.cari');
    Route::get('/transaksi/add', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi/insert', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::post('/transaksi/checkout', [TransaksiController::class, 'checkout'])->name('transaksi.checkout');
    Route::get('/transaksi/edit/{id}', [TransaksiController::class, 'edit'])->name('transaksi.edit');
    Route::post('/transaksi/update/{id}', [TransaksiController::class, 'update'])->name('transaksi.update');
    Route::post('/transaksi/delete/{id}', [TransaksiController::class, 'delete'])->name('transaksi.delete');
    Route::post('/transaksi/cancel/{id}', [TransaksiController::class, 'cancel'])->name('transaksi.cancel');
    Route::post('/transaksi/restore', [TransaksiController::class, 'restore'])->name('transaksi.restore');
    Route::post('/transaksi/deleted', [TransaksiController::class, 'deleted'])->name('transaksi.deleted');
    Route::post('/transaksi/canceled', [TransaksiController::class, 'canceled'])->name('transaksi.canceled');

    Route::get('/trash', [TransaksiController::class, 'trash'])->name('transaksi.trash');
    Route::post('/transaksi/deleteP/{id}', [TransaksiController::class, 'deleteP'])->name('transaksi.deleteP');
    Route::post('/transaksi/deleteB/{id}', [TransaksiController::class, 'deleteB'])->name('transaksi.deleteB');
    Route::post('/transaksi/restoreP/{id}', [TransaksiController::class, 'restoreP'])->name('transaksi.restoreP');
    Route::post('/transaksi/restoreB/{id}', [TransaksiController::class, 'restoreB'])->name('transaksi.restoreB');
});

Route::get('/', [LoginController::class, 'viewLogin'])->name('layout.v_login');
Route::post('/', [LoginController::class, 'auth'])->name('auth');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');