<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TripController;
use Illuminate\Support\Facades\Route;

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Dinas Dalam Negeri
    Route::get('/trips/dalam-negeri/create', [TripController::class, 'createDalamNegeri'])->name('trips.dalam-negeri.create');
    Route::post('/trips/dalam-negeri', [TripController::class, 'storeDalamNegeri'])->name('trips.dalam-negeri.store');
    Route::get('/trips/dalam-negeri/{id}/pdf', [TripController::class, 'generatePdfDalamNegeri'])->name('trips.dalam-negeri.pdf');

    // Dinas Luar Negeri
    Route::get('/trips/luar-negeri/create', [TripController::class, 'createLuarNegeri'])->name('trips.luar-negeri.create');
    Route::post('/trips/luar-negeri', [TripController::class, 'storeLuarNegeri'])->name('trips.luar-negeri.store');
    Route::get('/trips/luar-negeri/{id}/pdf', [TripController::class, 'generatePdfLuarNegeri'])->name('trips.luar-negeri.pdf');

    // Download PDF
    Route::get('/trips/{id}/download', [TripController::class, 'downloadPdf'])->name('trips.download');
});
