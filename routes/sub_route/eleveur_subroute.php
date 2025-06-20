<?php

use Illuminate\Support\Facades\Route;



Route::get("/formulaire/eleveur",[\App\Http\Controllers\EleveurController::class,'Formulaire'])
    ->middleware("auth")
    ->name("find.breeder");

Route::get("/eleveur/dashboard",[\App\Http\Controllers\EleveurController::class,'DashboardEleveur'])
    ->middleware("auth")
    ->name("dashboard.eleveur");


Route::get("/eleveur/contact/{id}",[\App\Http\Controllers\EleveurController::class,'ContactEleveur'])
    ->name("contact-breeder");
