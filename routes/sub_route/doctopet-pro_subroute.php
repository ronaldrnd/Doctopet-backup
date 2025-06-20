<?php


use Illuminate\Support\Facades\Route;



Route::get("/professionels/register",[\App\Http\Controllers\ProfessionalController::class,'register'])
    ->name('professionnels');


Route::get('/presentation/doctopet-pro', function () {
    return view('presentation.doctopet-pro');
})->name('presentation.doctopet-pro');



Route::get("/tester/doctopet-pro,",function () {
    return view("tester.doctopet-pro");
})->name("tester.doctopet-pro");


Route::get("/register/pro",function () {
    return view("auth.register-pro");
            })
    ->name("register.pro");
