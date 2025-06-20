<?php

use Illuminate\Support\Facades\Route;

Route::get("/compta/",[\App\Http\Controllers\ComptabiliteController::class,'index'])
    ->middleware("auth")
    ->name("compta.index");
