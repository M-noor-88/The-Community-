<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Client\ClientProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('client')
    ->controller(AuthController::class)
    ->group(function () {
        Route::post('initiate_registration','initiate_registration');
        Route::post('confirm_registration', 'confirm_registration');
        Route::post('resend_code', 'resend_code');
        Route::post('reset_password', 'reset_password');
        Route::post('confirm_reset_password','confirm_reset_password');
        Route::post('login', 'login');
        Route::post('logout', 'logout')->middleware('auth:sanctum');
    });


// Profile Client
Route::prefix('client')
    ->controller(ClientProfileController::class)
    ->group(function () {
        Route::get('/profile/show/{id}', 'show');
        Route::get('/profile/show', 'show')->middleware('auth:sanctum');
        Route::post('/profile/update',  'update')->middleware('auth:sanctum');
    });









Route::prefix('volunteer')
    ->controller(AuthController::class)
    ->group(function () {
        Route::post('register', 'registerVolunteer');
        Route::post('login', 'login');
        Route::post('logout', 'logout')->middleware('auth:sanctum');
    });
