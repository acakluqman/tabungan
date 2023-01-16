<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TahunController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\TabunganController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\KelasSiswaController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\JenisTagihanController;

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
    return redirect('home');
});

Auth::routes(['register' => false]);

Route::group(['middleware' => ['auth', 'permission']], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    /**
     * Tabungan Routes
     */
    Route::group(['prefix' => 'tabungan'], function () {
        Route::get('/', [TabunganController::class, 'index'])->name('tabungan.index');
        Route::get('/create', [TabunganController::class, 'create'])->name('tabungan.create');
        Route::post('/store', [TabunganController::class, 'store'])->name('tabungan.store');
        Route::get('/{id}/show', [TabunganController::class, 'show'])->name('tabungan.show');
        Route::get('/{id}/edit', [TabunganController::class, 'edit'])->name('tabungan.edit');
        Route::patch('/update', [TabunganController::class, 'update'])->name('tabungan.update');
        Route::delete('/delete', [TabunganController::class, 'destroy'])->name('tabungan.destroy');

        Route::post('/saldo', [TabunganController::class, 'saldo'])->name('tabungan.saldo');
        Route::get('/siswa', [TabunganController::class, 'tabunganSiswa'])->name('tabungan.siswa');
    });

    /**
     * Tahun Ajaran Routes
     */
    Route::group(['prefix' => 'tahun'], function () {
        Route::get('/', [TahunController::class, 'index'])->name('tahun.index');
        Route::get('/create', [TahunController::class, 'create'])->name('tahun.create');
        Route::post('/store', [TahunController::class, 'store'])->name('tahun.store');
        Route::post('/show', [TahunController::class, 'show'])->name('tahun.show');
        Route::patch('/update', [TahunController::class, 'update'])->name('tahun.update');
        Route::delete('/delete', [TahunController::class, 'destroy'])->name('tahun.destroy');
    });

    /**
     * Tagihan Routes
     */
    Route::group(['prefix' => 'tagihan'], function () {
        Route::get('/', [TagihanController::class, 'index'])->name('tagihan.index');
        Route::get('/create', [TagihanController::class, 'create'])->name('tagihan.create');
        Route::post('/store', [TagihanController::class, 'store'])->name('tagihan.store');
        Route::get('/{tagihan}/show', [TagihanController::class, 'show'])->name('tagihan.show');
        Route::get('/{tagihan}/edit', [TagihanController::class, 'edit'])->name('tagihan.edit');
        Route::patch('/{tagihan}/update', [TagihanController::class, 'update'])->name('tagihan.update');
        Route::delete('/{tagihan}/delete', [TagihanController::class, 'destroy'])->name('tagihan.destroy');

        Route::get('/siswa', [TagihanController::class, 'tagihanSiswa'])->name('tagihan.siswa');
    });

    /**
     * Jenis Tagihan Routes
     */
    Route::group(['prefix' => 'jenis-tagihan'], function () {
        Route::get('/', [JenisTagihanController::class, 'index'])->name('jenis-tagihan.index');
        Route::get('/create', [JenisTagihanController::class, 'create'])->name('jenis-tagihan.create');
        Route::post('/store', [JenisTagihanController::class, 'store'])->name('jenis-tagihan.store');
        Route::get('/{id}/show', [JenisTagihanController::class, 'show'])->name('jenis-tagihan.show');
        Route::get('/{id}/edit', [JenisTagihanController::class, 'edit'])->name('jenis-tagihan.edit');
        Route::patch('/{id}/update', [JenisTagihanController::class, 'update'])->name('jenis-tagihan.update');
        Route::delete('/delete', [JenisTagihanController::class, 'destroy'])->name('jenis-tagihan.destroy');
    });

    /**
     * Kelas Routes
     */
    Route::group(['prefix' => 'kelas'], function () {
        Route::get('/', [KelasController::class, 'index'])->name('kelas.index');
        Route::get('/create', [KelasController::class, 'create'])->name('kelas.create');
        Route::post('/store', [KelasController::class, 'store'])->name('kelas.store');
        Route::post('/show', [KelasController::class, 'show'])->name('kelas.show');
        Route::get('/edit', [KelasController::class, 'edit'])->name('kelas.edit');
        Route::patch('/update', [KelasController::class, 'update'])->name('kelas.update');
        Route::delete('/delete', [KelasController::class, 'destroy'])->name('kelas.destroy');

        Route::get('/siswa', [KelasSiswaController::class, 'index'])->name('kelas-siswa.index');
        Route::get('/siswa/create', [KelasSiswaController::class, 'create'])->name('kelas-siswa.create');
        Route::post('/siswa/store', [KelasSiswaController::class, 'store'])->name('kelas-siswa.store');
        Route::delete('/siswa/delete', [KelasSiswaController::class, 'destroy'])->name('kelas-siswa.destroy');
    });

    /**
     * Siswa Routes
     */
    Route::group(['prefix' => 'siswa'], function () {
        Route::get('/', [SiswaController::class, 'index'])->name('siswa.index');
        Route::get('/create', [SiswaController::class, 'create'])->name('siswa.create');
        Route::post('/store', [SiswaController::class, 'store'])->name('siswa.store');
        Route::get('/{id}/show', [SiswaController::class, 'show'])->name('siswa.show');
        Route::get('/{id}/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
        Route::patch('/{id}/update', [SiswaController::class, 'update'])->name('siswa.update');
        Route::delete('/delete', [SiswaController::class, 'destroy'])->name('siswa.destroy');
    });

    /**
     * User Routes
     */
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [UsersController::class, 'index'])->name('users.index');
        Route::get('/create', [UsersController::class, 'create'])->name('users.create');
        Route::post('/store', [UsersController::class, 'store'])->name('users.store');
        Route::get('/{user}/show', [UsersController::class, 'show'])->name('users.show');
        Route::get('/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
        Route::patch('/{id}/update', [UsersController::class, 'update'])->name('users.update');
        Route::delete('/delete', [UsersController::class, 'destroy'])->name('users.destroy');
    });

    Route::group(['prefix' => 'transaksi'], function () {
        Route::get('/', [TransaksiController::class, 'index'])->name('transaksi.index');
        Route::get('/create', [TransaksiController::class, 'create'])->name('transaksi.create');
        Route::post('/store', [TransaksiController::class, 'store'])->name('transaksi.store');
        Route::get('/{id}/show', [TransaksiController::class, 'show'])->name('transaksi.show');
        Route::get('/{id}/edit', [TransaksiController::class, 'edit'])->name('transaksi.edit');
        Route::patch('/{id}/update', [TransaksiController::class, 'update'])->name('transaksi.update');
        Route::delete('/delete', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');

        Route::get('/siswa', [TransaksiController::class, 'transaksiSiswa'])->name('transaksi.siswa');
    });

    Route::resource('roles', RolesController::class);
    Route::resource('permissions', PermissionsController::class);
});
