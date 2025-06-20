<?php

use Illuminate\Support\Facades\Route;


Route::get('/verify-email/{token}', [\App\Http\Controllers\EmailVerificationController::class, 'verify'])->name('email.verify');
