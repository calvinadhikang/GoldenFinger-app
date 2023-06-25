<?php

use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MasterController;
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

Route::get('/', [LoginController::class, "loginView"]);
Route::post('/', [LoginController::class, "loginAction"]);

Route::get('/master', [MasterController::class, "masterView"]);

Route::prefix('barang')->group(function () {
    Route::get('/', function () { return view('master/barang/view'); });
    Route::get('/add', function () { return view('master/barang/add'); });
    Route::get('/detail', function () { return view('master/barang/detail'); });
});

Route::prefix('customer')->group(function () {
    Route::get('/', function () { return view('master/customer/view'); });
    Route::get('/add', function () { return view('master/customer/add'); });
    Route::get('/detail', function () { return view('master/customer/detail'); });
});

Route::prefix('karyawan')->group(function () {
    Route::get('/', [KaryawanController::class, "karyawanView"]);
    Route::get('/add', [KaryawanController::class, "karyawanAddView"]);
    Route::get('/detail/{id}', [KaryawanController::class, "karyawanDetailView"]);

    Route::post('/add', [KaryawanController::class, "karyawanAddAction"]);
    Route::post('/detail/{id}', [KaryawanController::class, "karyawanDetailAction"]);
});

Route::prefix('invoice')->group(function () {
    Route::get('/', function () { return view('master/invoice/view'); });
    Route::get('/add', function () { return view('master/invoice/add'); });
    Route::get('/detail', function () { return view('master/invoice/detail'); });
});

Route::prefix('po')->group(function () {
    Route::get('/', function () { return view('master/po/view'); });
    Route::get('/barang', function () { return view('master/po/barang'); });
    Route::get('/vendor', function () { return view('master/po/vendor'); });
    Route::get('/konfirmasi', function () { return view('master/po/konfirmasi'); });
    Route::get('/detail', function () { return view('master/po/detail'); });
});
