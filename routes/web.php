<?php

use App\Livewire\Ejd\EjdWizard;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// EJD Form Routes
Route::get('/ejd', EjdWizard::class)->name('ejd.form');
