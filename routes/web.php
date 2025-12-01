<?php

use App\Livewire\Ejd\EjdForm;
use App\Livewire\Ejd\EjdWizard;
use App\Livewire\OfferLetter\OfferLetterForm;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// EJD Form Routes
Route::get('/ejd', EjdWizard::class)->name('ejd.form');
Route::get('/ejd-new', EjdForm::class)->name('ejd.form-new'); // New single-page form for testing

// Offer Letter Routes
Route::get('/offer-letter', OfferLetterForm::class)->name('offer-letter.form');
