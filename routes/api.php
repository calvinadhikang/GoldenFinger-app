<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OperationalCostController;
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
    Route::get('/monthly', [InvoiceController::class, 'getMonthlyPaidInvoice']);
});
