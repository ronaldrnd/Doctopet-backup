<?php
use Illuminate\Support\Facades\Route;
use \Illuminate\Support\Facades\Auth;

// Professional Services Route
Route::middleware(['auth', 'verified'])->get('/professional/services', [\App\Http\Controllers\ProfessionalController::class, 'Overview'])->name('professional.services');
Route::middleware(['auth', 'verified'])->get('/professional/service/{id}', [\App\Http\Controllers\ProfessionalController::class, 'view'])->name('professional.service');


Route::get('/specialities/{id}', [\App\Http\Controllers\SpecialityController::class, 'index'])->name('specialities.index');

Route::get('/professionals/list', [\App\Http\Controllers\SpecialityController::class, 'list'])->name('professional.list');



Route::post('/switch-mode', function () {
    if (Auth::check() && Auth::user()->estSpecialiste()) {
        $currentMode = session('user_mode', 'pro');
        $newMode = $currentMode === 'pro' ? 'client' : 'pro';
        session()->put('user_mode', $newMode);
    }
    return redirect()->back();
})->name('switch.mode');
