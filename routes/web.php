<?php

use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return redirect('/login');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'loginView')->name('login')->middleware('guest');
    // Route::get('/register', 'registerView')->name('register')->middleware('guest');

    Route::post('login', 'login');
    Route::post('logout', 'logout')->name('logout');

    Route::get('user/profile', 'profileView')->name('user.profile')->middleware('auth');
});

Route::middleware('auth')->group(function () {
    Route::get('dashboard',  [DashboardController::class, 'index'])->name('dashboard');

    Route::get('customer', function () {
        return view('pages.customer');
    })->name('customer');

    Route::get('material', function () {
        return view('pages.material');
    })->name('material');

    Route::get('payment', function () {
        return view('pages.payment');
    })->name('payment');

    Route::get('oprasional', function () {
        return view('pages.oprasional');
    })->name('oprasional');

    Route::get('kelola-file', function () {
        return view('pages.file-manager');
    })->name('kelola-file');
});
