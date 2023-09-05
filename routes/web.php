<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\OperationalCostController;
use App\Http\Controllers\VendorController;
use App\Mail\TestHTMLMail;
use App\Models\Vendor;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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
// Route::get('/test', function(){
//     Mail::to('calvinadhikang@gmail.com')->send(new TestHTMLMail());
// });

Route::get('/', [LoginController::class, "loginView"]);
Route::post('/', [LoginController::class, "loginAction"]);

Route::get('/dashboard', [MasterController::class, "dashboardView"]);

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

    Route::get('/add/contact/{id}', [VendorController::class, 'vendorAddContactView']);
    Route::post('/add/contact/{id}', [VendorController::class, 'vendorAddContactAction']);

    Route::post('/remove/contact/{id}', [VendorController::class, 'vendorRemoveContactAction']);

    Route::get('/add/barang/{id}', [VendorController::class, "vendorAddBarangView"]);
    Route::post('/add/barang/{id}', [VendorController::class, "vendorAddBarangAction"]);
    Route::get('/add/harga', [VendorController::class, "vendorAddBarangHargaView"]);
    Route::post('/add/harga', [VendorController::class, "vendorAddBarangHargaAction"]);
});

Route::prefix('customer')->group(function () {
    Route::get('/', [CustomerController::class, 'customerView']);
    Route::get('/add', [CustomerController::class, 'customerAddView']);
    Route::get('/detail/{id}', [CustomerController::class, 'customerDetailView']);

    Route::post('/add', [CustomerController::class, "customerAddAction"]);
    Route::post('/detail/{id}', [CustomerController::class, 'customerDetailAction']);
});

Route::prefix('cost')->group(function () {
    Route::get('/', [OperationalCostController::class, 'costView']);
    Route::get('/add', [OperationalCostController::class, 'costAddView']);

    Route::post('/add', [OperationalCostController::class, 'costAddAction']);
});

Route::prefix('karyawan')->group(function () {
    Route::get('/', [KaryawanController::class, "karyawanView"]);
    Route::get('/add', [KaryawanController::class, "karyawanAddView"]);
    Route::get('/detail/{id}', [KaryawanController::class, "karyawanDetailView"]);

    Route::post('/add', [KaryawanController::class, "karyawanAddAction"]);
    Route::post('/detail/{id}', [KaryawanController::class, "karyawanDetailAction"]);
});

Route::prefix('invoice')->group(function () {
    Route::get('/', [InvoiceController::class, 'invoiceView']);
    Route::get('/detail/{id}', [InvoiceController::class, 'invoiceDetailView']);
    Route::post('/detail/{id}', [InvoiceController::class, 'createDocument']);

    Route::get('/add', [InvoiceController::class, 'invoiceAddView']);
    Route::post('/add', [InvoiceController::class, 'invoiceAddAction']);

    Route::get('/customer', [InvoiceController::class, 'invoiceCustomerView']);
    Route::post('/customer', [InvoiceController::class, 'invoiceCustomerAction']);

    Route::get('/confirmation', [InvoiceController::class, 'invoiceConfirmationView']);
    Route::post('/confirmation', [InvoiceController::class, 'invoiceConfirmationAction']);

    Route::get('/created', [InvoiceController::class, 'invoiceCreatedView']);

    Route::get('/reset', function() {
        Session::remove('invoice_cart');
    });
});

Route::prefix('po')->group(function () {
    Route::get('/', function () { return view('master/po/view'); });
    Route::get('/barang', function () { return view('master/po/barang'); });
    Route::get('/vendor', function () { return view('master/po/vendor'); });
    Route::get('/konfirmasi', function () { return view('master/po/konfirmasi'); });
    Route::get('/detail', function () { return view('master/po/detail'); });
});

Route::prefix('template')->group(function (){
    Route::get('/tanda_terima', function () { return view('template.dokumen.tanda_terima'); });
});
