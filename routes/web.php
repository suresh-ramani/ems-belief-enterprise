<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{IndustryController, MeterController, HomeController, UserController};

Route::redirect('/', '/home');

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'superadmin'])->group(function () {
    Route::resource('industries', IndustryController::class);
    Route::resource('meters', MeterController::class);
    Route::resource('users', UserController::class);
});