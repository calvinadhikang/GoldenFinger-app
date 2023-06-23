<?php

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
    return view('login');
});
Route::post('/', [LoginController::class, "loginAction"]);
Route::get('/welcome', function () {
    return view('template/test');
});

Route::prefix('barang')->group(function () {
    Route::get('/', function () { return view('master/barang/view'); });
    Route::get('/add', function () { return view('master/barang/add'); });
    Route::get('/detail', function () { return view('master/barang/detail'); });
});

Route::prefix('karyawan')->group(function () {
    Route::get('/', function () { return view('master/karyawan/view'); });
    Route::get('/add', function () { return view('master/karyawan/add'); });
    Route::get('/detail', function () { return view('master/karyawan/detail'); });
});

Route::prefix('invoice')->group(function () {
    Route::get('/', function () { return view('master/invoice/view'); });
    Route::get('/add', function () { return view('master/invoice/add'); });
    Route::get('/detail', function () { return view('master/invoice/detail'); });
});

Route::prefix('po')->group(function () {
    Route::get('/', function () { return view('master/po/view'); });
    Route::get('/add', function () { return view('master/po/add'); });
    Route::get('/detail', function () { return view('master/po/detail'); });
});
