<?php

use App\Http\Controllers\Admin\BarangsController;
use App\Http\Controllers\Admin\CustomersController;
use App\Http\Controllers\Admin\JasasController;
use App\Http\Controllers\Admin\PerlengkapansController;
use App\Http\Controllers\Admin\PihakjasasController;
use App\Http\Controllers\Admin\SuppliersController;
use App\Http\Controllers\Admin\TruksController;
use App\Http\Controllers\HistoryPembelianController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PengecekanController;
use App\Http\Controllers\PenjualanController;
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

Route::get('/', function () {
    return view('welcome');
})->middleware('auth');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//master
Route::resource('/admin/suppliers',SuppliersController::class)->middleware('auth');

Route::resource('/admin/customers',CustomersController::class)->middleware('auth');

Route::resource('/admin/truks',TruksController::class)->middleware('auth');

Route::resource('/admin/pihakjasas',PihakjasasController::class)->middleware('auth');

Route::resource('/admin/jasas',JasasController::class)->middleware('auth');

Route::resource('/admin/barangs',BarangsController::class)->middleware('auth');

Route::resource('/admin/perlengkapans',PerlengkapansController::class)->middleware('auth');



//transaksi

Route::controller(PenjualanController::class)->group(function () {
    Route::get('/penjualan', 'index')->middleware('auth');
    Route::get('/penjualan/create','create')->name('penjualan.create')->middleware('auth');
    Route::post('/penjualan/store','store')->name('penjualan.store')->middleware('auth');
    Route::get('/penjualan/show/{id}','show')->name('penjualan.show')->middleware('auth');
    Route::get('/penjualan/edit/{id}','edit')->name('penjualan.edit')->middleware('auth');
    Route::post('/penjualan/update/{id}','update')->name('penjualan.update')->middleware('auth');
    Route::get('/penjualan/delete/{id}', 'destroy')->name('penjualan.delete')->middleware('auth');
});

Route::controller(PembelianController::class)->group(function () {
    Route::get('/pembelian', 'index')->middleware('auth');
    Route::get('/pembelian/create','create')->name('pembelian.create')->middleware('auth');
    Route::post('/pembelian/store','store')->name('pembelian.store')->middleware('auth');
    Route::get('/pembelian/show/{id}','show')->name('pembelian.show')->middleware('auth');
    Route::get('/pembelian/edit/{id}','edit')->name('pembelian.edit')->middleware('auth');
    Route::post('/pembelian/update/{id}','update')->name('pembelian.update')->middleware('auth');
    Route::get('/pembelian/delete/{id}', 'destroy')->name('pembelian.delete')->middleware('auth');
});

Route::controller(PengecekanController::class)->group(function () {
    Route::get('/pengecekan', 'index')->middleware('auth');
    Route::get('/pengecekan/create','create')->name('pengecekan.create')->middleware('auth');
    Route::post('/pengecekan/store','store')->name('pengecekan.store')->middleware('auth');
    Route::get('/pengecekan/show/{id}','show')->name('pengecekan.show')->middleware('auth');
    Route::get('/pengecekan/edit/{id}','edit')->name('pengecekan.edit')->middleware('auth');
    Route::post('/pengecekan/update/{id}','update')->name('pengecekan.update')->middleware('auth');
    Route::get('/pengecekan/delete/{id}', 'destroy')->name('pengecekan.delete')->middleware('auth');
});

Route::controller(HistoryPembelianController::class)->group(function(){
    Route::get('/history-pembelian/{itemId}','getHistory')->name('historypembelian.get');
});


