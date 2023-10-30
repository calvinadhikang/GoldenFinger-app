<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\OperationalCostController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SettingsController;
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

Route::get('/logout', function(){
    return redirect('/');
});

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

    Route::post('/remove', [OperationalCostController::class, 'costRemoveAction']);
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

    Route::get('/barang', [InvoiceController::class, 'invoiceBarangView']);
    Route::post('/barang', [InvoiceController::class, 'invoiceBarangAction']);

    Route::get('/customer', [InvoiceController::class, 'invoiceCustomerView']);
    Route::post('/customer', [InvoiceController::class, 'invoiceCustomerAction']);
    Route::post('/customer/new', [InvoiceController::class, 'customerAddAction']);
    Route::get('/customer/unset', [InvoiceController::class, 'invoiceCustomerUnsetAction']);

    Route::get('/confirmation', [InvoiceController::class, 'invoiceConfirmationView']);
    Route::post('/confirmation', [InvoiceController::class, 'invoiceConfirmationAction']);
    Route::post('/confirmation/ppn', [InvoiceController::class,'invoiceConfirmationPPN']);

    Route::get('/created', [InvoiceController::class, 'invoiceCreatedView']);
    Route::post('/finish', [InvoiceController::class, 'invoiceFinish']);

    Route::get('/reset', function() {
        Session::remove('invoice_cart');
    });
});

Route::prefix('po')->group(function () {
    Route::get('/', [PurchaseController::class, 'purchaseView']);

    Route::get('/detail/{id}', [PurchaseController::class, 'purchaseDetailView']);
    Route::get('/detail/{id}', [PurchaseController::class, 'purchaseDetailView']);

    Route::get('/barang', [PurchaseController::class, 'purchaseBarangView']);
    Route::post('/barang', [PurchaseController::class, 'purchaseBarangAdd']);

    Route::get('/vendor', [PurchaseController::class, 'purchaseVendorView']);
    Route::post('/vendor', [PurchaseController::class, 'purchaseVendorAdd']);

    Route::get('/confirmation', [PurchaseController::class, 'purchaseConfirmationView']);
    Route::post('/confirmation/ppn', [PurchaseController::class, 'purchaseConfirmationPPN']);
    Route::post('/confirmation', [PurchaseController::class, 'purchaseConfirmationAction']);

    //Finishing PO
    Route::post('/pesanan', [PurchaseController::class, 'finishPesanan']);
    Route::post('/pembayaran', [PurchaseController::class, 'finishPembayaran']);
});

Route::prefix('/settings')->group(function (){
    Route::get('/', [SettingsController::class, 'settingsView']);
});

Route::prefix('template')->group(function (){
    Route::get('/tanda_terima', function () { return view('template.dokumen.tanda_terima'); });
});
