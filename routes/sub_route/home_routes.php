<?php
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    //if(\Illuminate\Support\Facades\Auth::user())
        //return redirect()->route('dashboard');
    return view('home');
})
    ->name("/");
    //->middleware("password-pre-prod");


Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class,'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
//'password-pre-prod'


Route::get('/home', function () {
    return redirect()->route('dashboard');
})->name("home");

