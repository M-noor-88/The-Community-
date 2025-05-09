<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;


Route::get('/', function () {
    return view('welcome');
});



Route::controller(GoogleController::class)
    ->group(function () {
        Route::get('/google', 'redirect');
        Route::get('/google/callback', 'callback');
    });

