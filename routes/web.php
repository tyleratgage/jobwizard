<?php

use App\Livewire\Ejd\EjdForm;
use App\Livewire\OfferLetter\OfferLetterForm;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// EJD Form Routes
Route::get('/ejd', EjdForm::class)->name('ejd.form');

// Offer Letter Routes
Route::get('/offer-letter', OfferLetterForm::class)->name('offer-letter.form');
