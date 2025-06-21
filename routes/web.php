<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\Web\DashboardController;


Route::get('/', function () {
    return view('welcome');
});

Route::controller(GoogleController::class)
    ->group(function () {
        Route::get('/google', 'redirect');
        Route::get('/google/callback', 'callback');
    });

Route::get('/donation/success', [DonationController::class, 'successview'])->name('donation.success');
Route::get('/donation/cancel', [DonationController::class, 'cancel'])->name('donation.cancel');


