<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::middleware('auth.redirect')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
});

Route::middleware('check.jwt')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/report', [TransactionController::class, 'report'])->name('report');

    Route::get('/about', [HomeController::class, 'index'])->name('about');

//    Route::get('/transactions/report', function () {
//        $response = Http::withHeaders([
//            'Authorization' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJtZXJjaGFudFVzZXJJZCI6NTMsInJvbGUiOiJ1c2VyIiwibWVyY2hhbnRJZCI6Mywic3ViTWVyY2hhbnRJZHMiOlszLDc0LDkzLDExOTEsMTI5NSwxMTEsMTM3LDEzOCwxNDIsMTQ1LDE0NiwxNTMsMzM0LDE3NSwxODQsMjIwLDIyMSwyMjIsMjIzLDI5NCwzMjIsMzIzLDMyNywzMjksMzMwLDM0OSwzOTAsMzkxLDQ1NSw0NTYsNDc5LDQ4OCw1NjMsMTE0OSw1NzAsMTEzOCwxMTU2LDExNTcsMTE1OCwxMTc5LDEyOTMsMTI5NCwxMzA2LDEzMDcsMTMyNCwxMzMxLDEzMzgsMTMzOSwxMzQxLDEzNDYsMTM0NywxMzQ4LDEzNDksMTM1MywxMzgzLDEzODQsMTM4NV0sInRpbWVzdGFtcCI6MTczMzA4ODYzMn0.Mo3HituG7VNAzSY2fdtNUst9FldBn6eOYJc_RX9mxmM',
//            'Accept' => 'application/json',
//        ])->post('https://sandbox-reporting.rpdpymnt.com/api/v3/transactions/report', [
//            'fromDate' => '2020-07-01',
//            'toDate' => '2024-12-03',
//            'merchant' => 1,
//            'acquirer' => 1,
//        ]);
//
//        return $response->body();
//    });
});

Route::get('/transaction/list', function () {
    $response = Http::withHeaders([
        'Authorization' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJtZXJjaGFudFVzZXJJZCI6NTMsInJvbGUiOiJ1c2VyIiwibWVyY2hhbnRJZCI6Mywic3ViTWVyY2hhbnRJZHMiOlszLDc0LDkzLDExOTEsMTI5NSwxMTEsMTM3LDEzOCwxNDIsMTQ1LDE0NiwxNTMsMzM0LDE3NSwxODQsMjIwLDIyMSwyMjIsMjIzLDI5NCwzMjIsMzIzLDMyNywzMjksMzMwLDM0OSwzOTAsMzkxLDQ1NSw0NTYsNDc5LDQ4OCw1NjMsMTE0OSw1NzAsMTEzOCwxMTU2LDExNTcsMTE1OCwxMTc5LDEyOTMsMTI5NCwxMzA2LDEzMDcsMTMyNCwxMzMxLDEzMzgsMTMzOSwxMzQxLDEzNDYsMTM0NywxMzQ4LDEzNDksMTM1MywxMzgzLDEzODQsMTM4NV0sInRpbWVzdGFtcCI6MTczMzA4ODYzMn0.Mo3HituG7VNAzSY2fdtNUst9FldBn6eOYJc_RX9mxmM',
        'Accept' => 'application/json',
    ])->post('https://sandbox-reporting.rpdpymnt.com/api/v3/transaction/list', [

    ]);

    return $response->body();
});

Route::get('/transaction', function () {
    $response = Http::withHeaders([
        'Authorization' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJtZXJjaGFudFVzZXJJZCI6NTMsInJvbGUiOiJ1c2VyIiwibWVyY2hhbnRJZCI6Mywic3ViTWVyY2hhbnRJZHMiOlszLDc0LDkzLDExOTEsMTI5NSwxMTEsMTM3LDEzOCwxNDIsMTQ1LDE0NiwxNTMsMzM0LDE3NSwxODQsMjIwLDIyMSwyMjIsMjIzLDI5NCwzMjIsMzIzLDMyNywzMjksMzMwLDM0OSwzOTAsMzkxLDQ1NSw0NTYsNDc5LDQ4OCw1NjMsMTE0OSw1NzAsMTEzOCwxMTU2LDExNTcsMTE1OCwxMTc5LDEyOTMsMTI5NCwxMzA2LDEzMDcsMTMyNCwxMzMxLDEzMzgsMTMzOSwxMzQxLDEzNDYsMTM0NywxMzQ4LDEzNDksMTM1MywxMzgzLDEzODQsMTM4NV0sInRpbWVzdGFtcCI6MTczMzA4ODYzMn0.Mo3HituG7VNAzSY2fdtNUst9FldBn6eOYJc_RX9mxmM',
        'Accept' => 'application/json',
    ])->post('https://sandbox-reporting.rpdpymnt.com/api/v3/transaction', [
        "transactionId" => "1-1444392550-1"
    ]);

    return $response->body();
});

Route::get('/client', function () {
    $response = Http::withHeaders([
        'Authorization' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJtZXJjaGFudFVzZXJJZCI6NTMsInJvbGUiOiJ1c2VyIiwibWVyY2hhbnRJZCI6Mywic3ViTWVyY2hhbnRJZHMiOlszLDc0LDkzLDExOTEsMTI5NSwxMTEsMTM3LDEzOCwxNDIsMTQ1LDE0NiwxNTMsMzM0LDE3NSwxODQsMjIwLDIyMSwyMjIsMjIzLDI5NCwzMjIsMzIzLDMyNywzMjksMzMwLDM0OSwzOTAsMzkxLDQ1NSw0NTYsNDc5LDQ4OCw1NjMsMTE0OSw1NzAsMTEzOCwxMTU2LDExNTcsMTE1OCwxMTc5LDEyOTMsMTI5NCwxMzA2LDEzMDcsMTMyNCwxMzMxLDEzMzgsMTMzOSwxMzQxLDEzNDYsMTM0NywxMzQ4LDEzNDksMTM1MywxMzgzLDEzODQsMTM4NV0sInRpbWVzdGFtcCI6MTczMzA4ODYzMn0.Mo3HituG7VNAzSY2fdtNUst9FldBn6eOYJc_RX9mxmM',
        'Accept' => 'application/json',
    ])->post('https://sandbox-reporting.rpdpymnt.com/api/v3/client', [
        "transactionId" => "1-1444392550-1"
    ]);

    return $response->body();
});
