<?php


use Illuminate\Support\Facades\Route;


Route::get("/urgences",[\App\Http\Controllers\UrgenceController::class,'overview'])
    ->name("urgences");


Route::get('/urgence-journee',[\App\Http\Controllers\UrgenceController::class,'journee'])->name('urgence.journee');


