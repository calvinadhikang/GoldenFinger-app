<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OperationalCostController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SharesController;
use App\Models\OperationalCost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('customer')->group(function () {
    Route::get('/', [CustomerController::class, 'getCustomer']);
});
Route::prefix('/cost')->group(function () {
    Route::get('/monthly', [OperationalCostController::class, 'getMonthlyCost']);
});
Route::prefix('/invoice')->group(function () {
    Route::get('/sold/items', [InvoiceController::class, 'getTotalPartSoldThisYear']);
    Route::get('/paid/monthly', [InvoiceController::class, 'getPaidInvoiceThisMonth']);
    Route::get('/overdue', [InvoiceController::class, 'getOverdueInvoices']);
});
Route::prefix('/po')->group(function () {
    Route::get('/due', [PurchaseController::class, 'countDue']);
    Route::get('/monthly', [PurchaseController::class, 'getThisMonth']);
});
Route::prefix('/barang')->group(function () {
    Route::get('/minimum', [BarangController::class, 'getMinimum']);
    Route::get('/', [BarangController::class, 'getAllBarang']);
});
Route::prefix('/shares')->group(function () {
    Route::get('/', [SharesController::class, 'getSharesData']);
});
