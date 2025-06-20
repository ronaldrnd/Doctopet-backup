<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimalController;

// Animals Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('animals', \App\Http\Controllers\AnimalController::class);
});


Route::get('/animaux', [\App\Http\Controllers\AnimalController::class,'index'])
    ->middleware(['auth', 'verified'])
    ->name('animaux.index');


Route::get('/animal/{id}',[\App\Http\Controllers\AnimalController::class,'view'])->name('animal.view');


