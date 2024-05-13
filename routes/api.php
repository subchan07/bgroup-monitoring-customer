<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/material/summaryByMonth', [MaterialController::class, 'summaryByMonth']);

    Route::post('/material/bayar', [MaterialController::class, 'bayar']);
    Route::apiResource('/material', MaterialController::class);

    Route::post('/customer/bayar', [CustomerController::class, 'bayar']);
    Route::apiResource('/customer', CustomerController::class);

    Route::apiResource('/payment', PaymentController::class)->except(['store', 'update', 'update']);
});
