<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiskonController;
use App\Http\Controllers\LogStokController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.proses');
});

Route::middleware('auth')->group(function () {
    Route::middleware('role:administrator')->group(function () {
        Route::middleware('status:aktif')->group(function () {
            // Dashboard
            Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

            // Produk
            Route::controller(ProdukController::class)->group(function () {
                Route::get('/admin/produk', 'index')->name('admin.produk');
                Route::get('/admin/produk/create', 'create')->name('admin.produk.create');
                Route::post('/admin/produk/create/proses', 'store')->name('admin.produk.store');
                Route::get('/admin/produk/edit/{id}', 'edit')->name('admin.produk.edit');
                Route::put('/admin/produk/edit/{id}/proses', 'update')->name('admin.produk.update');
                Route::get('/admin/produk/edit/{id}/{status}', 'destroy')->name('admin.produk.status');
                Route::get('/admin/produk/harga/{id}', 'getHarga');
                Route::get('/admin/produk/stok/{id}', 'getStok');
                Route::get('/admin/produk/diskon/{id}', 'getDiskon');
            });

            // Member
            Route::controller(MemberController::class)->group(function () {
                Route::get('/admin/member', 'index')->name('admin.member');
                Route::get('/admin/member/create', 'create')->name('admin.member.create');
                Route::post('/admin/member/create/proses', 'store')->name('admin.member.store');
                Route::get('/admin/member/edit/{id}', 'edit')->name('admin.member.edit');
                Route::put('/admin/member/edit/{id}/proses', 'update')->name('admin.member.update');
                Route::get('/admin/member/edit/{id}/{status}', 'destroy')->name('admin.member.status');
            });

            // Diskon
            Route::controller(DiskonController::class)->group(function () {
                Route::get('/admin/diskon', 'index')->name('admin.diskon');
                Route::get('/admin/diskon/create', 'create')->name('admin.diskon.create');
                Route::post('/admin/diskon/create/proses', 'store')->name('admin.diskon.store');
                Route::get('/admin/diskon/edit/{id}', 'edit')->name('admin.diskon.edit');
                Route::put('/admin/diskon/edit/{id}/proses', 'update')->name('admin.diskon.update');
                Route::get('/admin/diskon/delete/{id}', 'destroy')->name('admin.diskon.delete');
            });

            // Petugas
            Route::controller(PetugasController::class)->group(function () {
                Route::get('/admin/petugas', 'index')->name('admin.petugas');
                Route::get('/admin/petugas/create', 'create')->name('admin.petugas.create');
                Route::post('/admin/petugas/create/proses', 'store')->name('admin.petugas.store');
                Route::get('/admin/petugas/edit/{id}', 'edit')->name('admin.petugas.edit');
                Route::put('/admin/petugas/edit/{id}/proses', 'update')->name('admin.petugas.update');
                Route::get('/admin/petugas/status/ {id}/{status}', 'destroy')->name('admin.petugas.status');
            });

            // Transaksi
            Route::controller(PenjualanController::class)->group(function () {
                Route::get('/admin/transaksi', 'index')->name('admin.transaksi');
                Route::get('/admin/transaksi/struk/{id}', 'struk')->name('admin.transaksi.struk');
            });

            // Laporan
            Route::get('/admin/laporan', [LogStokController::class, 'index'])->name('admin.laporan');

            // Profil
            Route::get('/admin/profil', [ProfilController::class, 'index'])->name('admin.profil');
            Route::put('/admin/profil/update', [ProfilController::class, 'update'])->name('admin.profil.update');
        });
    });
    Route::middleware('role:petugas')->group(function () {
        Route::middleware('status:aktif')->group(function () {
            // Dashboard
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('petugas.dashboard');

            // Produk
            Route::controller(ProdukController::class)->group(function () {
                Route::get('/produk', 'index')->name('petugas.produk');
                Route::get('/produk/create', 'create')->name('petugas.produk.create');
                Route::post('/produk/create/proses', 'store')->name('petugas.produk.store');
                Route::get('/produk/edit/{id}', 'edit')->name('petugas.produk.edit');
                Route::put('/produk/edit/{id}/proses', 'update')->name('petugas.produk.update');
                Route::get('/produk/harga/{id}', 'getHarga');
                Route::get('/produk/stok/{id}', 'getStok');
                Route::get('/produk/diskon/{id}', 'getDiskon');
            });

            // Member
            Route::controller(MemberController::class)->group(function () {
                Route::get('/member', 'index')->name('petugas.member');
                Route::get('/member/create', 'create')->name('petugas.member.create');
                Route::post('/member/create/proses', 'store')->name('petugas.member.store');
                Route::get('/member/edit/{id}', 'edit')->name('petugas.member.edit');
                Route::put('/member/edit/{id}/proses', 'update')->name('petugas.member.update');
            });

            // Transaksi
            Route::controller(PenjualanController::class)->group(function () {
                Route::get('/transaksi', 'index')->name('petugas.transaksi');
                Route::get('/transaksi/proses', 'transaksi')->name('petugas.transaksi.proses');
                Route::post('/transaksi/proses/tambah/keranjang', 'tambahKeranjang')->name('petugas.transaksi.tambah.keranjang');
                Route::get('/transaksi/proses/hapus/keranjang/{id}', 'hapusKeranjang')->name('petugas.transaksi.hapus.keranjang');
                Route::put('/transaski/proses/update/{id}', 'proses')->name('petugas.transaksi.proses.update');
                Route::get('/transaksi/struk/{id}', 'struk')->name('petugas.transaksi.struk');
                Route::put('/transaksi/kurangi/quantity/{id}', 'kurangi_quantity')->name('petugas.transaksi.quantity');
            });

            // Diskon
            Route::get('/diskon', [DiskonController::class, 'getDiskon']);

            // Laporan
            Route::get('/laporan', [LogStokController::class, 'index'])->name('petugas.laporan');

            // Profil
            Route::get('/profil', [ProfilController::class, 'index'])->name('petugas.profil');
            Route::put('/profil/update', [ProfilController::class, 'update'])->name('petugas.profil.update');
        });
    });

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
