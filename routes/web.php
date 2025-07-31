<?php

use App\Livewire\Campaigns\Index;
use App\Livewire\Campaigns\Show;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');


Route::get('/campaigns',            Index::class)->name('campaigns.index');
Route::get('/campaigns/{project}',  Show::class)->name('campaigns.show');

Route::get('/map',            \App\Livewire\MapComponent::class)->name('map');
Route::get('/complaints',            \App\Livewire\Complaints\ComplaintsTable::class)->name('complaints');
Route::get('/complaints/{id}',            \App\Livewire\Complaints\ComplaintShow::class)->name('complaints.show');

require __DIR__.'/auth.php';
