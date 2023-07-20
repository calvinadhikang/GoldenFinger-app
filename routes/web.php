<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\VendorController;
use App\Mail\TestHTMLMail;
use App\Models\Vendor;
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
Route::get('/test', function(){
    Mail::to('calvinadhikang@gmail.com')->send(new TestHTMLMail());
});

Route::get('/', [LoginController::class, "loginView"]);
Route::post('/', [LoginController::class, "loginAction"]);

Route::get('/master', [MasterController::class, "masterView"]);

Route::prefix('barang')->group(function () {
    Route::get('/', [BarangController::class, "barangView"]);
    Route::get('/add', [BarangController::class, "barangAddView"]);
    Route::get('/detail/{id}', [BarangController::class, "barangDetailView"]);

    Route::post('/add', [BarangController::class, "barangAddAction"]);
    Route::post('/detail/{id}', [BarangController::class, "barangDetailAction"]);
});

// Note : vendor -> tidak bisa, sudah terpakai dri framework/sistem
Route::prefix('vendors')->group(function () {
    Route::get('/', [VendorController::class, "vendorView"]);
    Route::get('/add', [VendorController::class, "vendorAddView"]);
    Route::get('/detail/{id}', [VendorController::class, "vendorDetailView"]);

    Route::post('/add', [VendorController::class, "vendorAddAction"]);
    Route::post('/detail/{id}', [VendorController::class, "vendorDetailAction"]);

    Route::get('/add/barang/{id}', [VendorController::class, "vendorAddBarangView"]);
    Route::post('/add/barang/{id}', [VendorController::class, "vendorAddBarangAction"]);
    Route::get('/add/harga', [VendorController::class, "vendorAddBarangHargaView"]);
    Route::post('/add/harga', [VendorController::class, "vendorAddBarangHargaAction"]);
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
    Route::get('/detail', function () { return view('master/invoice/detail'); });

    Route::get('/add', [InvoiceController::class, 'invoiceAddView']);
    Route::post('/add', [InvoiceController::class, 'invoiceAddAction']);

    Route::get('/confirmation', [InvoiceController::class, 'invoiceConfirmationView']);
    Route::post('/confirmation', [InvoiceController::class, 'invoiceConfirmationAction']);
});

Route::prefix('po')->group(function () {
    Route::get('/', function () { return view('master/po/view'); });
    Route::get('/barang', function () { return view('master/po/barang'); });
    Route::get('/vendor', function () { return view('master/po/vendor'); });
    Route::get('/konfirmasi', function () { return view('master/po/konfirmasi'); });
    Route::get('/detail', function () { return view('master/po/detail'); });
});
