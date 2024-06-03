<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('/data')->group(function () {
    Route::get('/jp', [App\Http\Controllers\AnotherDatabase\JpController::class, 'list']);
    Route::get('/mba', [App\Http\Controllers\AnotherDatabase\MbaController::class, 'list']);
    Route::get('/nugroho', [App\Http\Controllers\AnotherDatabase\NugrohoController::class, 'list']);
    Route::get('/pilar', [App\Http\Controllers\AnotherDatabase\PilarController::class, 'list']);
    Route::get('/rahluna', [App\Http\Controllers\AnotherDatabase\RahlunaController::class, 'list']);
    Route::get('/zelea', [App\Http\Controllers\AnotherDatabase\ZeleaController::class, 'list']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user/current', [AuthController::class, 'current']);
    Route::post('/user/profile', [AuthController::class, 'editProfile']);

    Route::post('/material/pay', [MaterialController::class, 'pay']);
    Route::apiResource('/material', MaterialController::class);

    Route::post('/customer/pay', [CustomerController::class, 'pay']);
    Route::apiResource('/customer', CustomerController::class);

    Route::get('/payment/annual-summary', [PaymentController::class, 'getAnnualPaymentSummary']);
    Route::apiResource('/payment', PaymentController::class)->except(['store', 'destroy']);

    Route::get('/filename', [FileController::class, 'show']);
});
