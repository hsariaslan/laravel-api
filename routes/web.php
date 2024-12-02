<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth.redirect')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
});

Route::middleware('check.jwt')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/report', [TransactionController::class, 'report'])->name('report');
    Route::get('/get-transaction', [TransactionController::class, 'getTransaction'])->name('get_transaction');

    Route::get('/client', [ClientController::class, 'index'])->name('client');

    Route::prefix('/proxy')->group(function () {
        Route::post('/transactions/report', [TransactionController::class, 'reportAjax'])->name('transactions.report.ajax');
        Route::post('/client', [ClientController::class, 'clientAjax'])->name('client.ajax');
    });
});
