<?php

use App\Livewire\Ejd\EjdWizard;
use App\Livewire\OfferLetter\OfferLetterForm;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// EJD Form Routes
Route::get('/ejd', EjdWizard::class)->name('ejd.form');

// Offer Letter Routes
Route::get('/offer-letter', OfferLetterForm::class)->name('offer-letter.form');
