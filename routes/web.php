<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\BucController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PayreqApprovedController;
use App\Http\Controllers\PayreqOutgoingController;
use App\Http\Controllers\PayreqRealizationController;
use App\Http\Controllers\PayreqVerifyController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');

    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/users/data', [UserController::class, 'data'])->name('users.data');
    Route::resource('users', UserController::class);

    Route::prefix('roles')->name('roles.')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('index');
        Route::get('/create', [RoleController::class, 'create'])->name('create');
        Route::post('/', [RoleController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [RoleController::class, 'edit'])->name('edit');
        Route::put('/{id}', [RoleController::class, 'update'])->name('update');
    });

    Route::prefix('permissions')->name('permissions.')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('index');
        Route::get('/create', [PermissionController::class, 'create'])->name('create');
        Route::post('/', [PermissionController::class, 'store'])->name('store');
    });

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', [UserDashboardController::class, 'index'])->name('index');
        Route::get('/{id}', [UserDashboardController::class, 'show'])->name('show');
    });

    Route::prefix('realization')->name('realization.')->group(function () {
        Route::get('/data', [PayreqRealizationController::class, 'data'])->name('data');
        Route::get('/', [PayreqRealizationController::class, 'index'])->name('index');
        Route::put('/{id}', [PayreqRealizationController::class, 'update'])->name('update');
    });

    Route::prefix('outgoing')->name('outgoing.')->group(function () {
        Route::get('/data', [PayreqOutgoingController::class, 'data'])->name('data');
        Route::get('/', [PayreqOutgoingController::class, 'index'])->name('index');
        Route::put('/{id}', [PayreqOutgoingController::class, 'update'])->name('update');
        Route::get('/{id}/split', [PayreqOutgoingController::class, 'split'])->name('split');
        Route::put('/{id}/update-split', [PayreqOutgoingController::class, 'split_update'])->name('split_update');
        Route::put('/{id}/auto', [PayreqOutgoingController::class, 'auto_update'])->name('auto_update');
    });

    Route::prefix('verify')->name('verify.')->group(function () {
        Route::get('/data', [PayreqVerifyController::class, 'data'])->name('data');
        Route::get('/', [PayreqVerifyController::class, 'index'])->name('index');
        Route::put('/{id}', [PayreqVerifyController::class, 'update'])->name('update');
    });

    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/report1', [ReportController::class, 'report1_index'])->name('report1.index');
        Route::get('/report1/{id}/edit', [ReportController::class, 'report1_edit'])->name('report1.edit');
        Route::put('/report1/{id}', [ReportController::class, 'report1_update'])->name('report1.update');
        Route::delete('/report1/{id}', [ReportController::class, 'report1_destroy'])->name('report1.destroy');
        Route::post('/report1/display', [ReportController::class, 'report1_display'])->name('report1.display');
    });

    Route::get('approved/data', [PayreqApprovedController::class, 'data'])->name('approved.data');
    Route::resource('approved', PayreqApprovedController::class);

    Route::get('bucs/data', [BucController::class, 'data'])->name('bucs.data');
    Route::get('bucs/{buc_id}/data', [BucController::class, 'payreq_data'])->name('bucs.payreq_data');
    Route::resource('bucs', BucController::class);

    Route::get('account/data', [AccountController::class, 'data'])->name('account.data');
    Route::post('account/transaksi-store', [AccountController::class, 'transaksi_store'])->name('account.transaksi_store');
    Route::resource('account', AccountController::class);

    Route::get('transaksi/data', [TransaksiController::class, 'data'])->name('transaksi.data');
    Route::resource('transaksi', TransaksiController::class);
});
