<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Bilpark ruter

    Route::get('/carpark', [CarController::class, 'index'])->name('carpark');
    Route::get('/carpark/create', [CarController::class, 'create'])->name('carpark.create');
    Route::get('/carpark/{registration_number}', [CarController::class, 'show'])->name('carpark.show');
    Route::post('/carpark', [CarController::class, 'store'])->name('carpark.store');
    Route::get('/carpark/{registration_number}/edit', [CarController::class, 'edit'])->name('carpark.edit');
    Route::put('/carpark/{registration_number}', [CarController::class, 'update'])->name('carpark.update');
    Route::delete('/carpark/{registration_number}', [CarController::class, 'delete'])->name('carpark.delete');

    // Bilpark ruter slutt


    // Service Ruter

    Route::get('/service', [ServiceController::class, 'index'])->name('service');
    Route::get('/service/create', [ServiceController::class, 'create'])->name('service.create');
    Route::post('/service', [ServiceController::class, 'store'])->name('service.store');
    Route::get('/service/{registration_number}/edit', [ServiceController::class, 'edit'])->name('service.edit');
    Route::put('/service/{registration_number}', [ServiceController::class, 'update'])->name('service.update');
    Route::delete('/service/{registration_number}', [ServiceController::class, 'delete'])->name('service.delete');

    // Service Ruter Slutt
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
