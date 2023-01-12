<?php

use App\Http\Controllers\JenisTagihanController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\KelasSiswaController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\TabunganController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\TahunController;
use App\Http\Controllers\TransaksiController;

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
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    /**
     * Tabungan Routes
     */
    Route::group(['prefix' => 'tabungan'], function () {
        Route::get('/', [TabunganController::class, 'index'])->name('tabungan.index');
        Route::get('/create', [TabunganController::class, 'create'])->name('tabungan.create');
        Route::post('/create', [TabunganController::class, 'store'])->name('tabungan.store');
        Route::get('/{tabungan}/show', [TabunganController::class, 'show'])->name('tabungan.show');
        Route::get('/{tabungan}/edit', [TabunganController::class, 'edit'])->name('tabungan.edit');
        Route::patch('/{tabungan}/update', [TabunganController::class, 'update'])->name('tabungan.update');
        Route::delete('/{tabungan}/delete', [TabunganController::class, 'destroy'])->name('tabungan.destroy');
    });

    /**
     * Tahun Ajaran Routes
     */
    Route::group(['prefix' => 'tahun'], function () {
        Route::get('/', [TahunController::class, 'index'])->name('tahun.index');
        Route::get('/create', [TahunController::class, 'create'])->name('tahun.create');
        Route::post('/create', [TahunController::class, 'store'])->name('tahun.store');
        Route::get('/{id}/show', [TahunController::class, 'show'])->name('tahun.show');
        Route::get('/{id}/edit', [TahunController::class, 'edit'])->name('tahun.edit');
        Route::patch('/update', [TahunController::class, 'update'])->name('tahun.update');
        Route::delete('/delete', [TahunController::class, 'destroy'])->name('tahun.destroy');
    });

    /**
     * Tagihan Routes
     */
    Route::group(['prefix' => 'tagihan'], function () {
        Route::get('/', [TagihanController::class, 'index'])->name('tagihan.index');
        Route::get('/create', [TagihanController::class, 'create'])->name('tagihan.create');
        Route::post('/create', [TagihanController::class, 'store'])->name('tagihan.store');
        Route::get('/{tagihan}/show', [TagihanController::class, 'show'])->name('tagihan.show');
        Route::get('/{tagihan}/edit', [TagihanController::class, 'edit'])->name('tagihan.edit');
        Route::patch('/{tagihan}/update', [TagihanController::class, 'update'])->name('tagihan.update');
        Route::delete('/{tagihan}/delete', [TagihanController::class, 'destroy'])->name('tagihan.destroy');
    });

    /**
     * Kelas Routes
     */
    Route::resource('jenis-tagihan', JenisTagihanController::class)->names('jenis-tagihan');

    /**
     * Kelas Routes
     */

    Route::group(['prefix' => 'kelas'], function () {
        Route::resource('/', KelasController::class)->names('kelas');

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
        Route::post('/create', [SiswaController::class, 'store'])->name('siswa.store');
        Route::get('/{siswa}/show', [SiswaController::class, 'show'])->name('siswa.show');
        Route::get('/{siswa}/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
        Route::patch('/{siswa}/update', [SiswaController::class, 'update'])->name('siswa.update');
        Route::delete('/{siswa}/delete', [SiswaController::class, 'destroy'])->name('siswa.destroy');
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

    Route::resource('transaksi', TransaksiController::class)->names('transaksi');
    Route::resource('roles', RolesController::class);
    Route::resource('permissions', PermissionsController::class);
});
